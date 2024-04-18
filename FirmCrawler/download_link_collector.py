import requests
from bs4 import BeautifulSoup

# 웹사이트의 주소
url = '여기에_웹사이트_주소를_입력하세요'

# 웹사이트에 HTTP GET 요청을 보냄
response = requests.get(url)

# 요청이 성공했는지 확인
if response.status_code == 200:
    # 응답의 소스 코드를 BeautifulSoup을 사용하여 파싱
    soup = BeautifulSoup(response.text, 'html.parser')
    
    # 특정 탭의 링크를 찾아서 클릭할 수 있는 URL을 추출
    # 이 부분은 웹 페이지의 HTML 구조에 따라 달라질 수 있습니다.
    # 예를 들어, 특정 클래스명이나 ID를 가진 요소를 찾아서 그 안에 있는 링크를 추출하는 방식 등을 사용할 수 있습니다.
    tab_link = soup.find('a', {'class': 'tab-link'})['href']
    
    # 추출한 탭 링크를 이용하여 새로운 HTTP GET 요청을 보냄
    tab_response = requests.get(tab_link)
    
    # 새로운 요청이 성공했는지 확인
    if tab_response.status_code == 200:
        # 새로운 응답의 소스 코드를 BeautifulSoup을 사용하여 파싱
        tab_soup = BeautifulSoup(tab_response.text, 'html.parser')
        
        # 원하는 정보를 추출하여 사용
        # 예를 들어, 탭 페이지의 제목을 출력하는 경우
        tab_title = tab_soup.title.text
        print("탭 페이지 제목:", tab_title)
    else:
        print("탭 페이지에 접근하는데 실패했습니다.")
else:
    print("웹 페이지에 접근하는데 실패했습니다.")
