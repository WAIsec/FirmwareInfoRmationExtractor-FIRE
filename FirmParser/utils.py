import math
import subprocess
import os
import time
import magic
import json
import csv
import zipfile
import tarfile
import shutil
import glob
import re
import shutil


BASE_DIR = './Parsing_Results'
# 지속적인 업데이트 필요
VENDOR_STR = ['dlink', 'tplink', 'zyxel', 'netgear', 'zy']

def is_elf_file(file_path):
    """Check if a file is an ELF file by reading its magic number."""
    try:
        with open(file_path, 'rb') as f:
            magic_number = f.read(4)
            return magic_number == b'\x7fELF'
    except Exception as e:
        print(f"\033[91m[-]\033[0m Could not read file {file_path}: {e}")
        return False

def calculate_entropy(data):
    if not data:
        return 0
    
    # Calculate the frequency of each byte value in the data
    frequency = [0] * 256  # 각 바이트 값의 빈도를 저장할 리스트 생성
    
    for byte in data:
        byte_value = byte if isinstance(byte, int) else ord(byte)  # 문자일 경우 ASCII 코드로 변환
        frequency[byte_value] += 1  # 해당 바이트 값의 빈도 증가
    
    # Calculate the entropy
    entropy = 0
    data_length = len(data)
    for count in frequency:
        if count > 0:
            probability = count / data_length
            entropy -= probability * math.log2(probability)
    
    return entropy

def is_encrypted_file(data, threshold=7.5):
    entropy = calculate_entropy(data)
    return entropy >= threshold


def format_time(seconds):
    """Convert seconds to a string in the format HH:MM:SS."""
    mins, secs = divmod(seconds, 60)
    hours, mins = divmod(mins, 60)
    return f"{int(hours):02}H:{int(mins):02}M:{int(secs):02}S"

# extract libs from fs
def find_libraries(fs_path):
    libs = []
    lib_regex = re.compile(r'.*\.(so(\.\d+)*|a|dylib|dll)$')
    for root, dirs, files in os.walk(fs_path):
        for file in files:
            file_path = os.path.join(root, file)
            if lib_regex.match(file_path):
                libs.append(os.path.basename(file_path))
    return list(set(libs))

def extract_filesystem(firm_img, vendor):
    """
    This function extracts filesystem from decrypted firmware file by using binwalk
    <param>
    [firm]: firmware file path
    <return>
    [extraction_dir]: extracted output from firmware file 
    """
    # for TP_Link
    extraction_dir = f"Extracted_Firmware_{vendor}/"

    if not os.path.isdir(extraction_dir + "_" + os.path.basename(firm_img) + ".extracted/"):
        result = subprocess.run(['binwalk', '-e', '-C', extraction_dir, firm_img], capture_output=True, text=True)
        if result.returncode != 0:
            raise RuntimeError(f"\033[91m[-]\033[0m Binwalk extraction failed: {result.stderr}")
    # set up
    extraction_dir = extraction_dir + "_" + os.path.basename(firm_img) + ".extracted/"
    directories = os.listdir(extraction_dir)
    for dir_name in directories:
        dir_path = os.path.join(extraction_dir, dir_name)
        if os.path.isdir(dir_path):
            # Check if directory is empty
            if not any(os.listdir(dir_path)):
                print(f"\033[91m[-]\033[0m No content found in {dir_path}, removing...")
                shutil.rmtree(dir_path)
                continue
            
            # Check if directory contains only one level of content
            subdirs = [sub for sub in os.listdir(dir_path) if os.path.isdir(os.path.join(dir_path, sub))]
            if not subdirs:
                print(f"\033[91m[-]\033[0m No subdirectories found in {dir_path}, removing...")
                shutil.rmtree(dir_path)
                continue
                
            # Check if any directory contains content
            content_found = False
            for subdir in subdirs:
                if os.listdir(os.path.join(dir_path, subdir)):
                    content_found = True
                    break
            if not content_found:
                print(f"\033[91m[-]\033[0m No content found in subdirectories of {dir_path}, removing...")
                shutil.rmtree(dir_path)
                continue
                
            print(f"\033[92m[+]\033[0m Valid filesystem found: {dir_path}")
            return dir_path
        
    # If no filesystem-like directories are found, remove the extraction directory
    print("\033[91m[-]\033[0m Error: Filesystem Not Found")
    shutil.rmtree(extraction_dir)
    
    return None

