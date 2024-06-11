import subprocess, re, os

class LibParser:
    def __init__(self, libs):
        self.lib_sym_pair = dict()          # lib-symbol pair List
        self.libs = libs                      # extract library file from filesystem

    # return results
    def get_lib_symbols(self):
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
            print(f"\033[91m[-]\033[0m Error checking if file is stripped: {e}")
            return False

    # extract symbols from library file
    def extract_symbols(self, lib):
        try:
            result = subprocess.run(['nm', '-D', lib], capture_output=True, text=True, check=True)
            symbols = result.stdout.strip().split('\n')
            return symbols
        except subprocess.CalledProcessError as e:
            print(f"\033[91m[-]\033[0m Error extracting symbols from {lib}: {e}")
            return None