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
COMMON_SYM = ['_init', '__init__', '_finit', '_fini']
IO_FUNC = ["fopen", "fread", "fwrite", "fclose", "open", "read", "write", "close"]
DB_FUNC = ["sqlite3_open", "sqlite3_exec", "sqlite3_close", "mysql_init", "mysql_query", "mysql_close", "PQconnectdb", "PQexec", "PQfinish", "query", "db"]
ENC_FUNC = ["encrypt", "decrypt"]
TEE_FUNC = ["TEEC_InitializeContext", "TEEC_OpenSession", "TEEC_InvokeCommand", "TEEC_CloseSession", "TEEC_FinalizeContext", "sgx_create_enclave", "sgx_ecall", "sgx_destroy_enclave"]
# interesting str 관련 정규식 표현
STR_PATTERNS = {
    'Key': r"\b[A-Fa-f0-9]{32}\b",
    'IV': r"\b[A-Fa-f0-9]{16}\b",
    'URL': r"http[s]?://(?:[a-zA-Z]|[0-9]|[$-_@.&+]|[!*\\(\\),]|(?:%[0-9a-fA-F][0-9a-fA-F]))+",
    'E-mail': r"\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b",
    'IP': r"\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}\b"
}

def load_vendor_strings_from_file(filepath):
    try:
        with open(filepath, 'r') as file:
            vendor_strings = [line.strip() for line in file.readlines() if line.strip()]
            return vendor_strings
    except Exception as e:
        print(f"Error loading vendor strings from file: {e}")
        return []

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
    libs_base = []
    libs_full = []
    lib_regex = re.compile(r'.*\.(so(\.\d+)*|a|dylib|dll)$')
    for root, dirs, files in os.walk(fs_path):
        for file in files:
            file_path = os.path.join(root, file)
            if lib_regex.match(file_path):
                libs_base.append(os.path.basename(file_path))
                libs_full.append(file_path)
    return list(set(libs_base)), list(set(libs_full))

def extract_filesystem(dir_path, vendor):
    # vendor 폴더 생성
    vendor_dir = os.path.join(dir_path, vendor)
    if not os.path.exists(vendor_dir):
        os.makedirs(vendor_dir)
    
    # 분석 제외 확장자 리스트
    excluded_extensions = ['pdf', 'html']
    
    # 디렉터리 내 모든 파일 탐색
    for filename in os.listdir(dir_path):
        file_path = os.path.join(dir_path, filename)
        
        # 파일인지 확인하고 제외 확장자가 아닌 경우에만 처리
        if os.path.isfile(file_path) and not any(filename.lower().endswith(ext) for ext in excluded_extensions):
            # 저장될 폴더 경로 설정
            output_dir = os.path.join(vendor_dir)
            
            # binwalk 명령어 실행하여 파일시스템 추출
            print(f"\033[92m[+]\033[0m Extracting filesystem from {filename}...")
            try:
                result = subprocess.run(['binwalk', '--extract', '--directory', output_dir, file_path],
                                        capture_output=True, text=True, timeout=300)
                
                # 정상적으로 실행되었지만 ELF 파일이 없을 수 있음 -> ELF 파일 검사
                if result.returncode == 0:
                    if not contains_elf_files(output_dir):
                        # ELF 파일이 없는 경우 폴더 삭제
                        shutil.rmtree(output_dir)
                        print(f"\033[91m[-]\033[0m No ELF files found in {filename}'s filesystem. Folder removed.")
                    else:
                        print(f"\033[92m[+]\033[0m Successfully extracted filesystem for {filename} into {output_dir}")
                else:
                    print(f"\033[91m[-]\033[0m Failed to extract filesystem for {filename}. Error: {result.stderr}")
            
            except subprocess.TimeoutExpired:
                # 5분 넘게 소요된 경우 예외 처리
                print(f"\033[91m[-]\033[0m Timeout: Skipping {filename} after 5 minutes.")

def contains_elf_files(directory):
    """해당 디렉터리에 ELF 파일이 있는지 검사"""
    for root, _, files in os.walk(directory):
        for file in files:
            file_path = os.path.join(root, file)
            try:
                # file 명령어로 ELF 파일인지 확인
                result = subprocess.run(['file', file_path], capture_output=True, text=True)
                if 'ELF' in result.stdout:
                    return True
            except Exception as e:
                print(f"Error checking {file_path}: {e}")
    return False

def extract_bins(fs_path):
    bins = []
    mime = magic.Magic(mime=True)
    for root, dirs, files in os.walk(fs_path):
            for file in files:
                file_path = os.path.join(root, file)
                try:
                    if os.path.isfile(file_path):
                        mime_type = mime.from_file(file_path)
                        if mime_type is not None and mime_type.startswith('application/x-executable'):
                            bins.append(file_path)
                except Exception as e:
                    print(f"\033[91m[-]\033[0m Error at {os.path.basename(file_path)}: extract_bins -> {e}")
                    continue
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
    print("")
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
        # print_formatted_message(target_binary_path)
        # Construct the command
        command = f"env_resolve '{target_binary_path}' --results '{destination_dir}'"

        # Execute the command with a timeout
        subprocess.run(command, shell=True, check=True, timeout=600, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
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

def remove_empty_values(dictionary):
    """
    사전에서 value 값이 비어 있는 key 값을 삭제합니다.

    Parameters:
    dictionary (dict): value 값이 비어 있는 key 값을 삭제할 사전

    Returns:
    dict: value 값이 비어 있는 key 값이 삭제된 새로운 사전
    """
    return {k: v for k, v in dictionary.items() if v}

def extract_strings(binary_path):
    result = subprocess.run(["strings", binary_path], capture_output=True, text=True)
    return result.stdout.splitlines()

def flatten_directory_structure(parent_dir):
    """
    주어진 경로의 하위 디렉토리들을 모두 삭제하고, 하위 경로에 있는 파일들을 상위 디렉토리로 이동합니다.
    
    <param>
    [parent_dir]: 파일들을 상위 디렉토리로 이동시키고, 하위 디렉토리들을 삭제할 상위 디렉토리 경로
    """
    try:
        # 1. 모든 하위 디렉토리와 파일을 탐색
        for root, dirs, files in os.walk(parent_dir, topdown=False):
            # 2. 하위 경로에 있는 모든 파일을 상위 디렉토리로 이동
            for file in files:
                try:
                    file_path = os.path.join(root, file)
                    # 파일을 상위 디렉토리로 이동
                    shutil.move(file_path, parent_dir)
                    print(f"Moved {file_path} to {parent_dir}")
                except:
                    pass
            # 3. 하위 디렉토리들을 삭제
            for dir in dirs:
                dir_path = os.path.join(root, dir)
                if os.path.isdir(dir_path):
                    try:
                        shutil.rmtree(dir_path)  # 비어있지 않은 디렉토리 삭제
                        print(f"Deleted directory: {dir_path}")
                    except Exception as e:
                        print(f"Failed to delete {dir_path}: {e}")
        
        print("All files moved and directories deleted.")
    
    except Exception as e:
        print(f"Error occurred: {e}")