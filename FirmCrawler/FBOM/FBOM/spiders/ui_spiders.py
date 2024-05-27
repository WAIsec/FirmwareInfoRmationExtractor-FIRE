import scrapy
import json
from scrapy.http import Request
from selenium import webdriver
from scrapy.selector import Selector
import time


# erase logging
import logging
from selenium.webdriver.remote.remote_connection import LOGGER

# 로그 수준 설정
logging.getLogger('selenium').setLevel(logging.WARNING)
LOGGER.setLevel(logging.WARNING)

class UiSpider(scrapy.Spider):
    name = 'ui_spider'
    allowed_domains = ['ui.com']
    download_page_url = 'https://www.ui.com/download/software/'
    products_url = 'https://download.svc.ui.com/v1/products'
    vendor = 'UI'
    base_output = 'dataset/'

    def start_requests(self):
        # Send request to get the products information
        yield scrapy.Request(url=self.products_url, callback=self.parse_products)

    def parse_products(self, response):
        # Parse the products from the response
        products = json.loads(response.body)
        for product in products.get('products', []):
            url = self.download_page_url + product.get('slug', '')
            model = product.get('title', '')
            # Pass additional data to parse_product_information using meta
            yield scrapy.Request(url=url, callback=self.parse_product_information, meta={'product_url': url, 'model': model})

    def parse_product_information(self, response):
        # Retrieve additional data from meta
        product_url = response.meta.get('product_url')
        model = response.meta.get('model')
        driver = webdriver.Chrome()      # using selenium
        # Use product_url to navigate with Selenium
        driver.get(product_url)
        time.sleep(5)

        response = Selector(text=driver.page_source)
        # Close the Selenium webdriver
        driver.quit()

        divs = response.xpath('//div[@class="sc-kypfzD zxngV"]')
        for div in divs:
            if not div.xpath('.//div[@class="sc-hMBXfw sc-iEkSXm cDTpEk jhUAGF headings"]/h6[contains(@class, "sc-dfzyxB sc-bfUCjU lcFXwK cBGDQx firmware")]'):
                continue

            firmware_rows = div.xpath('.//div[@class="sc-hMBXfw cDTpEk"]')
            for row in firmware_rows:
                version = row.xpath('.//div[@class="sc-fInFcU sc-hCrRFl fkQDMR fYQcpq"]//p[@class="sc-bdlOLf kLCsXW"]/text()').get().strip()
                date = row.xpath('.//div[@class="sc-fInFcU fkQDMR"]//span[@class="sc-bOTbmH gRqZVg"]/text()').get().strip()
                download = row.xpath('.//div[@class="sc-fInFcU sc-hCrRFl fkQDMR fYQcpq"]//a[@class="sc-fYKINB sc-cZYOMl sc-dLmyTH jSHbpY bnXGpf kIrBEv file"]/@href').get()
                release_notes = row.xpath('.//div[@class="sc-fInFcU fkQDMR"]//a[@class="sc-fYKINB sc-cZYOMl jSHbpY kzWaGA"]/@href').get()
                checksum, description = self.parse_release_notes(url=release_notes)

                print("-------------------")
                print("model: ", model)
                print("version: ", version)
                print("date: ", date)
                print("checksum: ", checksum)
                print("description: ", description)
                print("download: ", download)

                yield {
                    'Vendor': self.vendor,
                    'Model': model,
                    'Version': version,
                    'Date': date,
                    'Checksum': checksum,
                    'Description': description,
                    'Download': download
                }

    def parse_release_notes(self, url):
        ret = list()
        md5sum_href = None
        sha256_href = None
        description = None

        driver = webdriver.Chrome()      # using selenium
        # Use product_url to navigate with Selenium
        driver.get(url)
        time.sleep(5)

        response = Selector(text=driver.page_source)
        # Close the Selenium webdriver
        driver.quit()
        md5sum = response.xpath('//a[contains(text(), "md5sum")]')
        if md5sum:
            md5sum_href = md5sum.xpath('@href').get()  # md5sum 링크의 href 속성 값 가져오기
        
        sha256 = response.xpath('//a[contains(text(), "sha256sum")]')
        if sha256:
            sha256_href = sha256.xpath('@href').get()  # sha256sum 링크의 href 속성 값 가져오기
        
        description_div = response.xpath('//div[.//h2[contains(text(), "Overview")]]')
        if description_div:
            description = description_div.xpath('.//p/text()').get().strip()

        ret.append(md5sum_href)
        ret.append(sha256_href)

        return ret, description
