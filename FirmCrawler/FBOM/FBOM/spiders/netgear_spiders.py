import scrapy
import json
from selenium import webdriver
from scrapy.selector import Selector
import time
import logging
import re

# Selenium 로그 레벨 설정
logging.getLogger('selenium').setLevel(logging.WARNING)

class NetGearspiders(scrapy.Spider):
    name = 'netgear_spider'
    vendor = 'Netgear'
    allowed_domains = ['netgear.com']
    custom_settings = {
    'LOG_LEVEL': 'ERROR'
    }
    base_url = 'https://www.netgear.com/'
    product_list_url = 'api/v2/getcategorydoms/?publicationId=11&componentId=33985'
    seen_url = list()

    def start_requests(self):
        url = self.base_url + self.product_list_url
        yield scrapy.Request(url=url, callback=self.extract_products_list)

    def extract_products_list(self, response):
        data = json.loads(response.text)
        html_content = data['data']['componentPresentation']['rawContent']['content']

        # HTML을 파싱하여 링크 추출
        selector = scrapy.Selector(text=html_content)

        # href 속성이 .html을 포함하는 링크 추출
        links_with_html = selector.xpath("//a[contains(@href, '.html')]/@href").getall()
        # 추출한 링크들에서 .html을 /#download로 변경
        modified_links = [link.replace('.html', '/#download') for link in links_with_html]

        for link in modified_links:
            url = self.base_url + link
            yield scrapy.Request(url=url, callback=self.parse_link, meta={'url': url})

    def parse_link(self, response):
        # js 처리
        url = response.meta.get('url')
        # Chrome 옵션 설정
        chrome_options = webdriver.ChromeOptions()
        chrome_options.add_argument('--log-level=3')  # 로그 레벨을 설정하여 오류 메시지 출력 방지
        chrome_options.add_argument('--headless')  # 백그라운드 실행 옵션 추가
        driver = webdriver.Chrome(options=chrome_options)
        driver.get(url)
        time.sleep(5)
        response_js = Selector(text=driver.page_source)
        # Close the Selenium webdriver
        driver.quit()
        
        release_notes = list()
        # 클래스명이 "heading-1"인 h1 태그 내부의 텍스트 추출
        h1_text = response_js.xpath('//h1[@class="heading-1"]/text()').get()
        if h1_text:
            info = h1_text.split('—')
            if info:
                model = info[0].strip()
        download_flag = response_js.xpath('//div[@id="download"]')
        if download_flag:
            target_a_tags = response_js.xpath('//a[@class="a-link ms-1" and contains(text(), "Release Notes")]')
            for a_tag in target_a_tags:
                href = a_tag.xpath('@href').get()
                if href not in self.seen_url:
                    self.seen_url.append(href)
                    release_notes.append(href)
            # 중복 제거
            release_notes = list(set(release_notes))
            print(release_notes)
            for note in release_notes:
                yield scrapy.Request(url=note, callback=self.parse_additional_data, meta={'model': model, 'url': note})
        else:
            pass

    def parse_additional_data(self, response):
        # model
        model = response.meta.get('model')
        url = response.meta.get('url')
        # Chrome 옵션 설정
        chrome_options = webdriver.ChromeOptions()
        chrome_options.add_argument('--log-level=3')    # 로그 레벨을 설정하여 오류 메시지 출력 방지
        chrome_options.add_argument('--headless')       # 백그라운드 실행 옵션 추가
        driver = webdriver.Chrome(options=chrome_options)
        driver.get(url)
        time.sleep(3)
        response = Selector(text=driver.page_source)
        driver.quit()
        # version 정보
        version_full = response.xpath('//h1/text()').get().strip()
        version = re.search(r'Version\s+(.*)', version_full)
        if version:
            version = version.group(1)
        # download_url 정보
        download = response.xpath('//span[contains(text(), "Download Link:")]/following-sibling::a/@href').get()
        # date 정보
        date = response.xpath('//p[@class="last-updated"]/text()').get().strip()
        match = re.search(r'Last Updated:\s*(\d{2}/\d{2}/\d{4})', date)
        if match:
            date = match.group(1)
        else:
            date = None
        # description
        bug_fixes_tag = response.xpath('//strong[contains(text(), "Bug Fixes:")]')
        ul_tag = bug_fixes_tag.xpath('ancestor::p/following-sibling::ul')
        bug_fixes_list = [li.strip() for li in ul_tag.xpath('.//li/text()').getall()]
        description = ', '.join(bug_fixes_list)

        if download:
            # Test 출력
            print("-------------------")
            print("model: ", model)
            print("version: ", version)
            print("date: ", date)
            print("description: ", description)
            print("download: ", download)
            
            yield {
                'Vendor': self.vendor,
                'Model': model,
                'Version': version,
                'Date': date,
                'Checksum': None,
                'Description': description,
                'Download': download
            }
        else:
            pass
