#!/bin/sh

stop dovecot

STARTPATH=`pwd`

SSL_CERT=/etc/ssl/certs/dovecot.pem
SSL_KEY=/etc/ssl/private/dovecot.pem

echo "Creating generic self-signed certificate: $SSL_CERT"
cd /etc/ssl/certs
PATH=$PATH:/usr/bin/ssl

#FQDN=`hostname -f`
#MAILNAME=`cat /etc/mailname 2> /dev/null || hostname -f`

FQDN=tedivm.com
MAILNAME=tedivm.com

(openssl req -new -x509 -days 365 -nodes -out $SSL_CERT -keyout $SSL_KEY > /dev/null 2>&1 <<+
.
.
.
Dovecot mail server
$FQDN
$FQDN
root@$MAILNAME
+
) || echo "Warning : Bad SSL config, can't generate certificate."


chown root $SSL_CERT || true
chgrp dovecot $SSL_CERT || true
chmod 0644 $SSL_CERT || true
chown root $SSL_KEY || true
chgrp dovecot $SSL_KEY || true
chmod 0600 $SSL_KEY || true

start dovecot