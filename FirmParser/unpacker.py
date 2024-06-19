import os
import shutil
import zipfile
import gzip
import tarfile
import bz2
import lzma
from rarfile import RarFile
from FirmParser.utils import print_blue_line

BENIGN_EXT = ['.bin', '.chk', '.hex', '.img']

def decompress_files(directory):
    for root, dirs, files in os.walk(directory):
        for filename in files:
            filepath = os.path.join(root, filename)
            try:
                # ZIP 파일 처리
                if zipfile.is_zipfile(filepath):
                    with zipfile.ZipFile(filepath, 'r') as zip_ref:
                        zip_ref.extractall(root)
                # GZIP 파일 처리
                elif filepath.endswith('.gz'):
                    with gzip.open(filepath, 'rb') as f_in:
                        with open(filepath[:-3], 'wb') as f_out:
                            shutil.copyfileobj(f_in, f_out)
                    shutil.move(filepath[:-3], directory)
                # TAR 파일 처리
                elif tarfile.is_tarfile(filepath):
                    with tarfile.open(filepath, 'r') as tar_ref:
                        tar_ref.extractall(root)
                # BZIP2 파일 처리
                elif filepath.endswith('.bz2'):
                    with bz2.open(filepath, 'rb') as f_in:
                        with open(filepath[:-4], 'wb') as f_out:
                            shutil.copyfileobj(f_in, f_out)
                # XZ 파일 처리
                elif filepath.endswith('.xz'):
                    with lzma.open(filepath, 'rb') as f_in:
                        with open(filepath[:-3], 'wb') as f_out:
                            shutil.copyfileobj(f_in, f_out)
                # RAR 파일 처리
                elif filepath.endswith('.rar'):
                    with RarFile(filepath, 'r') as rar_ref:
                        rar_ref.extractall(root)
            except Exception as e:
                print(f"\033[91m[-]\033[0m Error: delcompress-file->{e}")
                print_blue_line()
                continue
    
    # 빈 폴더 삭제
    for root, dirs, files in os.walk(directory, topdown=False):
        for dir in dirs:
            folder_path = os.path.join(root, dir)
            if not os.listdir(folder_path):  # 폴더가 비어있는지 확인
                os.rmdir(folder_path)  # 비어있으면 삭제
    
    for root, dirs, files in os.walk(directory):
        for filename in files:
            filepath = os.path.join(root, filename)
            try:
                if not any(filepath.endswith(ext) for ext in BENIGN_EXT):
                    os.remove(filepath)
            except Exception as e:
                print(f"\033[91m[-]\033[0m Error: delcompress-file->{e}")
                print_blue_line()
                continue

