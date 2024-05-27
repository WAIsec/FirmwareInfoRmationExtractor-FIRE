import json
import csv
import os

# 합칠 json 파일들이 있는 디렉토리 경로
directory = '.'

# 합칠 json 파일들의 이름 리스트
json_files = [f for f in os.listdir(directory) if f.endswith('.json')]

# 모든 json 파일을 하나의 리스트로 합칠 변수
merged_data = []

# 모든 json 파일을 읽어서 하나의 리스트에 추가
for filename in json_files:
    with open(os.path.join(directory, filename), 'r') as file:
        data = json.load(file)
        merged_data.extend(data)

# CSV 파일로 데이터 쓰기
output_file = 'merged_results.csv'
with open(output_file, 'w', newline='', encoding='utf-8') as file:
    writer = csv.DictWriter(file, fieldnames=merged_data[0].keys())
    writer.writeheader()
    for row in merged_data:
        writer.writerow(row)

print(f'CSV 파일이 생성되었습니다: {output_file}')