def extract_bins(fs_path):
    bins = []
    mime = magic.Magic(mime=True)
    for root, dirs, files in os.walk(fs_path):
        for file in files:
            file_path = os.path.join(root, file)
            if os.path.isfile(file_path):
                mime_type = mime.from_file(file_path)
                if mime_type is not None and mime_type.startswith('application/x-executable'):
                    bins.append(file_path)
    return bins

def print_blue_line():
    # Get the terminal width
    terminal_size = shutil.get_terminal_size((80, 20))  # Default to 80x20 if unable to get terminal size
    width = terminal_size.columns

    # Construct the line with dashes and blue color
    blue_line = "\033[94m" + '-' * width + "\033[0m"

    # Print the line
    print(blue_line)

def print_formatted_message(binary_path):
    # Get the terminal width
    terminal_width = shutil.get_terminal_size().columns

    # The message to be printed
    message = f"\033[95m[*]Now parse <{os.path.basename(binary_path)}> with mango\033[0m"

    # Calculate the remaining width after the message
    message_length = len(message) - 7 # Exclude ANSI escape codes length
    remaining_width = terminal_width - message_length

    # Calculate the length of '=' on each side
    equals_count = remaining_width // 2

    # Create the '=' strings
    equals = '=' * equals_count

    # Print the final formatted message
    formatted_message = f"\033[95m[*]{equals}Now parse <{os.path.basename(binary_path)}> with mango{equals}\033[0m"

    print(formatted_message)

def run_env_resolve(target_binary_path, destination_dir):
    """
    Runs the env_resolve command and returns the path of the resulting JSON file.

    Parameters:
    target_binary_path (str): The path to the target binary.
    destination_dir (str): The directory where the result JSON file will be stored.

    Returns:
    str: The path to the resulting JSON file, or -1 if an error occurs.
    """
    try:
        # DEBUG
        print_formatted_message(target_binary_path)
        # Construct the command
        command = f"env_resolve '{target_binary_path}' --results '{destination_dir}'"

        # Execute the command with a timeout
        subprocess.run(command, shell=True, check=True, timeout=1800)
        
        # Assuming the result JSON file is saved in the destination directory
        # and has a known pattern or name
        result_json_path = os.path.join(destination_dir, 'env.json')
        # Verify if the file exists
        if os.path.exists(result_json_path):
            return result_json_path
        else:
            print("\033[91m[-]\033[0m Result JSON file does not exist.")
            return -1
            
    except subprocess.TimeoutExpired:
        print("\033[91m[-]\033[0m TIME OUT: The command execution exceeded 1800 seconds.")
        return -1
    except Exception as e:
        print(f"\033[91m[-]\033[0m An error occurred: {e}")
        return -1

def save_to_json(data, filename):
    """Saves a dictionary to a JSON file with proper indentation."""
    if not isinstance(data, dict):
        raise ValueError("Data must be a dictionary")
    
    # Save to JSON file with indentation
    with open(filename, 'w') as json_file:
        json.dump(data, json_file, indent=4, ensure_ascii=False)
        
def save_to_csv(data, filename):
    """Saves a list of dictionaries to a CSV file."""
    if not isinstance(data, list):
        data = [data]
    if data:
        keys = data[0].keys()
        with open(filename, 'w', newline='') as csv_file:
            dict_writer = csv.DictWriter(csv_file, fieldnames=keys)
            dict_writer.writeheader()
            dict_writer.writerows(data)

def results_exe_time_to_csv(results):
    # Save results to CSV
    results_output = os.path.join(os.getcwd(), "execution_times.csv")
    with open(results_output, mode='w', newline='') as file:
        writer = csv.writer(file)
        writer.writerow(['firmware_file', 'execution_time'])
        writer.writerows(results)
    print(f"\033[92m[+]\033[0m Execution times saved to {results_output}")

def initialize_dir(vendor):
    # for
    shutil.rmtree(f'Extracted_Firmware_{vendor}')