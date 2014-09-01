<?php

namespace Fetch;

/**
 * Description of FileCache
 *
 * @author rodrigo
 */
class SqliteCache implements \Fetch\CacheInterface
{
    private $dbfile = null;
    
    function __construct($dbfile = null) {
	//if null create in memory
	if($dbfile == null)
	{
	    
	}
	else
	{
	    $this->db_file = new \PDO('sqlite:'.$dbfile);
	    // Set errormode to exceptions
	    $this->db_file->setAttribute(\PDO::ATTR_ERRMODE, 
                            \PDO::ERRMODE_EXCEPTION);
	}
    }
    
    private function checkDatabase()
    {
	
    }

    public function getData($key, $expiration = 3600)
    {

    }

    public function saveData($key, $data)
    {
	$sqlinsert = 'INSERT INTO messages (uid, headers, plaintextMessage, htmlMessage, date , subject, size, from, to, cc, bcc, replyTo, hasAttachment, email) ';
	$sqlinsert .= 'VALUES (:uid, :headers, :plaintextMessage, :htmlMessage, :date , :subject, :size, :from, :to, :cc, :bcc, :replyTo, :hasAttachment, :email)';
	var_dump($data);
	$stmt = $this->db_file->prepare($sqlinsert);
	$stmt->bindParam('uid', $data->getUid());
	$stmt->bindParam('headers', $data->getHeaders());
	$stmt->bindParam('plaintextMessage', $data->getPlaintextMessage());
	$stmt->bindParam('htmlMessage', $data->getHtmlMessage());
	$stmt->bindParam('date', $data->getDate());
	$stmt->bindParam('subject', $data->getSubject());
	$stmt->bindParam('size', $data->getSize());
	$stmt->bindParam('from', $data->getFrom());
	$stmt->bindParam('to', $data->getTo());
	$stmt->bindParam('cc', $data->getCc());
	$stmt->bindParam('bcc', $data->getBcc());
	$stmt->bindParam('hasAttachment', (!$data->getAttachments)? 0 : 1);
	$stmt->execute();
    }
}
