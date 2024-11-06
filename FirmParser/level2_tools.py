import subprocess
import re
import os
from FirmParser.utils import *
from FirmParser.lib_parser import *
import json
import hashlib
import lief

EXCEPTION_CASE = ['ISS.exe', 'busybox']

class LevelTwoAnalyzer:
    def __init__(self, fs_path, bins, p_bin, v_bin, lib_infos, detail_opt):
        """
        This class will be use to parse each binary
        p_bin: public binary
        v_bin: vendor binary
        """
        self.fs_path = fs_path
        self.v_bin = v_bin
        self.p_bin = p_bin
        self.bin_list = bins
        self.bin_infos = dict()
        self.lib_infos = lib_infos
        self.detail_opt = detail_opt
    
    def generate_info(self):
        
        for bin in self.bin_list:
            try:
                if is_elf_file(bin):
                    target = binNode(bin, self.lib_infos)
                    try:
                        if any(exception in bin for exception in EXCEPTION_CASE) or not self.detail_opt:
                            print(f"\033[92m[+]\033[0m Just apply basic parse to {os.path.basename(bin)}.")
                            target.analyze_exception()
                            self.bin_infos[target.bin_name] = target.get_bin_info()
                        elif os.path.basename(bin) in self.v_bin or os.path.basename(bin) in self.p_bin or self.detail_opt:
                            print(f"\033[92m[+]\033[0m {os.path.basename(bin)} will be parsed more detail by using mango.")
                            target.analyze()
                            self.bin_infos[target.bin_name] = target.get_bin_info()
                        else:
                            print(f"\033[91m[-]\033[0m {os.path.basename(bin)} is exceptional case.")
                    except Exception as e:
                        print(f"\033[91m[-]\033[0m Error: [lv2] generate_info->{e}")
                else:
                    print("\033[91m[-]\033[0m This binary isn't ELF type.")
                    continue
            except Exception as e:
                print(f"\033[91m[-]\033[0m Error<{os.path.basename(bin)}>: [lv2] generate_info->{e}")
                continue
            
    def get_bin_infos(self):
        return self.bin_infos

