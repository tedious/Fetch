<?php

include_once 'autoload.php';

//$fileCache = new Fetch\FileCache('/tmp/mails');
$fileCache = new Fetch\SqliteCache('basicDb');

$server = new \Fetch\LazyServer('imap.gmail.com', 993);
$server->setAuthentication('user', 'password');
$server->setCacheHandler($fileCache);
var_dump('aca??');
$folders = $server->retrieveAllMailboxes();
var_dump($folders);
die;
$searchOk = $server->search('SINCE '. date('d-M-Y',strtotime("-1 week")));
$counter = 0;
var_dump(time());
while ($searchOk) {
  $messages = $server->retrieveNextMessagesInLine();
  /** @var $message \Fetch\Message */
  foreach ($messages as $message) {
      //echo 'here : '.$counter;
      $counter++;
      //echo "Subject: {$message->getSubject()}\nBody: {$message->getMessageBody()}\n";
  }
  if (count($messages) == 0) {
    $searchOk = false;
  }
//  $searchOk = false;
  unset($messages);
}

$server->closeImapStream();
var_dump('Quantity: '.$counter);
var_dump(time());
