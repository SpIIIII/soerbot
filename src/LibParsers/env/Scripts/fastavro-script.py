#!d:\php\soerbot\src\libparsers\env\scripts\python.exe
# EASY-INSTALL-ENTRY-SCRIPT: 'fastavro==0.21.19','console_scripts','fastavro'
__requires__ = 'fastavro==0.21.19'
import re
import sys
from pkg_resources import load_entry_point

if __name__ == '__main__':
    sys.argv[0] = re.sub(r'(-script\.pyw?|\.exe)?$', '', sys.argv[0])
    sys.exit(
        load_entry_point('fastavro==0.21.19', 'console_scripts', 'fastavro')()
    )
