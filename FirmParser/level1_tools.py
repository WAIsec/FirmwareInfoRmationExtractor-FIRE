import os
import subprocess
import magic
from FirmParser.utils import find_libraries
WEB_EXTENSION = ['.html', '.htm', '.xhtml', '.xml', '.css', '.scss', '.sass', '.less', '.js', '.ts', '.jsx', '.tsx', '.php', '.asp', '.aspx', '.jsp']

class LevelOneAnalyzer:
    def __init__(self, fs_path, bins, vendor_keyword):
        self.fs_path = fs_path
        self.bins = bins
        self.web_files = []
        self.os_bins = []
        self.ven_bins = []
        self.conf_files = []
        self.libs, self.libs_full_path = find_libraries(fs_path)
        self.vendor_keyword = vendor_keyword
        # for debugging
        self.exceptional_bins = []

    def analyze(self):
        try:
            self.find_web_files()
            self.classfy_binary()
            self.find_configuration_files()
            return 0
        except Exception as e:
            print(f"\033[91m[-]\033[0m Error during analysis: [lv1] analyze()->{e}")
            return 1
        
    def get_libs_full_path(self):
        return self.libs_full_path
        
    def get_lv1_results(self):
        lv1_results = dict()
        lv1_results['web'] = self.get_web_files()
        lv1_results['public_bin'] = self.get_os_bins()
        lv1_results['vendor_bin'] = self.get_vendor_bins()
        lv1_results['config_file'] = self.get_configuration_files()
        lv1_results['libraries'] = self.libs
        lv1_results['Unparsed_bins'] = self.exceptional_bins
        return lv1_results

    def find_web_files(self):
        """
        This function finds web source
        <param>
        [fs_path]: filesystem path extracted from firmware file
        <return>
        [websource_list]: the list of websource existed in firmware filesystem
        """
        for dirpath, _, filenames in os.walk(self.fs_path):
            for filename in filenames:
                if any(filename.lower().endswith(ext) for ext in WEB_EXTENSION):
                    self.web_files.append(filename)
        
        self.web_files = list(set(self.web_files))

    def classfy_binary(self):
        lib_exts = ['.so', '.dll', '.dylib']
        for bin in self.bins:
            filename = os.path.basename(bin)
            ven_flag = False

            # Exclude library files
            if any(ext in filename.lower() for ext in lib_exts):
                continue

            # Check if any manufacturer string is in the filename (case-insensitive)
            if any(keyword.lower() in filename.lower() for keyword in self.vendor_keyword):
                self.ven_bins.append(filename)
                continue

            # Check if any manufacturer string is in the file content using strings
            try:
                strings_output = subprocess.run(['strings', bin], capture_output=True, text=True, encoding='utf-8')
                if strings_output.returncode == 0:
                    strings_content = strings_output.stdout.lower()
                    if any(keyword.lower() in strings_content for keyword in self.vendor_keyword):
                        self.ven_bins.append(filename)
                        ven_flag = True

                if not ven_flag:
                    # Check if any manufacturer string is in the symbols using nm
                    symbols = self.find_binary_symbols(bin)
                    for sym in symbols:
                        if any(keyword.lower() in sym for keyword in self.vendor_keyword):
                            self.ven_bins.append(filename)
                            ven_flag = True
                            break

                # If still not a vendor binary, add to os_bin
                if not ven_flag:
                    self.os_bins.append(filename)

            except Exception as e:
                print(f"\033[91m[-]\033[0m Error processing file {filename}: [lv1] classfy_binary->{e}")
                # Handle binary analysis errors by adding to exceptional_bins
                self.exceptional_bins.append(filename)

        # Remove duplicates and reinitialize lists
        self.ven_bins = list(set(self.ven_bins))
        self.os_bins = list(set(self.os_bins))

    def find_binary_symbols(self, bin_path):
            try:
                readelf_s_output = subprocess.check_output(['readelf', '-s', '--wide',  bin_path], stderr=subprocess.DEVNULL)
                readelf_s_output = readelf_s_output.decode('utf-8')
                lines = readelf_s_output.split('\n')
                
                header_found = False
                symbols = []

                for line in lines:
                    if 'Num:' in line:
                        header_found = True
                        continue
                    
                    if not header_found:
                        continue
                    
                    columns = line.split()
                    if len(columns) < 8:
                        continue

                    try:
                        sym_type = columns[3]
                        name = columns[-1]
                        function_name = name.split('@')[0]
                        if sym_type == 'FUNC':
                            symbols.append(function_name)
                    except ValueError:
                        print(f"\033[91m[-]\033[0m Error extracting symbols from {self.bin_name}: find_binary_symbols->{e}")
                        continue
                return symbols
            except subprocess.CalledProcessError as e:
                print(f"\033[91m[-]\033[0m Error extracting symbols from {self.bin_name}: find_binary_symbols->{e}")
                return []
            
    def find_configuration_files(self):
        """
        This function finds binary or normal file generated by Manufacturer
        <param>
        [fs_path]: filesystem path extracted from firmware file
        <return>
        [conf_files]: the list of configuration files generated by vendor
        """
        if os.path.isdir(self.fs_path):
            for dirpath, _, filenames in os.walk(self.fs_path):
                for filename in filenames:
                    file_path = os.path.join(dirpath, filename)
                    if os.path.isfile(file_path):
                        if filename.endswith('.conf'):
                            self.conf_files.append(filename)
        
        self.conf_files = list(set(self.conf_files))

    def get_web_files(self):
        return list(set(self.web_files))

    def get_os_bins(self):
        return list(set(self.os_bins))

    def get_vendor_bins(self):
        return list(set(self.ven_bins))
    
    def get_configuration_files(self):
        return list(set(self.conf_files))
