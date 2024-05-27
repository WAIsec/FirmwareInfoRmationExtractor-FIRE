import pandas as pd
from pdfminer.high_level import extract_text
import re

def dataframe_to_csv(df, file_path):
    """
    DataFrame을 CSV 파일로 저장하는 함수
    :param df: 저장할 DataFrame
    :param file_path: 저장할 CSV 파일의 경로
    """
    df.to_csv(file_path, index=False)

def extract_links(pdf_path):
    links = []
    with open(pdf_path, 'rb') as file:
        text = extract_text(file)
        # 정규 표현식을 사용하여 링크 추출
        extracted_links = re.findall(r'https?://(?:[-\w.]|(?:%[\da-fA-F]{2}))+', text)
        links.extend(extracted_links)
    return links


def make_dict():
    """
    Generate Dictionary for DB Scheme
    When analyze firmware download site, you can collect following contents
    'Vendor': Firm's vendor
    'Model': Device Model & Series
    'Version': Model's version
    'Date': Release Date
    'Checksum': Get the checksum value such as MD5, SHA256, etc.
    'Description': Devices Service
    'Download': Download link
    """
    ret = pd.DataFrame(columns=['Vendor', 'Model', 'Version', 'Date', 'Checksum', 'Description', 'Download'])

    return ret

def check_dict(dict):

    for idx in range(0, len(dict)):
        print(f"Vendor: {dict['Vendor'][idx]}, Model: {dict['Model'][idx]}, Version: {dict['Version'][idx]}, Date: {dict['Date'][idx]}, Checksum: {dict['Checksum'][idx]}, Description: {dict['Description'][idx]}, Download: {dict['Download'][idx]} ")
    print(f"Total link count: {len(dict)}")


def remove_duplicate_links(df):
    """
    중복된 다운로드 링크를 가진 데이터를 삭제하는 함수

    Parameters:
        df (pandas.DataFrame): 다운로드 링크를 포함한 DataFrame

    Returns:
        pandas.DataFrame: 중복된 링크가 삭제된 DataFrame
    """
    # 중복된 링크가 있는 행을 찾음
    duplicate_rows = df.duplicated(subset=['Donwload'], keep='first')
    
    # 중복된 행을 제외한 DataFrame 반환
    return df[~duplicate_rows]