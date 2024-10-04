import os
import shutil
import argparse

def delete_common_folders(dir_a, dir_b):
    # A 디렉터리의 폴더 목록
    folders_in_a = [f for f in os.listdir(dir_a) if os.path.isdir(os.path.join(dir_a, f))]
    
    # B 디렉터리의 폴더 목록
    folders_in_b = [f for f in os.listdir(dir_b) if os.path.isdir(os.path.join(dir_b, f))]

    # A와 B 모두에 존재하는 폴더를 B에서 삭제
    for folder in folders_in_a:
        if folder in folders_in_b:
            folder_b_path = os.path.join(dir_b, folder)
            shutil.rmtree(folder_b_path)
            print(f"Deleted {folder_b_path}")

# 명령줄 옵션 파서 설정
def parse_arguments():
    parser = argparse.ArgumentParser(description="Delete common folders from the dataset folder based on the analyzed folder.")
    parser.add_argument('-a', '--analyzed', required=True, help="Path to the analyzed folder (A)")
    parser.add_argument('-d', '--dataset', required=True, help="Path to the dataset folder (B)")
    return parser.parse_args()

if __name__ == "__main__":
    args = parse_arguments()
    
    dir_a = args.analyzed
    dir_b = args.dataset

    # 폴더가 존재하는지 확인
    if not os.path.exists(dir_a) or not os.path.isdir(dir_a):
        print(f"Directory A '{dir_a}' does not exist or is not a directory.")
    elif not os.path.exists(dir_b) or not os.path.isdir(dir_b):
        print(f"Directory B '{dir_b}' does not exist or is not a directory.")
    else:
        delete_common_folders(dir_a, dir_b)
