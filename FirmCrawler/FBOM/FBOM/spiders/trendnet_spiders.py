import scrapy

class TrendnetSpider(scrapy.Spider):
    name = 'trendnet_spider'
    vendor = 'Trendnet'
    allowed_domains = ['trendnet.com']
    custom_settings = {
        'LOG_LEVEL': 'ERROR'
    }
    download_url = 'https://downloads.trendnet.com/'
    
    def start_requests(self):
        yield scrapy.Request(url=self.download_url, callback=self.parse_products)

    def parse_products(self, response):
        links = response.xpath('//a[not(contains(text(), "Directory"))][not(contains(text(), "To Parent Directory"))]')
        for link in links:
            href = link.xpath('@href').get()
            text = link.xpath('normalize-space(text())').get()
            
            yield response.follow(href, callback=self.parse_link, meta={'product': text})

    def parse_link(self, response):
        firmware_tag = response.xpath('//a[contains(text(), "firmware")]')
        if firmware_tag:
            firmware_link = firmware_tag.xpath('@href').get()
        else:
            firmware_tag = response.xpath('//a[contains(text(), "Firmware")]')
            if firmware_tag:
                firmware_link = firmware_tag.xpath('@href').get()
            else:
                firmware_link = None

        product = response.meta.get('product')
        if firmware_link:
            yield response.follow(firmware_link, callback=self.parse_firmware, meta={'product': product})


    def parse_firmware(self, response):
        links = response.xpath('//a[not(contains(text(), "[To Parent Directory]"))]')
        model = response.meta.get('product')
        for link in links:
            # <a> 태그의 href 속성 값을 추출합니다.
            download = self.download_url + link.xpath('@href').get()
            version = link.xpath('normalize-space(text())').get()
            # 확장자 제거
            version = version.rsplit('.', 1)[0]
            # <a> 태그 직전에 위치한 시간 값을 추출합니다.
            date = link.xpath('preceding::text()[1]').get().strip()
            
            # Test 출력
            print("-------------------")
            print("model: ", model)
            print("version: ", version)
            print("date: ", date)
            print("download: ", download)

            yield {
                'Vendor': self.vendor,
                'Model': model,
                'Version': version,
                'Date': date,
                'Checksum': None,
                'Description': None,
                'Download': download
            }
