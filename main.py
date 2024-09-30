import argparse
import time
import os

from FirmParser.utils import *
from FirmParser.level1_tools import *
from FirmParser.level2_tools import *
from FirmParser.bdg_maker import *
from FirmParser.unpacker import *


def main_parser(firmware_path, results_file, vendor='Unknown', vendor_keyword=[]):
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
    
    lv1_results = dict()

    # Level1 analyzing
    print("\033[92m[+]\033[0m Start Level1 Analysis")
    bins = list(set(extract_bins(firmware_path)))
    lv1_analyzer = LevelOneAnalyzer(firmware_path, bins, vendor_keyword)
    if lv1_analyzer.analyze():
        print(f"\033[91m[-]\033[0m Something wrong happened while analyzing {firmware_path}")
    else:
        # Print Level1 Analyzer results
        lv1_results = lv1_analyzer.get_lv1_results()

        # Store lv1_results
        lv1_results_output = os.path.join(output_dir, "lv1_results.json")
        save_to_json(lv1_results, lv1_results_output)
        print("\033[92m[+]\033[0m Finish Level1 Analysis")
        
        # Generate Library Object
        libs_full_path = lv1_analyzer.get_libs_full_path()

        lib_parser = LibParser(libs=libs_full_path)
        print("\033[92m[+]\033[0m Make library-symbols pair")
        lib_infos = lib_parser.get_lib_symbols()

        # Library information will be stored
        libs_results_output = os.path.join(output_dir, "libs_results.json")
        save_to_json(lib_infos, libs_results_output)
        print("\033[92m[+]\033[0m LIB-SYM data was stored.")
        
        # Level2 analyzing
        print("\033[92m[+]\033[0m Start Level2 Analysis")
        lv2_analyzer = LevelTwoAnalyzer(fs_path=firmware_path, bins=bins, v_bin=lv1_results['vendor_bin'], p_bin=lv1_results['public_bin'], lib_infos=lib_infos)
        
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
        
        # # 분석 완료한 펌웨어 삭제
        # del firmware_path

def main():
    """
    This program was created to analyze the features of multiple firmware files in a given directory and store them in a database.
    """
    # Create Arg obj
    parser = argparse.ArgumentParser(description="Analyze firmware files and store results in a database.")
    
    parser.add_argument("-t", "--type", type=str, help="path type(multi or single)")
    parser.add_argument("-p", "--path", type=str, help="Target path")
    parser.add_argument("-vkw", "--vendor_keyword_file", type=str, required=True, help="Path to the file containing vendor's keywords")
    parser.add_argument("-v", "--vendor", type=str, required=True, help="Name of the target vendor")
    args = parser.parse_args()

    if not os.path.isdir(args.path):
        print(f"\033[91m[-]\033[0m The path {args.path} is not a valid directory.")
        return

    if args.type == 'multi':
        # Get all firmware files in the directory
        firmware_files = []
        print(f"\033[92m[+]\033[0m Listing Firmware Files")
        # args.path의 바로 아래에 있는 폴더들만 가져옴
        for item in os.listdir(args.path):
            item_path = os.path.join(args.path, item)
            if os.path.isdir(item_path):  # 디렉토리인지 확인
                print(f"\033[92m[+]\033[0m {item} append to Waiting Queue")
                firmware_files.append(item_path)
        # results time file
        results_file = f"results_time_{args.vendor}.csv"
        with open(results_file, 'w') as f:
            f.write("firmware,execution_time\n")
        print_blue_line()

        # set vendor_keyword
        vendor_keyword = load_vendor_strings_from_file(args.vendor_keyword_file)

        for firmware_fs in firmware_files:
            print(f"\033[92m[+]\033[0m Parse Firmware <{os.path.basename(firmware_fs)}>")
            main_parser(firmware_fs, results_file, args.vendor, vendor_keyword)
            print_blue_line()
            # initialize_dir(args.vendor)

    elif args.type == 'single':
        firmware_file = args.path
        print(f"\033[92m[+]\033[0m Parse Firmware <{os.path.basename(firmware_file)}>")

        # results time file
        results_file = f"results_time_{args.vendor}.csv"
        with open(results_file, 'w') as f:
            f.write("firmware,execution_time\n")

        # set vendor_keyword
        vendor_keyword = load_vendor_strings_from_file(args.vendor_keyword_file)
        main_parser(firmware_file, results_file, args.vendor, vendor_keyword)
        print_blue_line()

if __name__ == '__main__':
    main()
