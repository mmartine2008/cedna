#!/bin/bash
sqlcmd -S localhost -U admin -P UMwFE4vumKPy -Q "BACKUP DATABASE [cedna] TO DISK = N'/home/mariano/tmp/cedna.bak' WITH NOFORMAT, NOINIT, NAME = 'trp-full', SKIP, NOREWIND, NOUNLOAD, STATS = 10"

