import os
import shutil

def is_valid_filesystem(extracted_path):
    # .extracted/{name}/ 구조에서 첫 번째 하위 폴더 확인
    for item in os.listdir(extracted_path):
        item_path = os.path.join(extracted_path, item)
        if os.path.isdir(item_path):  # 첫 번째 하위 폴더
            # 해당 하위 폴더에서 바이너리 파일(.bin, .elf, .so)을 찾음
            for root, dirs, files in os.walk(item_path):
                for file in files:
                    if file.endswith(('.bin', '.elf', '.so')):  # 바이너리 파일 확장자들
                        return item_path
            break  # 첫 번째 디렉토리만 검사하므로 루프 종료
    return False

def clean_extracted_folder(extracted_path, fs_path):
    # 유효한 파일시스템이 있는 경우, 나머지 파일 및 디렉토리 삭제
    for item in os.listdir(extracted_path):
        item_path = os.path.join(extracted_path, item)
        if item_path != fs_path:  # 유효한 파일시스템 경로가 아닌 경우
            if os.path.isdir(item_path):
                shutil.rmtree(item_path)  # 디렉토리인 경우 삭제
            elif os.path.isfile(item_path):
                os.remove(item_path)  # 파일인 경우 삭제

def clean_firmware_folders(base_path):
    for item in os.listdir(base_path):
        item_path = os.path.join(base_path, item)
        if item_path.endswith('.extracted') and os.path.isdir(item_path):
            fs_path = is_valid_filesystem(item_path)
            if fs_path:
                print(f"\033[92m[+]\033[0m Valid filesystem found in {item_path}. Cleaning...")
                clean_extracted_folder(item_path, fs_path)
            else:
                print(f"\033[91m[-]\033[0m No valid filesystem in {item_path}. Deleting...")
                shutil.rmtree(item_path)

if __name__ == "__main__":
    # 사용자로부터 폴더 경로를 터미널에서 입력받음
    firmware_base_path = input("Enter the path to the firmware folder: ")
    clean_firmware_folders(firmware_base_path)
