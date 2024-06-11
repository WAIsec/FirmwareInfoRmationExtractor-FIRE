import os
import shutil
import zipfile
import gzip
import tarfile
import bz2
import lzma
from rarfile import RarFile
from FirmParser.utils import print_blue_line

def decompress_files(directory):
    for root, dirs, files in os.walk(directory):
        for filename in files:
            filepath = os.path.join(root, filename)
            # ZIP 파일 처리
            try:
                if zipfile.is_zipfile(filepath):
                    with zipfile.ZipFile(filepath, 'r') as zip_ref:
                        zip_ref.extractall(root)
                    # 압축 해제 후 파일 이동
                    for extracted_file in zip_ref.namelist():
                        if extracted_file.endswith('.bin'):
                            extracted_filepath = os.path.join(root, extracted_file)
                            target_filepath = os.path.join(directory, extracted_file)
                            shutil.move(extracted_filepath, target_filepath)
                        elif extracted_file.endswith('.hex'):
                            extracted_filepath = os.path.join(root, extracted_file)
                            target_filepath = os.path.join(directory, extracted_file)
                            shutil.move(extracted_filepath, target_filepath)
                    os.remove(filepath)
                    shutil.rmtree(os.path.join(root, os.path.splitext(filename)[0]))
                # GZIP 파일 처리
                elif filepath.endswith('.gz'):
                    with gzip.open(filepath, 'rb') as f_in:
                        with open(filepath[:-3], 'wb') as f_out:
                            shutil.copyfileobj(f_in, f_out)
                    os.remove(filepath)
                    shutil.move(filepath[:-3], directory)
                # TAR 파일 처리
                elif tarfile.is_tarfile(filepath):
                    with tarfile.open(filepath, 'r') as tar_ref:
                        tar_ref.extractall(root)
                    # TAR 파일 내의 .bin 파일 이동
                    for extracted_file in tar_ref.getnames():
                        if extracted_file.endswith('.bin'):
                            extracted_filepath = os.path.join(root, extracted_file)
                            target_filepath = os.path.join(directory, extracted_file)
                            shutil.move(extracted_filepath, target_filepath)
                    os.remove(filepath)
                    shutil.rmtree(os.path.join(root, os.path.splitext(filename)[0]))
                # BZIP2 파일 처리
                elif filepath.endswith('.bz2'):
                    with bz2.open(filepath, 'rb') as f_in:
                        with open(filepath[:-4], 'wb') as f_out:
                            shutil.copyfileobj(f_in, f_out)
                    os.remove(filepath)
                    shutil.move(filepath[:-4], directory)
                # XZ 파일 처리
                elif filepath.endswith('.xz'):
                    with lzma.open(filepath, 'rb') as f_in:
                        with open(filepath[:-3], 'wb') as f_out:
                            shutil.copyfileobj(f_in, f_out)
                    os.remove(filepath)
                    shutil.move(filepath[:-3], directory)
                # RAR 파일 처리
                elif filepath.endswith('.rar'):
                    with RarFile(filepath, 'r') as rar_ref:
                        rar_ref.extractall(root)
                    # RAR 파일 내의 .bin 파일 이동
                    for extracted_file in rar_ref.namelist():
                        if extracted_file.endswith('.bin'):
                            extracted_filepath = os.path.join(root, extracted_file)
                            target_filepath = os.path.join(directory, extracted_file)
                            shutil.move(extracted_filepath, target_filepath)
                    os.remove(filepath)
                    shutil.rmtree(os.path.join(root, os.path.splitext(filename)[0]))
                # HEX 파일 처리
                elif filepath.endswith('.hex'):
                    target_filepath = os.path.join(directory, filename)
                    shutil.move(filepath, target_filepath)
                else:
                    continue
            except Exception as e:
                print(f"\033[91m[-]\033[0m Error: {e}")
                print_blue_line()
                continue