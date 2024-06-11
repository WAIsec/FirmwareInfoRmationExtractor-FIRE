import subprocess

class BDGinfo:
    def __init__(self, info):
        self.bin_info = info
        
    def update_bdg(self):
        self.find_chain()
        return self.bin_info

    def find_chain(self):
        for std_bin in self.bin_info:
            std_bin['bdg'] = []
            connections = []
            # If bin doesn't have any env, ignore it
            if std_bin['used_nvram_env'] != 1:
                continue
            for tar_bin in self.bin_info:
                # except itself
                if std_bin['bin_name'] == tar_bin['bin_name']:
                    continue
                for keyword in std_bin['keywords']:
                    if keyword in tar_bin['keywords']:
                        connections.append(tar_bin['bin_name'])
                        break
                    else:
                        continue
            # update BDG
            std_bin['bdg'] = list(set(connections))