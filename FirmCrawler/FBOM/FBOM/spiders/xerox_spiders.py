import scrapy
from scrapy.selector import Selector
from scrapy.http import HtmlResponse
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

class XeroxSpiders(scrapy.Spider):
    name = "XeroxSpiders"

    def start_requests(self):
        # Initial URL to start scraping
        start_url = 'https://www.support.xerox.com/en-us/search-results#q=firmware&t=DriversDownloads&numberOfResults=100'
        yield scrapy.Request(url=start_url, callback=self.parse, meta={'url': start_url})

    def parse(self, response):
        # Initialize Selenium WebDriver
        driver = webdriver.Chrome()
        driver.get(response.meta.get('url'))
        time.sleep(3)  # Wait for dynamic content to load

        # Extracting total number of pages
        total_count = Selector(text=driver.page_source).css('span.coveo-highlight.coveo-highlight-total-count::text').get()
        total_count = int(total_count.replace(',', ''))
        total_pages = total_count // 100 + (1 if total_count % 100 > 0 else 0)
        total_pages = min(total_pages, 10)  # Limiting total pages to 10

        # Extracting firmware download links
        for a_tag in Selector(text=driver.page_source).css('a.CoveoResultLink.coveo-result-title'):
            data_title = a_tag.css('::attr(data-title)').get()
            if 'Downloads' in data_title:
                yield scrapy.Request(url=a_tag.css('::attr(href)').get() + '?language=en', callback=self.parse_firmware)

        # Generating requests for next pages
        for page in range(1, total_pages):
            yield scrapy.Request(
                url=f'https://www.support.xerox.com/en-us/search-results#q=firmware&first={page*100}&t=DriversDownloads&numberOfResults=100',
                callback=self.parse_next_page,
                meta={'driver': driver}  # Pass the WebDriver instance to the next callback
            )

    def parse_next_page(self, response):
        # Extracting firmware download links from next pages
        driver = response.meta['driver']
        for a_tag in Selector(text=driver.page_source).css('a.CoveoResultLink.coveo-result-title'):
            data_title = a_tag.css('::attr(data-title)').get()
            if 'Downloads' in data_title:
                download_page_url = a_tag.css('::attr(href)').get() + '?platform=all&product=&category=firmware&language=en&attributeId='
                yield scrapy.Request(url=download_page_url, callback=self.parse_firmware, meta={'url': download_page_url})

    def parse_firmware(self, response):
        # Initialize Selenium WebDriver
        driver = webdriver.Chrome()
        driver.get(response.meta.get('url'))
        time.sleep(3)  # Wait for dynamic content to load

        # Extracting firmware information
        model = Selector(text=driver.page_source).css('div.xrx-fw-support-hero__heading > h2::text').get().strip()
        firmware_divs = Selector(text=driver.page_source).css('div.xrx-fw-css-grid-row')

        for div in firmware_divs:
            category_text = div.css('h3::text').get()
            if category_text and 'Firmware' in category_text:
                released = div.xpath('.//strong[contains(text(), "Released:")]/following-sibling::text()').get().strip()
                version = div.xpath('.//strong[contains(text(), "Version:")]/following-sibling::text()').get().strip()
                download = div.css('a.xrx-fw-cta::attr(onclick)').re_first(r"window\.location='(.*?)'")
                if download.endswith('.pdf'):
                    continue
                else:
                    print("-------------------")
                    print("model: ", model)
                    print("version: ", version)
                    print("date: ", released)
                    print("checksum: ", None)
                    print("description: ", None)
                    print("download: ", download)

                    yield {
                        'Vendor': self.vendor,
                        'Model': model,
                        'Version': version,
                        'Date': released,
                        'Checksum': None,
                        'Description': None,
                        'Download': download
                    }
                    

        # Close Selenium WebDriver
        driver.quit()
