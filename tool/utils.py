import sys
import subprocess


WEB_EXTENSION = ['.html', '.htm', '.xhtml', '.xml', '.xul']
SCRIPT_EXTENSION = ['.php', '.js', '.asp', '.ps', '.eps', '.vbs', '.cgi', '.rc']

def get_binaries(fw_path):
    cmd = f'ls -R {fw_path}'
    file_list = exec_cmd(cmd)

    return file_list

def exec_cmd(cmd):
    try:
        result = subprocess.run(cmd, shell=True, capture_output=True, text=True)
        if result.returncode == 0:
            print("cmd executed sucessfully")
            return result.stdout.decode().split('\n')
        else:
            print("Error executing cmd, return code: ", result.returncode)
    except Exception as e:
        print("An error occurred: ", e)
    
    return []
