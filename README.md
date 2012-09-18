Fetch
=====

Fetch is a library for reading email and attachments, primarily using the POP 
and IMAP protocols.

Fetch was part of a large project, Mortar, which is hosted on Google Code. It is
currently being migrated over to Github, as well as being updated to support
modern php features. While the project is in flux I encourage you to try it out,
but be careful about using it in a production environment without proper
testing.

Installation
============

The most easy way to install the library is via composer. To do so, you have to do
the following:

    php composer.phar require tedivm/fetch

Composer will then ask you which version you want to install. Until there are stable
versions, by using "@dev" it'll install the latest version.

Sample Usage
============

This is just a simple code to show how to access messages by using Fetch. It uses Fetch
own autoload, but it can (and should be, if applicable) replaced with the one generated
by composer.

    require 'autoload.php';

    $server = new \Fetch\Server('imap.example.com', 993);
    $server->setAuthentication('dummy', 'dummy');


    $messages = $server->getMessages();
    /** @var $message \Fetch\Message */
    foreach ($messages as $message) {
        echo "Subject: {$message->getSubject()}\nBody: {$message->getMessageBody()}\n";
    }
