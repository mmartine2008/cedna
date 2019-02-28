#!/bin/bash
sqlcmd -S localhost -U admin -P UMwFE4vumKPy -Q "BACKUP DATABASE [MADYS_GIRO_TEST] TO DISK = N'/home/mariano/tmp/giro.bak' WITH NOFORMAT, NOINIT, NAME = 'trp-full', SKIP, NOREWIND, NOUNLOAD, STATS = 10"

