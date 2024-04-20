import pandas as pd

def make_dict():
    """
    Generate Dictionary for DB Scheme
    When analyze firmware download site, you can collect following contents
    'Vendor': Firm's vendor
    'Products': Router, Fire wall, etc.
    'Model': Device Model & Series
    'Version': Model's version
    'Date': Release Date
    'Checksum': Get the checksum value such as MD5, SHA256, etc.
    'Description': Devices Service
    'Download': Download link
    """
    ret = pd.DataFrame(columns=['Vendor', 'Products', 'Model', 'Version', 'Date', 'Checksum', 'Description', 'Download'])

    return ret

def check_dict(dict):

    for idx in range(0, len(dict)):
        print(f"Vendor: {dict['Vendor'][idx]}, Products: {dict['Products'][idx]}, Model: {dict['Model'][idx]}, Version: {dict['Version'][idx]}, Date: {dict['Date'][idx]}, Checksum: {dict['Checksum'][idx]}, Description: {dict['Description'][idx]}, Download: {dict['Download'][idx]} ")
    print(f"Total link count: {len(dict)}")
