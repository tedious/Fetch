<?php

require 'src/Fetch/Server.php';
require 'src/Fetch/Message.php';
require 'src/Fetch/Attachment.php';

$server = new \Fetch\Server('imap.gmail.com', 993);
$server->setAuthentication('iskoa.buggenie@gmail.com', '17my3Quqo28JU1yqQR50');


$messages = $server->search('unseen');
/** @var $message \Fetch\Message */
foreach ($messages as $message) {
    echo "Subject: {$message->getSubject()}\nBody: {$message->getMessageBody()}\n";
}
