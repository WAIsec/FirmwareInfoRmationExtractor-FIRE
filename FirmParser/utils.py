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

def extract_filesystem(target_path, vendor):
    """
    주어진 경로(target_path) 내의 모든 펌웨어 파일을 순회하여 Binwalk를 통해 파일 시스템을 추출합니다.
    <param>
    [target_path]: 펌웨어 파일들이 포함된 상위 디렉토리
    [vendor]: 벤더 이름으로 디렉토리 정리
    <return>
    [extraction_dir]: 추출된 파일 시스템 디렉토리 경로
    """
    extraction_base = f"Extracted_{vendor}_FS/"
    os.makedirs(extraction_base, exist_ok=True)

    # target_path 내의 모든 파일과 하위 디렉토리를 순회
    for root, dirs, files in os.walk(target_path):
        
        for file in files:
            try:
                # 펌웨어 파일이 맞다면 (확장자 체크 등 필요시 추가 가능)
                firm_img = os.path.join(root, file)
                extracted_dir = os.path.join(extraction_base, '_' + os.path.basename(firm_img) + ".extracted")
                clean_dir = os.path.join(extraction_base, '_'+os.path.basename(firm_img))  # .extracted 제거한 깨끗한 폴더 이름
                
                if not os.path.isdir(clean_dir):
                    # Binwalk 실행하여 파일 시스템 추출
                    result = subprocess.run(['binwalk', '-e', '-C', extraction_base, firm_img], capture_output=True, text=True)
                    if result.returncode != 0:
                        raise RuntimeError(f"\033[91m[-]\033[0m Binwalk 추출 실패: {result.stderr}")
                    
                    # .extracted 폴더 이름을 깨끗한 폴더 이름으로 변경
                    if os.path.exists(extracted_dir):
                        os.rename(extracted_dir, clean_dir)

                directories = os.listdir(clean_dir)
                for dir_name in directories:
                    dir_path = os.path.join(clean_dir, dir_name)
                    if os.path.isdir(dir_path):
                        # 디렉토리가 비어있는지 체크
                        if not any(os.listdir(dir_path)):
                            print(f"\033[91m[-]\033[0m {dir_path}에 콘텐츠가 없어 삭제합니다.")
                            shutil.rmtree(dir_path)
                            continue
                        
                        # 하위 디렉토리가 있는지 체크
                        subdirs = [sub for sub in os.listdir(dir_path) if os.path.isdir(os.path.join(dir_path, sub))]
                        if not subdirs:
                            print(f"\033[91m[-]\033[0m {dir_path}에 하위 디렉토리가 없어 삭제합니다.")
                            shutil.rmtree(dir_path)
                            continue
                            
                        # 하위 디렉토리에 콘텐츠가 있는지 체크
                        content_found = False
                        for subdir in subdirs:
                            if os.listdir(os.path.join(dir_path, subdir)):
                                content_found = True
                                break
                        if not content_found:
                            print(f"\033[91m[-]\033[0m {dir_path}의 하위 디렉토리에도 콘텐츠가 없어 삭제합니다.")
                            shutil.rmtree(dir_path)
                            continue
                            
                        print(f"\033[92m[+]\033[0m 유효한 파일 시스템 발견: {dir_path}")

                # clean_dir 내부에 남은 파일이나 폴더가 없으면 clean_dir 삭제
                if not os.listdir(clean_dir):
                    print(f"\033[91m[-]\033[0m 파일 시스템 추출 실패: {clean_dir}를 삭제합니다.")
                    shutil.rmtree(clean_dir)

            except Exception as e:
                print(f"\033[91m[-]\033[0m 오류 발생: {e}")
                continue

    
    print(f"\033[92m[+]\033[0m 전체 파일 시스템 추출 완료")
    return None

        

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