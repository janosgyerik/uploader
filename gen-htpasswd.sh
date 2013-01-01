#!/bin/sh

cd $(dirname "$0")

cat <<EOF >.htaccess
AuthType Basic
AuthName "private area"
AuthBasicProvider file
AuthUserFile $(pwd)/htpasswd
Require valid-user
EOF

test $# -gt 1 && flags=-bc || flags=-c
htpasswd $flags htpasswd $*
