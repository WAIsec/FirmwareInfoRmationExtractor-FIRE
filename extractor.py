from FirmParser.utils import extract_filesystem, flatten_directory_structure
from FirmParser.unpacker import decompress_files
import argparse
import os

def main():
    """
    This program was created to preprocess the dataset
    """
    parser = argparse.ArgumentParser(description="Use to extract firmware filesystem")
    # firmware file path
    parser.add_argument("-p", "--path", type=str, help="Target path")
    parser.add_argument("-n", "--name", type=str, help="Input the vendor name")
    parser.add_argument("-u", "--unpack", type=str, help="Unpacking firmware file")
    parser.add_argument("-f", "--flat", type=str, help="Flatten directory structure")
    parser.add_argument("-e", "--extract", type=str, help="Extract entire filesystem")
    args = parser.parse_args()
    
    # if the firmware compressed, then decompress them
    if args.unpack == "y":
        decompress_files(args.path)
    
    if args.flat == "y":
        flatten_directory_structure(args.path)
    
    if args.extract == "y":
        extract_filesystem(args.path, args.name)

if __name__ == '__main__':
    main()