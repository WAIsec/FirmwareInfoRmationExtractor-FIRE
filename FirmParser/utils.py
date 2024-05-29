import math
import subprocess
import os
import time

def calculate_entropy(data):
    """ 엔트로피 계산 함수 """
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
    """ 엔트로피 기반 파일 암호화 여부 판단 """
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

def print_filename(file_list):
    for file in file_list:
        print(os.path.basename(file))