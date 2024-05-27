# Define here the models for your scraped items
#
# See documentation in:
# https://docs.scrapy.org/en/latest/topics/items.html

import scrapy


class FbomItem(scrapy.Item):
    # define the fields for your item here like:
    # name = scrapy.Field()
    Vendor = scrapy.Field()
    Model = scrapy.Field()
    Version = scrapy.Field()
    Date = scrapy.Field()
    Checksum = scrapy.Field()
    Description = scrapy.Field()
    Download = scrapy.Field()
    pass
