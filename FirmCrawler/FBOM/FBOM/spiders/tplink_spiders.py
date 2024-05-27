import scrapy

class TplinkSpiders(scrapy.Spider):
    name = 'tplink_spider'
    vendor = 'TpLink'
    allowed_domains = ['tp-link.com']
    custom_settings = {
    'LOG_LEVEL': 'ERROR'
    }
    download_url = '/en/support/download/'
    base_url = 'https://www.tp-link.com'

    def start_requests(self):
        url = self.base_url + self.download_url
        yield scrapy.Request(url=url, callback=self.parse_products)
        
    def parse_products(self, response):
        a_tags = response.xpath('//a[@class="ga-click"]')
        for a in a_tags:
                firm_page_url = a.xpath('@href').get()
                if firm_page_url and not firm_page_url.startswith('https://'):
                    url = firm_page_url + '#Firmware'
                    model = a.xpath('normalize-space(text())').get()
                    yield response.follow(url, callback=self.parse_info, meta={'model': model})

    def parse_info(self, response):
        table_tags = response.xpath('//table[@class="download-resource-table"]')

        model = response.meta.get('model')

        for table in table_tags:
            version = table.xpath('.//p/text()')
            if version:
                version = version.get().strip()
            else:
                version = None
            download = table.xpath('.//a/@href').get()
            if download == None:
                continue
            date = table.xpath('.//span[contains(text(), "Published Date:")]/following-sibling::span/text()').get().strip()
            
            # 각 Selector 객체에서 텍스트 값을 추출하고 strip() 메소드를 적용하여 공백을 제거합니다.
            text_values = [text.get().strip() for text in table.xpath('.//tr[@class="more-info"]//text()')]
        
            # 공백 문자를 제거하고 결과를 반환합니다.
            description = ' '.join(text for text in text_values if text)
            # description = ' '.join(text.get().strip() for text in text_values if text.get().strip())
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