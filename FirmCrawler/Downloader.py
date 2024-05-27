import os
import re
import pandas as pd
import requests
import time

# CSV 파일 경로
csv_file_path = 'FirmCrawler/merged_results.csv'

# CSV 파일 읽기 (UTF-8 인코딩 사용)
try:
    data = pd.read_csv(csv_file_path, encoding='utf-8')
except FileNotFoundError:
    print(f"File not found: {csv_file_path}")
    exit(1)
except pd.errors.EmptyDataError:
    print(f"CSV file is empty: {csv_file_path}")
    exit(1)
except pd.errors.ParserError as e:
    print(f"Error parsing CSV: {e}")
    exit(1)

# 특수 문자를 제거하는 함수
def sanitize_filename(name):
    return re.sub(r'[\\/*?:"<>|]', "_", name)

# 기본 저장 디렉토리 설정
base_dir = 'firmware_files'

# 디렉토리 생성 및 파일 다운로드 함수
def download_firmware(vendor, model, download_url):
    # 특수 문자 제거
    vendor = sanitize_filename(vendor)
    model = sanitize_filename(model)
    
    # 디렉토리 경로 설정
    vendor_dir = os.path.join(base_dir, vendor)
    model_dir = os.path.join(vendor_dir, model)
    
    # 디렉토리 생성
    os.makedirs(model_dir, exist_ok=True)
    
    # 파일명 설정
    file_name = os.path.basename(download_url)
    file_path = os.path.join(model_dir, file_name)
    
    # 파일 다운로드
    response = requests.get(download_url, stream=True, verify=False)
    if response.status_code == 200:
        with open(file_path, 'wb') as f:
            for chunk in response.iter_content(chunk_size=8192):
                f.write(chunk)
        print(f"Downloaded {file_name} to {file_path}")
    else:
        print(f"Failed to download {file_name} from {download_url}")

# CSV 데이터를 순회하며 파일 다운로드
for index, row in data.iterrows():
    vendor = row['Vendor']
    model = row['Model']
    download_url = row['Download']
    
    download_firmware(vendor, model, download_url)
    
    # 100번째마다 잠시 대기
    if index % 100 == 0:
        time.sleep(10)
