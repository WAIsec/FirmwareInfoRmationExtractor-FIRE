import scrapy
from selenium import webdriver
import time
from scrapy.selector import Selector
import json

PADDING = '1234567891011'
class DlinkUSspiders(scrapy.Spider):
    name = 'd-link(us)_spider'
    vendor = 'D-Link(US)'
    allowed_domains = ['dlink.com']  # allowed_domains는 리스트로 설정되어야 합니다.

    base_url = 'https://support.dlink.com/'
    product_page = 'AllPro.aspx'
    download_url = 'ProductInfo.aspx?m='

    custom_settings = {
        'LOG_LEVEL': 'ERROR'
    }

    def start_requests(self):
        url = self.base_url + self.product_page
        yield scrapy.Request(url=url, callback=self.extract_products)

    def extract_products(self, response):
        products = response.xpath('//tr')

        for product in products:
            product_info = product.xpath('.//td')
            product_name = product_info[0].xpath('string()').get().strip()  # string()을 사용하여 텍스트 가져오기
            product_description = product_info[1].xpath('string()').get().strip()
            print(product_name)
            print(product_description)
            url = self.base_url + self.download_url + product_name
            yield scrapy.Request(url=url, callback=self.parse_download_page, meta={'name': product_name, 'description': product_description, 'url': url})

    def parse_download_page(self, response):
        next_url = None
        
        # 기존 정보
        name = response.meta.get('name')
        description = response.meta.get('description')
        div = response.xpath('//div[@class=" sel_mg"]')
        options = div.xpath('.//select/option')

        # url 생성에 사용될 ver_id 및 d value
        d_value = PADDING
        ver_id = None
        for option in options:
            value = option.xpath('@value').get()
            if value:
                ver_id = value

        if ver_id != None:
            next_url = f'https://support.dlink.com/ajax/ajax.ashx?d={d_value}&action=productfile&lang=en-US&ver={ver_id}&ac_id=1'

        if next_url:
            yield scrapy.Request(url=next_url, callback=self.parse_products, meta={'name': name, 'description': description})

    def parse_products(self, response):
        # 기존 가져온 데이터
        model = response.meta.get('name')
        description = response.meta.get('description')
        # JSON 텍스트를 딕셔너리로 변환
        data = json.loads(response.text)

        # "filetypename"이 "Firmware"인 파일 정보를 추출
        firmware_files = []
        for item in data['item']:
            for file in item['file']:
                if file['filetypename'] == 'Firmware':
                    firmware_files.append(file)

        for firmware in firmware_files:
            version = firmware['name']
            date = firmware['date']
            download = firmware['url']

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