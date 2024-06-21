import argparse
import time
import os

from FirmParser.utils import *
from FirmParser.level1_tools import *
from FirmParser.level2_tools import *
from FirmParser.bdg_maker import *
from FirmParser.unpacker import *


def main_parser(firmware_path, results_file, vendor):
    """
    This program was created to analyze the features of a single firmware and store them in a database.
    """
    dir = os.path.join(BASE_DIR, vendor)
    os.makedirs(dir, exist_ok=True)
    firm_name = os.path.join(dir, os.path.basename(firmware_path))
    # check start time
    start_time = time.time()

    # Make dir to store results
    output_dir = os.path.join(os.getcwd(), firm_name)
    os.makedirs(output_dir, exist_ok=True)

    # Extract filesystem from firmware file
    try:
        fs_path = extract_filesystem(firmware_path, vendor)
        if fs_path is None:
            os.rmdir(output_dir)
            return
    except Exception as e:
        print(f"\033[91m[-]\033[0m Error to extract filesystem for {firmware_path}: {e}")
        os.rmdir(output_dir)
        return
    
    lv1_results = dict()

    # Level1 analyzing
    bins = list(set(extract_bins(fs_path)))
    lv1_analyzer = LevelOneAnalyzer(fs_path, bins)
    if lv1_analyzer.analyze():
        print(f"\033[91m[-]\033[0m Something wrong happened while analyzing {firmware_path}")
    else:
        # Print Level1 Analyzer results
        lv1_results = lv1_analyzer.get_lv1_results()

        # Store lv1_results
        print("\033[92m[+]\033[0m Start Level1 Analysis")
        lv1_results_output = os.path.join(output_dir, "lv1_results.json")
        save_to_json(lv1_results, lv1_results_output)
        print("\033[92m[+]\033[0m Finish Level1 Analysis")

        # Level2 analyzing
        print("\033[92m[+]\033[0m Start Level2 Analysis")
        lv2_analyzer = LevelTwoAnalyzer(fs_path=fs_path, bins=bins, v_bin=lv1_results['vendor_bin'], p_bin=lv1_results['public_bin'], libs=lv1_results['libraries'])
        
        # Start parsing each binary
        lv2_analyzer.generate_info()
        bin_info = lv2_analyzer.get_bin_infos()

        # Generate BDG data and update initial bin_infos
        generator = BDGinfo(bin_info)
        bin_info = generator.update_bdg()

        # Store lv2_results
        lv2_results_output = os.path.join(output_dir, "lv2_results.json")
        print("\033[92m[+]\033[0m Finish Level2 Analysis")

        # remove full path
        for bin_path, info in bin_info.items():
            del info['full_path']

        save_to_json(bin_info, lv2_results_output)
        # check end_time
        end_time = time.time()
        # calculate total time
        exe_time = end_time - start_time
        exe_time = format_time(exe_time)
        # store time results
        with open(results_file, 'a') as f:
            f.write(f"{firm_name}/{exe_time}\n")

def main():
    """
    This program was created to analyze the features of multiple firmware files in a given directory and store them in a database.
    """
    # Create Arg obj
    parser = argparse.ArgumentParser()
    
    # arg1 is the directory containing firmware files
    parser.add_argument("directory", type=str, help="Directory containing firmware files")
    parser.add_argument("vendor", type=str, help="Target Vendor name")
    args = parser.parse_args()

    if not os.path.isdir(args.directory):
        print(f"\033[91m[-]\033[0m The path {args.directory} is not a valid directory.")
        return
    
    # decompress all file
    print("\033[92m[+]\033[0m Preprocessing Target Directory...")
    decompress_files(args.directory)
    
    # Get all firmware files in the directory
    firmware_files = []
    print(f"\033[92m[+]\033[0m Listing Firmware Files")
    for root, dirs, files in os.walk(args.directory):
        for file in files:
            if is_encrypted_file(file):
                print(f"\033[91m[-]\033[0m {os.path.basename(file)} was Encrypted")
            else:
                firmware_files.append(os.path.join(root, file))

    if not firmware_files:
        print("\033[91m[-]\033[0m No firmware files found in the directory.")
        return
    
    # results time file
    results_file = f"results_time_{args.vendor}.csv"
    with open(results_file, 'w') as f:
        f.write("firmware,execution_time\n")

    for firmware_file in firmware_files:
        print(f"\033[92m[+]\033[0m Parse Firmware <{os.path.basename(firmware_file)}>")
        main_parser(firmware_file, results_file, args.vendor)
        print_blue_line()
        initialize_dir(args.vendor)

if __name__ == '__main__':
    main()
