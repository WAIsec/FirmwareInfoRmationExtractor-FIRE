import subprocess

class BDGinfo:
    def __init__(self, info):
        self.bin_info = info
        
    def update_bdg(self):
        self.find_chain()
        return self.bin_info

    def find_chain(self):
        for bin_path, info in self.bin_info.items():
            connections = []
            # If bin doesn't have any env, ignore it
            if info['used_nvram_env'] == 1: 
                for tar_bin_path, tar_bin_info in self.bin_info.items():
                    # except itself
                    if bin_path == tar_bin_path:
                        continue

                    for keyword in info['keywords']:
                        if keyword in tar_bin_info['keywords']:
                            connections.append(tar_bin_path)
                            break
                # update BDG
                self.bin_info[bin_path]['bdg'] = list(set(connections))
            else:
                # update BDG
                self.bin_info[bin_path]['bdg'] = list(set(connections))