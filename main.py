import argparse
import time
import os

from FirmParser.utils import *
from FirmParser.level1_tools import *
from FirmParser.level2_tools import *
from FirmParser.bdg_maker import *
from FirmParser.unpacker import *


def main_parser(firmware_path, results_time):
    """
    This program was created to analyze the features of a single firmware and store them in a database.
    """
    firm_name = os.path.join(BASE_DIR, os.path.basename(firmware_path))
    # check start time
    start_time = time.time()

    if is_encrypted(firmware_path):
        print(f"This file {firmware_path} was encrypted!")
    else:
        # Make dir to store results
        output_dir = os.path.join(os.getcwd(), firm_name)
        os.makedirs(output_dir, exist_ok=True)

        # Extract filesystem from firmware file
        try:
            fs_path = extract_filesystem(firmware_path)
            if fs_path is None:
                os.rmdir(output_dir)
                return
        except Exception as e:
            print(f"Error to extract filesystem for {firmware_path}: {e}")
            os.rmdir(output_dir)
            return
        
        lv1_results = dict()

        # Level1 analyzing
        l1_analyzer = LevelOneAnalyzer(fs_path)
        if l1_analyzer.analyze():
            print(f"Something wrong happened while analyzing {firmware_path}")
        else:
            # Print Level1 Analyzer results
            lv1_results['web'] = l1_analyzer.get_web_files()
            lv1_results['public_bin'] = l1_analyzer.get_os_bins()
            lv1_results['vendor_bin'] = l1_analyzer.get_vendor_bins()
            lv1_results['config_file'] = l1_analyzer.get_configuration_files()

            # Store lv1_results
            lv1_results_output = os.path.join(output_dir, "lv1_results.csv")
            save_to_csv(lv1_results, lv1_results_output)

            # Level2 analyzing
            bins = extract_bins(fs_path)
            lv2_analyzer = LevelTwoAnalyzer(fs_path, bins)
            # Start parsing each binary
            lv2_analyzer.generate_info()
            bin_infos = lv2_analyzer.get_bin_infos()
            # Generate BDG data and update initial bin_infos
            generator = BDGinfo(bin_infos)
            bin_infos = generator.update_bdg()

            # Store lv2_results
            lv2_results_output = os.path.join(output_dir, "lv2_results.csv")

            # remove full path
            for bin in bin_infos:
                del bin['full_path']

            save_to_csv(bin_infos, lv2_results_output)
            # check end_time
            end_time = time.time()
            # calculate total time
            exe_time = end_time - start_time
            # store time results
            results_time.append([firm_name, exe_time])

def main():
    """
    This program was created to analyze the features of multiple firmware files in a given directory and store them in a database.
    """
    # Create Arg obj
    parser = argparse.ArgumentParser()
    
    # arg1 is the directory containing firmware files
    parser.add_argument("directory", type=str, help="Directory containing firmware files")

    args = parser.parse_args()

    if not os.path.isdir(args.directory):
        print(f"The path {args.directory} is not a valid directory.")
        return
    # decompress all file
    decompress_files(args.directory)
    # Get all firmware files in the directory
    firmware_files = []
    for root, dirs, files in os.walk(args.directory):
        for file in files:
            firmware_files.append(os.path.join(root, file))

    if not firmware_files:
        print("No firmware files found in the directory.")
        return
    
    # store time
    results_time = []

    for firmware_file in firmware_files:
        main_parser(firmware_file, results_time)
        initialize_dir()

    # store execution time
    results_exe_time_to_csv(results_time)

if __name__ == '__main__':
    main()