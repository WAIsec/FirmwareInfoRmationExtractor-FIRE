import math
import subprocess
import os
import time
import magic
import csv
import zipfile
import tarfile

def calculate_entropy(data):
    if not data:
        return 0
    
    # Calculate the frequency of each byte value in the data
    frequency = [0] * 256
    for byte in data:
        frequency[byte] += 1
    
    # Calculate the entropy
    entropy = 0
    data_length = len(data)
    for count in frequency:
        if count > 0:
            probability = count / data_length
            entropy -= probability * math.log2(probability)
    
    return entropy

def is_encrypted(file_path, threshold=8.5):
    with open(file_path, 'rb') as file:
        data = file.read()
        entropy = calculate_entropy(data)
        print(f"Entropy: {entropy}")

        # 임계치보다 높은 경우 암호화로 판단 True 반환
        return entropy > threshold

def extract_filesystem(firm_img):
    """
    This function extracts filesystem from decrypted firmware file by using binwalk
    <param>
    [firm]: firmware file path
    <return>
    [extraction_dir]: extracted output from firmware file 
    """
    extraction_dir = "_" + firm_img+ ".extracted"
    
    if not os.path.isdir(extraction_dir):
        result = subprocess.run(['binwalk', '-e', firm_img], capture_output=True, text=True)
        if result.returncode != 0:
            raise RuntimeError(f"Binwalk extraction failed: {result.stderr}")

    directories = os.listdir(extraction_dir)

    for dir in directories:
        dir_path = os.path.join(extraction_dir, dir)
        if os.path.isdir(dir_path):
            if os.listdir(dir_path):
                return dir_path
    
    return None

def extract_bins(fs_path):
    bins = []
    mime = magic.Magic(mime=True)
    for root, dirs, files in os.walk(fs_path):
        for file in files:
            file_path = os.path.join(root, file)
            # check executable
            mime_type = mime.from_file(file_path)
            if mime_type is not None and mime_type.startswith('application/x-executable'):
                bins.append(file_path)
    return bins

def print_filename(file_list):
    print("----------------------------")
    for file in file_list:
        print(os.path.basename(file))
    print("----------------------------")


def run_env_resolve(target_binary_path, destination_dir):
    """
    Runs the env_resolve command and returns the path of the resulting JSON file.

    Parameters:
    target_binary_path (str): The path to the target binary.
    destination_dir (str): The directory where the result JSON file will be stored.

    Returns:
    str: The path to the resulting JSON file.
    """
    try:
        # Construct the command
        command = f'env_resolve {target_binary_path} --results {destination_dir}'

        # Execute the command
        subprocess.run(command, shell=True, check=True)
        
        # Assuming the result JSON file is saved in the destination directory
        # and has a known pattern or name
        result_json_path = os.path.join(destination_dir, 'env.json')
        # Verify if the file exists
        if os.path.exists(result_json_path):
            return result_json_path
    except Exception as e:
        print(f"No json file: {e}")
        return -1

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
    print(f"Execution times saved to {results_output}")

def list_and_extract_files(directory):
    # 모든 파일을 담을 리스트
    file_list = []
    
    # 주어진 디렉토리를 순회
    for root, dirs, files in os.walk(directory):
        for file in files:
            # 파일의 전체 경로
            file_path = os.path.join(root, file)
            
            # 파일이 zip 파일인 경우
            if file.endswith('.zip'):
                with zipfile.ZipFile(file_path, 'r') as zip_ref:
                    extract_path = os.path.join(root, file[:-4])  # zip 파일명을 제외한 경로
                    zip_ref.extractall(extract_path)
                    # 압축을 푼 파일들만 리스트에 추가
                    for extracted_root, extracted_dirs, extracted_files in os.walk(extract_path):
                        for extracted_file in extracted_files:
                            extracted_file_path = os.path.join(extracted_root, extracted_file)
                            file_list.append(extracted_file_path)
            
            # 파일이 tar 파일인 경우 (tar, tar.gz, tar.bz2 등)
            elif file.endswith('.tar') or file.endswith('.tar.gz') or file.endswith('.tgz') or file.endswith('.tar.bz2'):
                with tarfile.open(file_path, 'r:*') as tar_ref:
                    extract_path = os.path.join(root, file[:file.index('.tar')])  # tar 파일명을 제외한 경로
                    tar_ref.extractall(extract_path)
                    # 압축을 푼 파일들만 리스트에 추가
                    for extracted_root, extracted_dirs, extracted_files in os.walk(extract_path):
                        for extracted_file in extracted_files:
                            extracted_file_path = os.path.join(extracted_root, extracted_file)
                            file_list.append(extracted_file_path)
            else:
                # 압축되지 않은 파일일 경우 해당 파일의 경로를 리스트에 추가
                file_list.append(file_path)
    
    return file_list