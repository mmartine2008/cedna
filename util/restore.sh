#!/bin/bash
sqlcmd -S localhost -U admin -P UMwFE4vumKPy -Q "RESTORE DATABASE [cedna] FROM DISK = N'/home/tmp/cedna.bak' WITH FILE = 1, NOUNLOAD, REPLACE, NORECOVERY, STATS = 5"
sqlcmd -S localhost -U admin -P UMwFE4vumKPy -Q "RESTORE DATABASE cedna WITH RECOVERY"
