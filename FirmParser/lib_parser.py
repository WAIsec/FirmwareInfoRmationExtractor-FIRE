import subprocess, re, os
from FirmParser.utils import *

class LibParser:
    def __init__(self, libs):
        self.lib_sym_pair = dict()              # lib-symbol pair List
        self.libs = libs                        # extract library file from filesystem

    # return results
    def get_lib_symbols(self):
        for lib in self.libs:
            lib_name = os.path.basename(lib)
            
            # Initialize the dictionary for the library if it doesn't exist
            if lib_name not in self.lib_sym_pair:
                self.lib_sym_pair[lib_name] = {}  # Initialize with an empty dictionary

            symbols = self.extract_symbols(lib)
            # 여기에 version 정보 추출 결과 삽입
            notes_data = parse_notes(lib)
            self.lib_sym_pair[os.path.basename(lib)]["version_info"] = get_version_info(notes_data)
            self.lib_sym_pair[os.path.basename(lib)]["def_functions"] = symbols
        return self.lib_sym_pair

    # check stripped lib
    def is_stripped(file_path):
        try:
            result = subprocess.run(['file', file_path], capture_output=True, text=True)
            return 'stripped' in result.stdout
        except Exception as e:
            print(f"\033[91m[-]\033[0m Error checking if file is stripped: {e}")
            return False

    # extract symbols from library file
    def extract_symbols(self, library_path):
        try:
            # readelf 명령어를 실행하여 출력 얻기
            readelf_s_output = subprocess.check_output(['readelf', '-s', '--wide', library_path], stderr=subprocess.DEVNULL)
            readelf_s_output = readelf_s_output.decode('utf-8')
            # 출력 라인을 나누기
            lines = readelf_s_output.split('\n')

            # 심볼 테이블의 헤더 라인 찾기 (통상적으로 3번째 라인 이후가 데이터)
            header_found = False
            symbols = []

            for line in lines:
                # print(line)
                # 헤더 라인을 찾으면 이후부터 데이터 라인으로 처리
                if 'Num:' in line:
                    header_found = True
                    continue
                
                if not header_found:
                    continue
                
                # 데이터 라인을 공백으로 나누기
                columns = line.split()
                
                # 데이터 라인이 올바른 형식인지 확인
                if len(columns) < 8:
                    continue

                try:
                    size = int(columns[2])
                    # print(f"Size: {size}")
                    sym_type = columns[3]
                    # print(f"Symbols_Type: {sym_type}")
                    name = columns[-1]
                    # print(f"Name: {name}")
                    function_name = name.split('@')[0]
                    if size != 0 and sym_type == 'FUNC':
                        symbols.append(function_name)
                except ValueError:
                    # columns[2]가 정수로 변환할 수 없는 경우 무시
                    continue
            # 심볼 중복 제거
            return list(set(symbols))
        except subprocess.CalledProcessError as e:
            print(f"\033[91m[-]\033[0m Error running readelf: extract_symbols->{e}")
            return []