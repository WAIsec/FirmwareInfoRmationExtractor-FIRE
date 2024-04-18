import pandas as pd

def make_dict():
    """
    Generate Dictionary for DB Scheme
    When analyze firmware download site, you can collect following contents
    'Vendor': Firm's vendor
    'Products': Router, Fire wall, etc.
    'Series': Firmware series
    'Model': Device Model
    'Version': Model's version
    'Date': Release Date
    'Checksum': Get the checksum value such as MD5, SHA256, etc.
    """
    ret = pd.DataFrame(columns=['Vendor', 'Products', 'Model', 'Version', 'Date', 'Checksum'])

    return ret
