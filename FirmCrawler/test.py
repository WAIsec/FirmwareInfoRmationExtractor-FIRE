import json
import csv
from collections import Counter

def load_json(file_path):
    with open(file_path, 'r') as file:
        return json.load(file)

def load_csv(file_path):
    with open(file_path, newline='') as file:
        reader = csv.DictReader(file)
        return list(reader)

def count_models(data):
    return Counter(item['Model'].lower() for item in data)

# JSON 파일 로드
a_data = load_json('tplink.json')
# CSV 파일 로드
b_data = load_csv('tp-link.csv')

# A와 B의 Model 값 개수 계산 (대소문자 구분 없이)
a_model_counts = count_models(a_data)
b_model_counts = count_models(b_data)

# B에는 없고 A에만 있는 Model 값 및 해당 Row 개수 계산
unique_to_a = {model: count for model, count in a_model_counts.items() if model not in b_model_counts}

# B에는 없고 A에만 있는 Model 명의 총 개수
unique_model_count = len(unique_to_a)

# 결과 출력
print(f"B에는 없는 A의 Model 값 및 해당 Row 개수: {unique_to_a}")
total_unique_rows = sum(unique_to_a.values())
print(f"B에는 없는 A의 Row 총 개수: {total_unique_rows}")
print(f"B에는 없는 A의 Model 명 총 개수: {unique_model_count}")