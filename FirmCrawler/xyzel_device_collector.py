import requests
import pandas as pd
from bs4 import BeautifulSoup
from utils import *

def collect_products():
    """
    Get information about vendor's products and model list
    : return products_info : the list related to products type and corresponding link
    """
    # Web URL
    url = 'https://www.zyxel.com/global/en/products'
    
    # enter to products page
    response = requests.get(url)
    
    ret = list()

    # check response
    if response.status_code == 200:
        # read page
        soup = BeautifulSoup(response.text, 'html.parser')
        
        # find div tag, which has class name 'product-list-item'
        product_divs = soup.find_all('div', class_='product-list-item')
        
        for div in product_divs:
            # find sub tag for each div tags
            a_tag = div.find('a')
            # extract href from a tag
            if a_tag and 'href' in a_tag.attrs:
                href = a_tag['href']
                print("href:", href)
            # extract Products type from img tag
            img_tag = div.find('img')
            if img_tag and 'alt' in img_tag.attrs:
                product = img_tag['alt']
                print("alt: ", product)
            ret.append([product, href])
        
        return ret 
    else:
        print("Error, at collect_products")

def collect_models(base_info):
    # page URL
    for products, href in base_info:
        # enter products page
        response = requests.get(href)
        if response.status_code == 200:
            soup = BeautifulSoup(response.text, 'html.parser')
            # find li tag, which has class name 'product-item-info'
            products_info = soup.find_all('div', class_='product-item-info')
            for div in products_info:
                # Series: class id: field field--name-field-prod-desc field--type-string field--label-hidden field--item
                # Model:  <h5> tag
                model_tag = div.h5.text
                

                

            
        else:
            print("Response Error, at collect_model")
    

if __name__ == '__main__':
    total_xyzel_info = make_dict()
    # get base_info [Products type, search page href]
    base_info = collect_products()