import scrapy
from selenium import webdriver
from scrapy.selector import Selector
import time
EXTENSION_LIST = ['.tar.gz', '.tar', '.zip', '.bin', '.trx', '.ipk', '.bin', '.chk', '.img']

class TomatoSpiders(scrapy.Spider):
    name = 'tomato_spider'
    vendor = 'Tomato'
    allowed_domains = ['tomato.groov.pl']
    custom_settings = {
    'LOG_LEVEL': 'ERROR'
    }
    base_url = 'https://tomato.groov.pl'
    download_url = '/download/'

    def start_requests(self):
        url = self.base_url + self.download_url
        yield scrapy.Request(url=url, callback=self.parse_products, meta = {'url': url})
        
    def parse_products(self, response):
        url = response.meta.get('url')
        chrome_options = webdriver.ChromeOptions()
        chrome_options.add_argument('--log-level=3')  # 로그 레벨을 설정하여 오류 메시지 출력 방지
        chrome_options.add_argument('--headless')  # 백그라운드 실행 옵션 추가
        driver = webdriver.Chrome(options=chrome_options)
        driver.get(url)
        time.sleep(3)
        response = Selector(text=driver.page_source)
        driver.quit()
        labels = response.xpath('//li[@class="item folder"]')
        for label in labels:
                label_page_url = self.base_url + label.xpath('.//a/@href').get()
                model = label.xpath('.//span[@class="label"]/text()').get()
                if model:
                    model = model.strip()
                    yield scrapy.Request(url=label_page_url, callback=self.parse_dir, meta={'model': model, 'url': label_page_url})
                else:
                    continue

    def parse_dir(self, response):
        model = response.meta.get('model')
        ver_flag = False
        try:
            version = response.meta.get('version')
            if version != None:
                ver_flag = True
        except:
            print("No version info")

        url = response.meta.get('url')
        chrome_options = webdriver.ChromeOptions()
        chrome_options.add_argument('--log-level=3')  # 로그 레벨을 설정하여 오류 메시지 출력 방지
        chrome_options.add_argument('--headless')  # 백그라운드 실행 옵션 추가
        driver = webdriver.Chrome(options=chrome_options)
        driver.get(url)
        time.sleep(3)
        response = Selector(text=driver.page_source)
        driver.quit()
        dir_candidates = response.xpath('//li[@class="item folder"]')
        file_candidates = response.xpath('//li[@class="item file"]')

        if dir_candidates:
            for cand in dir_candidates:
                next_page_url = self.base_url + cand.xpath('.//a/@href').get()
                
                if ver_flag:
                    version = version + cand.xpath('.//span[@class="label"]/text()').get().strip()
                else:
                    version = cand.xpath('.//span[@class="label"]/text()').get()

                if version != None:
                    version = version.strip()
                    yield scrapy.Request(next_page_url, callback=self.parse_dir, meta={'model': model, 'version': version, 'url': next_page_url})
                else:
                    continue
        
        if file_candidates:
            for cand in file_candidates:
                download = self.base_url + cand.xpath('.//a/@href').get()
                if not any(download.endswith(ext) for ext in EXTENSION_LIST):
                    continue
                end_version = version  + cand.xpath('.//span[@class="label"]/text()').get().strip()
                date = cand.xpath('.//span[@class="date"]/text()').get().strip()

                # Test 출력
                print("-------------------")
                print("model: ", model)
                print("version: ", end_version)
                print("date: ", date)
                print("download: ", download)
                
                yield {
                    'Vendor': self.vendor,
                    'Model': model,
                    'Version': end_version,
                    'Date': date,
                    'Checksum': None,
                    'Description': None,
                    'Download': download
                }