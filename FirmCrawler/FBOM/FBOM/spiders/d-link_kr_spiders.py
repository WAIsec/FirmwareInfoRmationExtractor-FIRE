import scrapy
import re
class DlinkKRspiders(scrapy.Spider):
    name = 'd-link(kr)_spider'
    vendor = 'D-Link(KR)'
    allowed_domains = ['mydlink.co.kr']

    base_url = 'https://mydlink.co.kr'
    support = '/2013/beta_board/'
    products_list_page = 'pds.php'

    custom_settings = {
    'LOG_LEVEL': 'ERROR'
    }

    def start_requests(self):
        url = self.base_url + self.support + self.products_list_page
        yield scrapy.Request(url=url, callback=self.parse_products_list)

    def parse_products_list(self, response):
        # pattern
        pattern = r'new Option\("([^"]+)",\s*"([^"]+)"\)'
        matches = re.findall(pattern, response.text)
        for match in matches:
            product = match[0]
            link = match[1]
            url = self.base_url + self.support + link
            print(url)
            yield scrapy.Request(url=url, callback=self.parse_product, meta={'product': product})

    def parse_product(self, response):
        # 이미지의 상위에 있는 첫 번째 table 선택
        table_element = response.xpath("//img[contains(@src, '/2008/support/img/firmware_title.gif')]/ancestor::table[1]")
        model = response.meta.get('product')
        
        # 상위 테이블 내부의 모든 tr 요소 반복
        first = True
        detail_table =table_element.xpath(".//table")

        for tr in detail_table.xpath(".//tr"):  
            # 첫 번째 행은 건너뜁니다.
            if first:
                first = False
                continue

            # 마지막 행은 건너뜁니다.
            if tr.xpath("@bgcolor").extract_first() == '#ffffff':
                continue

            # td 요소가 존재하는지 확인
            td_elements = tr.xpath(".//td")
            if not td_elements:
                continue

            # 데이터가 있는 행인지 확인
            if len(td_elements) >= 4:
                # 첫 번째 td 요소에 있는 버전 정보 추출
                version = td_elements[0].xpath("normalize-space(.)").extract_first()

                # 두 번째 td 요소에 있는 날짜 정보 추출
                date = td_elements[1].xpath("normalize-space(.)").extract_first()

                # 세 번째 td 요소에 있는 비고 정보 추출
                description = td_elements[2].xpath("normalize-space(.)").extract_first()

                # 네 번째 td 요소에 있는 다운로드 링크 정보 추출
                download_link = td_elements[3].xpath("./a/@href").extract_first()
                download = self.base_url + download_link if download_link else None
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
