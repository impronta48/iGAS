#!/bin/bash
./Vendor/bin/phinx migrate -e impronta
./Vendor/bin/phinx migrate -e yepp
./Vendor/bin/phinx migrate -e lindbergh
./Vendor/bin/phinx migrate -e demo
./Vendor/bin/phinx migrate -e labins
./Vendor/bin/phinx migrate -e alberto

