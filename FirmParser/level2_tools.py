import subprocess
import re
import os
from FirmParser.utils import *
from FirmParser.lib_parser import *
import json
import hashlib

EXCEPTION_CASE = ['ISS.exe', 'busybox']

class LevelTwoAnalyzer:
    def __init__(self, fs_path, bin_list):
        """
        This class will be use to parse each binary
        """
        self.fs_path = fs_path
        self.bin_list = bin_list
        self.bin_infos = []
        self.lib_infos = dict()
    
    def generate_info(self):
        for bin in self.bin_list:
            try:
                if is_elf_file(bin):
                    if any(exception in bin for exception in EXCEPTION_CASE):
                        print(f"Skipping {bin} due to exception case.")
                        continue
                    target = binNode(bin, self.lib_infos)
                    try:
                        target.analyze()
                        self.bin_infos.append(target.get_bin_info())    
                    except Exception as e:
                        print(f"Error: {e}")
                else:
                    print("This binary isn't ELF type.")
                    continue
            except Exception as e:
                print(f"Error: {bin}=>{e}")
                continue

    def set_lib_infos(self):
        parser = LibParser(self.fs_path)
        self.lib_infos = parser.get_lib_info()

    def get_bin_infos(self):
        return self.bin_infos

# be used to node in level2Analyzer
class binNode:
    def __init__(self, bin, libs_info=[]):
        self.bin_path = bin
        self.bin_name = os.path.basename(bin)
        self.bin_arch = None
        self.is_static = None
        self.is_stripped = None
        self.used_libs = []
        self.libs_info = libs_info
        self.keywords = []
        self.nvram_env_used = None
        self.hash_value = None
        self.checksec = {
            # 0: No applied, 1: applied, 2: high level applied
            'RELRO': None,
            'Canary': None,
            'NX': None,
            'PIE': None,
            'rpath': None,
            'runpath': None,
        }

    def get_bin_info(self):
        info_dict = {
            'bin_name': self.bin_name,
            'bin_arch': self.bin_arch,
            'is_static': self.is_static,
            'is_stripped': self.is_stripped,
            'used_libs': self.used_libs,
            'keywords': self.keywords,
            'checksec': self.checksec,
            'used_nvram_env': self.nvram_env_used,
            'hash_value': self.hash_value,
            'full_path': self.bin_path
        }
        return info_dict
    
    def analyze(self):
        try:
            self.basic_parsing()
            self.calculate_file_hash()
            self.check_sec_opt()
            self.check_refer_env_nvram()
            self.check_used_library()
            return 0
        except Exception as e:
            print(f"Error occured! {e}")
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
            print('Error: Unable to process the binary file.')

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
            print('Error: Unable to process the binary file.')

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
            print('Error: Unable to process the binary file.')

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
                    print('Library File')
            else:
                print('Not an ELF file')

        except subprocess.CalledProcessError:
            print('Error: Unable to process the binary file.')

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
            print('Error: Unable to process the binary file.')

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
                    # extract keywords
                    for func_name, func_data in data.get("results", {}).items():
                        if isinstance(func_data, dict):
                            for key_name in func_data.keys():
                                self.keywords.append(key_name)
                else:
                    self.nvram_env_used = 0

                # remove duplicate
                self.keywords = list(set(self.keywords))
        except Exception as e:
            print(f"Error reading JSON file: {e}")
            self.nvram_env_used = 0
        finally:
            try:
                if os.path.exists(jpath):
                    os.remove(jpath)
            except Exception as e:
                print(f"Error deleting JSON file: {e}")
    
    def check_used_library(self):
        try:
            # extract libraries from dynamic executable binaries
            if not self.is_static:
                result = subprocess.run(['readelf', '-d', self.bin_path], stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
                if result.returncode != 0:
                    print(f"Error running readelf: {result.stderr}")
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
                        for lib, lib_sym in self.libs_info.items():
                            if any(symbol in bin_sym for symbol in lib_sym):
                                self.used_libs.append(lib)

                    except subprocess.CalledProcessError as e:
                        print(f"Error extracting symbols from {self.bin_name}: {e}")
                        return

        except Exception as e:
            print(f"Error: {e}")
            return
        
                
    def calculate_file_hash(self, hash_algo='sha256'):
        """Calculates the hash of a file using the specified hashing algorithm."""
        hash_func = hashlib.new(hash_algo)
        with open(self.bin_path, 'rb') as f:
            # Read and update hash string value in blocks of 4K
            for byte_block in iter(lambda: f.read(4096), b""):
                hash_func.update(byte_block)
        return hash_func.hexdigest()