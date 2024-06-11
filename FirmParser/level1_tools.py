import os
import subprocess
import magic
from FirmParser.utils import VENDOR_STR, find_libraries
WEB_EXTENSION = ['.html', '.htm', '.xhtml', '.xml', '.css', '.scss', '.sass', '.less', '.js', '.ts', '.jsx', '.tsx', '.php', '.asp', '.aspx', '.jsp']

class LevelOneAnalyzer:
    def __init__(self, fs_path, bins):
        self.fs_path = fs_path
        self.bins = bins
        self.web_files = []
        self.os_bins = []
        self.ven_bins = []
        self.conf_files = []
        self.libs = find_libraries(fs_path)
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
        
    def get_lv1_results(self):
        lv1_results = dict()
        lv1_results['web'] = self.web_files
        lv1_results['public_bin'] = self.os_bins
        lv1_results['vendor_bin'] = self.ven_bins
        lv1_results['config_file'] = self.conf_files
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

    def classfy_binary(self):
        lib_exts = ['.so', '.dll', '.dylib']
        for bin in self.bins:
            filename = os.path.basename(bin)

            # Exclude library files
            if any(ext in filename.lower() for ext in lib_exts):
                continue

            # Check if any manufacturer string is in the filename (case-insensitive)
            if any(vendor_str.lower() in filename.lower() for vendor_str in VENDOR_STR):
                self.ven_bins.append(filename)
                continue

            # Check if any manufacturer string is in the file content using grep (case-insensitive)
            try:
                for vendor_str in VENDOR_STR:
                    result = subprocess.run(['grep', '-q', vendor_str, bin], capture_output=True, text=True, encoding='unicode_escape')
                    if result.returncode == 1:  # grep returns 0 if a match is found
                        self.ven_bins.append(filename)
                        break
                else:
                    self.os_bins.append(filename)
            except Exception as e:
                print(f"\033[91m[-]\033[0m Error processing file {filename}: [lv1] classfy_binary->{e}")
                self.exceptional_bins.append(filename)

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

    def get_web_files(self):
        return list(set(self.web_files))

    def get_os_bins(self):
        return list(set(self.os_bins))

    def get_vendor_bins(self):
        return list(set(self.ven_bins))
    
    def get_configuration_files(self):
        return list(set(self.conf_files))
