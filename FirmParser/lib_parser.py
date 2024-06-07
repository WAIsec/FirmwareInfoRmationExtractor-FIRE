import subprocess, re, os

class LibParser:
    def __init__(self, fs_path):
        self.lib_sym_pair = dict()          # lib-symbol pair List
        self.libs = []                      # extract library file from filesystem
        self.fs_path = fs_path

    # return results
    def get_lib_info(self):
        self.find_libraries()
        for lib in self.libs:
            symbols = self.extract_symbols(lib)
            self.lib_sym_pair[os.path.basename(lib)] = symbols
        return self.lib_sym_pair

    # check stripped lib
    def is_stripped(file_path):
        try:
            result = subprocess.run(['file', file_path], capture_output=True, text=True)
            return 'stripped' in result.stdout
        except Exception as e:
            print(f"Error checking if file is stripped: {e}")
            return False

    # extract libs from fs
    def find_libraries(self):
        lib_regex = re.compile(r'.*\.(so(\.\d+)*|a|dylib|dll)$')
        for root, dirs, files in os.walk(self.fs_path):
            for file in files:
                file_path = os.path.join(root, file)
                if lib_regex.match(file_path):
                    if not self.is_stripped(file_path):
                        self.libs.append(file_path)

    # extract symbols from library file
    def extract_symbols(self, lib):
        try:
            result = subprocess.run(['nm', '-D', lib], capture_output=True, text=True, check=True)
            symbols = result.stdout.strip().split('\n')
            return symbols
        except subprocess.CalledProcessError as e:
            print(f"Error extracting symbols from {lib}: {e}")
            return None