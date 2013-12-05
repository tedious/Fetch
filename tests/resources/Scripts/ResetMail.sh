#!/bin/sh

echo 'Refreshing the test mailbox- this could take a minute.'

sudo stop dovecot
[ -d "/home/testuser/Maildir" ] && sudo rm -R /home/testuser/Maildir
sudo cp -Rp /resources/Maildir /home/testuser/
sudo chown -R testuser:testuser /home/testuser/Maildir
sudo start dovecot

echo 'Test mailbox restored'.