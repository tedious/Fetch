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

    public function getData($key, $datatype)
    {
      switch ($datatype){
        
        case 'uidlist':
          $sqlselect = 'select datakey, data from datacontainer where datakey = :datakey';
          $stmt = $this->dbfile->prepare($sqlselect);
          $stmt->bind(':datakey', $key);
          //$stmt->execute();
          $data = $stmt->fetchAll();
          var_dump($data);
          break;
        
        case 'messagelist':
          $sqlselect = 'select uid, headers, plaintextMessage, htmlMessage, date , subject, size, headerfrom, headerto, headercc, headerbcc, headerreplyTo, hasAttachment, email from messages';
          break;
      }
    }

    public function saveData($key, $datatype, $data)
    {
      switch ($datatype){
        case 'folderlist':
          $sqlinsert = 'INSERT into folderlist (foldername, connectionstring) values (:foldername, :connectionstring)';
          $stmt = $this->db_file->prepare($sqlinsert);
          var_dump($data);
          foreach($data as $folder)
          {
            $stmt->bindParam('foldername', $folder);
            $stmt->bindParam('connectionstring', $key);
            $stmt->execute();
          }
          break;
        
        case 'uidlist':
          $sqlinsert = 'INSERT INTO datacontainer (datakey, data) values (:datakey, :data)';
          $stmt = $this->db_file->prepare($sqlinsert);
          $stmt->bindParam('datakey', $key);
          $stmt->bindParam('data', serialize($data));
          $stmt->execute();
          break;
        
        case 'messagelist':
          $sqlinsert = 'INSERT INTO messages (uid, headers, plaintextMessage, htmlMessage, date , subject, size, headerfrom, headerto, headercc, headerbcc, headerreplyTo, hasAttachment, email) ';
          $sqlinsert .= 'VALUES (:uid, :headers, :plaintextMessage, :htmlMessage, :date , :subject, :size, :from, :to, :cc, :bcc, :replyTo, :hasAttachment, :email)';
          $stmt = $this->db_file->prepare($sqlinsert);
          $stmt->bindParam('uid', $data->getUid());
          $stmt->bindParam('headers', serialize($data->getHeaders()));
          $stmt->bindParam('plaintextMessage', $data->getPlaintextMessage());
          $stmt->bindParam('htmlMessage', $data->getHtmlMessage());
          $stmt->bindParam('date', $data->getDate());
          $stmt->bindParam('subject', $data->getSubject());
          $stmt->bindParam('size', $data->getSize());
          $stmt->bindParam('from', serialize($data->getFrom()));
          $stmt->bindParam('to', serialize($data->getTo()));
          $stmt->bindParam('cc', serialize($data->getCc()));
          $stmt->bindParam('bcc', serialize($data->getBcc()));
          $hasAttachment = 0;
          if($data->getAttachments()){
            $hasAttachment = 1;
          }
          $stmt->bindParam('hasAttachment', $hasAttachment);
          $stmt->execute();
          break;
      }
    }
}
