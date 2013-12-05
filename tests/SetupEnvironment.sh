#!/bin/sh

if [ -n "$TRAVIS" ]; then

    echo 'Travis config not yet written'
    sudo cp -Rp $TRAVIS_BUILD_DIR/tests/resources /resources
    sudo /bin/bash /resources/Scripts/Provision.sh

else

    # Since not in travis, lets load up a system with vagrant

    DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

    cd $DIR/vagrant

    VAGRANTSTATUS=$(vagrant status)

    # If vagrant is running already, reprovision it so it has fresh email boxes.
    if echo "$VAGRANTSTATUS" | egrep -q "running" ; then
        vagrant provision
    else
        vagrant up --provision
    fi
    cd $DIR

fi