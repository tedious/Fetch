#!/bin/sh

if which postfix > /dev/null; then
    echo 'Postfix is already installed'
else
    echo 'Installing Postfix'
    sudo debconf-set-selections <<< "postfix postfix/mailname string precise64"
    sudo debconf-set-selections <<< "postfix postfix/main_mailer_type string 'Local only'"
    sudo apt-get -qq update
    sudo apt-get -qq -y install postfix mailutils
    sudo postconf -e 'home_mailbox = Maildir/'
fi
