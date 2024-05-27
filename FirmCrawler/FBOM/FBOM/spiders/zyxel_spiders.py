import scrapy
import re
from scrapy.http import Request

class ZyxelSpider(scrapy.Spider):
    name = 'zyxel_spider'
    allowed_domains = ['zyxel.com']
    base_url = 'https://www.zyxel.com/global/en/search_api_autocomplete/product_list_by_model?display=block_3&&field=model_machine_name&filter=model&q='
    download_page_url = 'https://www.zyxel.com/global/en/support/download?model='
    vendor = 'Zyxel'
    base_output = 'dataset/'

    def start_requests(self):
        candidates = list(map(chr, range(97, 123)))  # Generating a list of lowercase alphabets
        
        for alpha in candidates:
            url = self.base_url + alpha
            yield scrapy.Request(url=url, callback=self.parse_products)

    def parse_products(self, response):
        products = self.extract_values(response.text)
        for product in products:
            url = self.download_page_url + product
            yield Request(url=url, callback=self.parse_product_information)

    def parse_product_information(self, response):
        product_info = response.xpath('//div[@class="product-info"]/h5/text()').get().strip()
        product_description = response.xpath('//div[@class="product-description"]/text()').get().strip()
        
        firmware_rows = response.xpath('//tr[.//td[contains(text(), "Firmware")]]')
        for row in firmware_rows:
            version = row.xpath('.//td[@class="views-field views-field-field-version"]/text()').get().strip()
            date = row.xpath('.//td[@class="views-field views-field-field-release-date"]/text()').get().strip()
            checksum = row.xpath('.//div[@class="modal fade modal-checksum modal-dl-library-popup"]//div[@class="modal-body"]//p/text()').getall()
            checksum = [c.strip() for c in checksum]
            download = row.xpath('.//div[@class="modal fade modal-dl-library-popup"]//a[@class="btn btn-primary"]/@href').get()

            yield {
                'Vendor': self.vendor,
                'Model': product_info,
                'Version': version,
                'Date': date,
                'Checksum': checksum,
                'Description': product_description,
                'Download': download
            }

    def extract_values(self, input_string):
        matches = re.findall(r'"value":"(.*?)"', input_string)
        return matches
