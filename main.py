import argparse

from FirmParser.utils import *
from FirmParser.level1_tools import *

def main():
    """
    This program was created to analyze the features of firmware and store them in a database.
    [Step]
    1. Distinguish whether the collected firmware file is an encrypted file or a regular file.
    """
    # Create Arg obj
    parser = argparse.ArgumentParser()
    
    # arg1 is firmware file, which is target for this program
    parser.add_argument("arg1", type=str, help="Target path")

    args = parser.parse_args()

    if (is_encrypted(args.arg1)):
        print("This File was encrypted!")
    else:
        fs_path = extract_filesystem(args.arg1)
        # Level1 analyzing
        web_files = find_web_files(fs_path)
        # print(web_files)
        os_bins = find_os_binary(fs_path)
        # print_filename(os_bins)
        ven_bins = find_vendor_files(fs_path)
        # print_filename(ven_bins)
        conf_files = find_configuration_files(fs_path)
        print_filename(conf_files)
if __name__ == '__main__':
    main()