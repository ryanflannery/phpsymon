#!/bin/sh

echo '<?php'

/bin/cat /etc/fstab \
| /usr/bin/sed 's/^\/dev\///' \
| /usr/bin/awk '{ print "$alias[\"df\"][\"" $1 "\"][\"mount\"] = \"" $2 "\";"
                  print "$alias[\"df\"][\"" $1 "\"][\"type\"]  = \"" $3 "\";"
                  print "$alias[\"df\"][\"" $1 "\"][\"param\"] = \"" $4 "\";"
                }'

echo '?>'


