#!/bin/sh

echo 'Provisioning Environment with Dovecot and Test Messages'

# Install and Configure Dovecot

if which dovecot > /dev/null; then
    echo 'Dovecot is already installed'
else
    echo 'Installing Dovecot'
    sudo apt-get -qq -y install dovecot-imapd dovecot-pop3d
    sudo touch /etc/dovecot/local.conf
    sudo echo 'mail_location = maildir:/home/%u/Maildir' >> /etc/dovecot/local.conf
    sudo echo 'disable_plaintext_auth = no' >> /etc/dovecot/local.conf
    sudo restart dovecot
fi


# Create "testuser"

if getent passwd testuser > /dev/null; then
    echo 'testuser already exists'
else
    echo 'Creating User "testuser"'
    sudo useradd testuser -m -s /bin/bash
    echo "testuser:applesauce"|sudo chpasswd
fi


# Setup Email

/bin/bash /vagrant/ResetMail.sh


echo 'Environment has been provisioned'