import json
import sys
from utils import *

class FsExtractor:
    def __init__(self, config_path):

        # Load config file
        self._config = json.load(open(config_path))
        self._config = dict((k, v) for k, v in self._config.items() if v)
        self._fw_path = self._config['fw_path']

        # Load binaries from firmware filesystem
        self._bins = get_binaries(self._fw_path)

    def level1_extractor(self):
        """
        This method extracts informations such as 1) web source file, 2) script file, 3) configuration file, 4) OS essential binary from firmware image 
        
        :return: web source file list, script file list, configuration file list, Os essentail binary list 
        """
        web_sources = []
        script_sources = []
        for file in self._bins:
            # Identify web source files
            for extension in WEB_EXTENSION:
                if extension in file:
                    web_sources.append(file)
            # Identify script source files
            for extension in SCRIPT_EXTENSION:
                if extension in file:
                    script_sources.append(file)
        
        return web_sources, script_sources
    
    