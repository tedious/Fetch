<?php

include_once 'autoload.php';

$fileCache = new Fetch\FileCache('/tmp/mails');

$server = new \Fetch\LazyServer('imap.gmail.com', 993);
$server->setAuthentication('username', 'password');
$server->setCacheHandler($fileCache);

$searchOk = $server->search('SINCE '. date('d-M-Y',strtotime("-1 week")));
$counter = 0;
var_dump(time());
while($searchOk)
{
  $messages = $server->retrieveNextMessagesInLine();
  /** @var $message \Fetch\Message */
  foreach ($messages as $message) {
      //echo 'here : '.$counter;
      $counter++;
      //echo "Subject: {$message->getSubject()}\nBody: {$message->getMessageBody()}\n";
  }
  if(count($messages) == 0){
    $searchOk = false;
  }
  unset($messages);
}

$server->closeImapStream();
var_dump('Quantity: '.$counter);
var_dump(time());