# be used to node in level2Analyzer
class binNode:
    def __init__(self, bin, libs_info=dict()):
        self.bin_path = bin
        self.bin_name = os.path.basename(bin)
        self.bin_arch = None
        self.version_info = None
        self.is_static = None
        self.is_stripped = None
        self.used_libs = []
        self.lib_sym_pair = dict()
        self.libs_info = libs_info
        self.keywords = []
        self.nvram_env_used = None
        self.hash_value = None
        self.extra_symbols = []
        self.checksec = {
            # 0: No applied, 1: applied, 2: high level applied
            'RELRO': None,
            'Canary': None,
            'NX': None,
            'PIE': None,
            'rpath': None,
            'runpath': None,
        }
        self.features = {   # 바이너리가 수행하는 특정 기능
            'File_IO': False,
            'DB_handling': False,
            'Encryption': False,
            'TEE': False
        }
        self.interesting_str = {    # 바이너리 내 존재하는 흥미로운 문자열 후보
            "Key":[],
            "IV": [],
            "URL": [],
            "E-mail": [],
            "IP": []
        }
        
    def get_bin_info(self):
        info_dict = {
            # 'bin_name': self.bin_name,
            'bin_arch': self.bin_arch,
            'version_info': self.version_info,
            'is_static': self.is_static,
            'is_stripped': self.is_stripped,
            'used_libs': self.used_libs,
            'lib_sym_pair': self.lib_sym_pair,
            'extra_symbols': self.extra_symbols,
            'keywords': self.keywords,
            'used_nvram_env': self.nvram_env_used,
            'bdg': self.bdg,
            'facilities': self.features,
            'strings': self.interesting_str,
            'checksec': self.checksec,
            'hash_value': self.hash_value,
            'full_path': self.bin_path
        }
        return info_dict
    
    def analyze(self):
        try:
            print(f"\033[92m[+]\033[0m Now, Parse {self.bin_name}.")
            self.basic_parsing()
            self.calculate_file_hash()
            self.check_sec_opt()
            self.check_refer_env_nvram()
            self.check_used_library()
            self.make_lib_sym_pair()
            self.parse_facilities()
            self.find_interesting_str()
            print(f"\033[92m[+]\033[0m {self.bin_name} was parsed completely.")
            return 0
        except Exception as e:
            print(f"\033[91m[-]\033[0m Error: [lv2] analyze->{e}")
            return 1
        
    def analyze_exception(self):
        try:
            print(f"\033[92m[+]\033[0m Now, Parse {self.bin_name}.")
            self.basic_parsing()
            self.calculate_file_hash()
            self.check_sec_opt()
            self.check_used_library()
            self.make_lib_sym_pair()
            self.parse_facilities()
            self.find_interesting_str()
            self.keywords = 'Not parsed'
            self.nvram_env_used = 'Not parsed'
            print(f"\033[92m[+]\033[0m {self.bin_name} was parsed completely.")
            return 0
        except Exception as e:
            print(f"\033[91m[-]\033[0m Error: [lv2] analyze_exception->{e}")
            return 1

    def basic_parsing(self):
        """
        This method related to parse target binaries basic info
        - architecture
        - compile style(static or dynamic)
        - stripped or not
        <param>
        [bin]: target binary
        """
        notes = parse_notes(self.bin_path)
        self.version_info = get_version_info(notes)
        result = subprocess.run(['file', self.bin_path], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
        output = result.stdout.decode('utf-8')

        # check architecture
        arch_match = re.search(r'ELF.*?, ([^,]+),', output)
        if arch_match:
            self.bin_arch = arch_match.group(1)
        else:
            self.bin_arch = 'Unknown'

        # check static or not
        if 'statically linked' in output:
            self.is_static = 1
        elif 'dynamically linked' in output:
            self.is_static = 0
        else:
            self.is_static = 'Unknown'
        
        # check sripped or not
        if 'not stripped' in output:
            self.is_stripped = 0
        elif 'stripped' in output:
            self.is_stripped = 1
        else:
            self.is_stripped = 'Unknown'

    def check_used_library(self):
            try:
                # extract libraries from dynamic executable binaries
                if not self.is_static:
                    result = subprocess.run(['readelf', '-d', self.bin_path], stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
                    if result.returncode != 0:
                        print(f"\033[91m[-]\033[0m Error running readelf: {result.stderr}")
                        return
                    # processing result
                    lines = result.stdout.splitlines()
                    for line in lines:
                        match = re.search(r'library: \[(.*?)\]', line)
                        if match:
                            lib_name = match.group(1)
                            self.used_libs.append(lib_name)
                # extract libraries from static executable binaries
                else:
                    # if binary was stripped, we cannot find anything
                    if self.is_stripped:
                        self.used_libs = []
                    else:
                        try:
                            result = subprocess.run(['nm', '-D', self.bin_path], capture_output=True, text=True, check=True)
                            bin_sym = result.stdout.strip().split('\n')
                            if not bin_sym:
                                self.used_libs = []
                            for lib in self.libs_info:
                                if any(symbol in bin_sym for symbol in lib["symbols"]):
                                    self.used_libs.append(lib)

                        except subprocess.CalledProcessError as e:
                            print(f"\033[91m[-]\033[0m Error extracting symbols from {self.bin_name}: {e}")
                            return

            except Exception as e:
                print(f"\033[91m[-]\033[0m Error: [lv2] check_used_library->{e}")
                return
    
    def check_sec_opt(self):
        """
        This method finds the security option applied to target binary
        """
        self.check_relro()
        self.check_canary()
        self.check_nx()
        self.check_pie()
        self.check_rpath_runpath()
        
    def check_relro(self):
        try:
            # 'readelf -l <binary>'
            readelf_l_output = subprocess.check_output(['readelf', '-l', self.bin_path], stderr=subprocess.DEVNULL)
            readelf_l_output = readelf_l_output.decode('utf-8')

            # 'readelf -d <binary>'
            readelf_d_output = subprocess.check_output(['readelf', '-d', self.bin_path], stderr=subprocess.DEVNULL)
            readelf_d_output = readelf_d_output.decode('utf-8')

            # GNU_RELRO
            if 'GNU_RELRO' in readelf_l_output:
                # BIND_NOW
                if 'BIND_NOW' in readelf_d_output:
                    self.checksec['RELRO'] = 2      # Full RELRO
                else:
                    self.checksec['RELRO'] = 1      # Partial RELRO
            else:
                self.checksec['RELRO'] = 0          # No RELRO
        except subprocess.CalledProcessError:
            print(f'\033[91m[-]\033[0m Error: Unable to process the binary file.')

    def check_canary(self):
        try:
            # 'readelf -s <binary>'
            readelf_s_output = subprocess.check_output(['readelf', '-s', self.bin_path], stderr=subprocess.DEVNULL)
            readelf_s_output = readelf_s_output.decode('utf-8')

            # __stack_chk_fail
            if '__stack_chk_fail' in readelf_s_output:
                self.checksec['Canary'] = 1
            else:
                self.checksec['Canary'] = 0

        except subprocess.CalledProcessError:
            print('\033[91m[-]\033[0m Error: Unable to process the binary file.')

    def check_nx(self):
        try:
            # 'readelf -W -l <binary>'
            readelf_output = subprocess.check_output(['readelf', '-W', '-l', self.bin_path], stderr=subprocess.DEVNULL)
            readelf_output = readelf_output.decode('utf-8')

            # 'GNU_STACK' 및 'RWE'
            if 'GNU_STACK' in readelf_output and 'RWE' in readelf_output:
                self.checksec['NX'] = 0
            else:
                self.checksec['NX'] = 1
        except subprocess.CalledProcessError:
            print('\033[91m[-]\033[0m Error: Unable to process the binary file.')

    def check_pie(self):
        try:
            # 'readelf -h <binary>'
            readelf_header_output = subprocess.check_output(['readelf', '-h', self.bin_path], stderr=subprocess.DEVNULL)
            readelf_header_output = readelf_header_output.decode('utf-8')

            # 'readelf -d <binary>'
            readelf_dynamic_output = subprocess.check_output(['readelf', '-d', self.bin_path], stderr=subprocess.DEVNULL)
            readelf_dynamic_output = readelf_dynamic_output.decode('utf-8')

            # 'Type: EXEC'
            if re.search(r'Type:\s*EXEC', readelf_header_output):
                self.checksec['PIE'] = 0
            # 'Type: DYN'
            elif re.search(r'Type:\s*DYN', readelf_header_output):
                # 'DEBUG'
                if re.search(r'\(DEBUG\)', readelf_dynamic_output):
                    self.checksec['PIE'] = 1
                else:
                    print('\033[92m[+]\033[0m Library File')
            else:
                print('\033[91m[-]\033[0m Not an ELF file')

        except subprocess.CalledProcessError:
            print('\033[91m[-]\033[0m Error: Unable to process the binary file.')

    def check_rpath_runpath(self):
        try:
            rpath_output = subprocess.check_output(["readelf", "-d", self.bin_path])
            rpath_lines = rpath_output.decode().split("\n")
            has_rpath = any("rpath" in line for line in rpath_lines)
            has_runpath = any("runpath" in line for line in rpath_lines)
            if has_rpath:
                self.checksec['rpath'] = 1
            else:
                self.checksec['rpath'] = 0
            
            if has_runpath:
                self.checksec['runpath'] = 1
            else:
                self.checksec['runpath'] = 0

        except subprocess.CalledProcessError:
            print('\033[91m[-]\033[0m Error: Unable to process the binary file.')

    def check_refer_env_nvram(self):
        # take json data
        jpath = run_env_resolve(self.bin_path, '/tmp/')
        if not jpath or jpath == -1:
            self.nvram_env_used = 0
            return

        try:
            with open(jpath, 'r', encoding='utf-8') as file:
                data = json.load(file)
                if len(data.get('results', [])) > 0:
                    self.nvram_env_used = 1
                    # Revision Position
                    # extract keywords -> 이 부분에서 키워드 추가 (여기서 해당 키워드를 인자로 사용하는 함수 이름까지 가져오면 Setter-Getter Chain 연결 가능)
                    for func_name, func_data in data.get("results", {}).items():
                        if isinstance(func_data, dict):
                            for key_name in func_data.keys():
                                self.keywords.append(key_name)
                else:
                    self.nvram_env_used = 0

                # remove duplicate
                self.keywords = list(set(self.keywords))
        except Exception as e:
            print(f"\033[91m[-]\033[0m Error reading JSON file: {e}")
            self.nvram_env_used = 0
        finally:
            try:
                if os.path.exists(jpath):
                    os.remove(jpath)
            except Exception as e:
                print(f"\033[91m[-]\033[0m Error deleting JSON file: {e}")
    
    def make_lib_sym_pair(self):
        try:
            # binary symbol
            symbols = extract_symbols_from_binary(self.bin_path)
            for bin_sym in symbols:
                find_flag = False
                for lib in self.used_libs:
                    if find_flag:
                        break
                    # Ensure lib exists in the pair with default version and empty symbols list
                    lib_name = os.path.basename(lib)
                    if lib_name not in self.lib_sym_pair:
                        self.lib_sym_pair[lib_name] = {
                            "version": "latest",
                            "symbols": []
                        }
                    # Check if lib information is available and process it
                    if lib_name in self.libs_info:
                        lib_info = self.libs_info[lib_name]
                        self.lib_sym_pair[lib_name]["version"] = lib_info.get("version", "latest")
                        
                        # Iterate over the symbols provided in lib_info
                        for sym in lib_info.get("symbols", []):
                            if bin_sym == sym:
                                find_flag = True
                                self.lib_sym_pair[lib_name]["symbols"].append(bin_sym)
                                break
                if not find_flag:
                    self.extra_symbols.append(bin_sym)
            
            # Remove entries with empty symbol lists or default values after processing
            self.lib_sym_pair = remove_empty_values(self.lib_sym_pair)
            self.extra_symbols = list(set(self.extra_symbols))

        except Exception as e:
            print(f"\033[91m[-]\033[0m Error: [lv2] make_lib_sym_pair->{e}")
            return
                  
    def calculate_file_hash(self, hash_algo='sha256'):
        """Calculates the hash of a file using the specified hashing algorithm."""
        hash_func = hashlib.new(hash_algo)
        with open(self.bin_path, 'rb') as f:
            # Read and update hash string value in blocks of 4K
            for byte_block in iter(lambda: f.read(4096), b""):
                hash_func.update(byte_block)
        self.hash_value = hash_func.hexdigest()

    def parse_facilities(self):
        """
         바이너리의 내부 기능에 대해 분석하는 함수
         [파일 IO 기능, DB 핸들링 기능, 암호화 기능]
        """
        bin = lief.parse(self.bin_path)
        for func in bin.imported_functions:
            for cand in IO_FUNC:
                if cand in func.name:
                    self.features["File_IO"] = True
            # DB 핸들링 관련
            for cand in DB_FUNC:
                if cand in func.name:
                    self.features["DB_handling"] = True
            # 암호화 관련
            for cand in ENC_FUNC:
                if cand in func.name :
                    self.features["Encryption"] = True
            for cand in TEE_FUNC:
                if cand in func.name:
                    self.features["TEE"] = True

    def find_interesting_str(self):
        """
         바이너리 내 흥미로운 문자열 수집하는 함수 (e.g., 암호키, IV, URL, E-mail, IP 등)
        """
        strings = extract_strings(self.bin_path)
        
        # 기존에 찾아놨던 문자열 패턴을 활용하여 분석
        for string in strings:
            for key, pattern in STR_PATTERNS.items():
                if (key=='Key' or key=='IV') and self.features['Encryption']==False:
                    continue    # 암호화와 관련된 바이너리가 아닌 경우 Key가 있을 필요가 없음 --> 무시하고 진행
                if re.search(pattern, string):
                    self.interesting_str[key].append(string)

        # 중복 제거
        for key, str in self.interesting_str.items():
            self.interesting_str[key] = list(set(self.interesting_str[key]))

    # def find_binary_symbols(self):
    #     try:
    #         readelf_s_output = subprocess.check_output(['readelf', '-s', '--wide',  self.bin_path], stderr=subprocess.DEVNULL)
    #         readelf_s_output = readelf_s_output.decode('utf-8')
    #         lines = readelf_s_output.split('\n')
            
    #         header_found = False
    #         symbols = []

    #         for line in lines:
    #             if 'Num:' in line:
    #                 header_found = True
    #                 continue
                
    #             if not header_found:
    #                 continue
                
    #             columns = line.split()
    #             if len(columns) < 8:
    #                 continue

    #             try:
    #                 sym_type = columns[3]
    #                 name = columns[-1]
    #                 function_name = name.split('@')[0]
    #                 if sym_type == 'FUNC':
    #                     # 공통 심볼 제외
    #                     if function_name in COMMON_SYM:
    #                         continue
    #                     symbols.append(function_name)
    #             except ValueError:
    #                 print(f"\033[91m[-]\033[0m Error extracting symbols from {self.bin_name}: find_binary_symbols->{e}")
    #                 continue
    #         # 심볼 중복 제거 후 반환
    #         return list(set(symbols))
            
        # except subprocess.CalledProcessError as e:
        #     print(f"\033[91m[-]\033[0m Error extracting symbols from {self.bin_name}: find_binary_symbols->{e}")
        #     return []