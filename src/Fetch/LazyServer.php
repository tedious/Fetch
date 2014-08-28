<?php

namespace Fetch;

/**
 * Description of LazyServer
 *
 * @author Rodrigo Santellan
 */
class LazyServer extends Server{

    private $uidList = array();
    private $page = 0;
    private $limitSize = 10;
    private $cacheHandler = null;
    
    public function getLimitSize() {
      return $this->limitSize;
    }

    public function setLimitSize($limitSize) {
      $this->limitSize = $limitSize;
    }
    
    public function getCacheHandler() {
      return $this->cacheHandler;
    }

    public function setCacheHandler($cacheHandler) {
      $this->cacheHandler = $cacheHandler;
    }

    
    /**
     * This function returns an array of ImapMessage object for emails that fit the criteria passed. The criteria string
     * should be formatted according to the imap search standard, which can be found on the php "imap_search" page or in
     * section 6.4.4 of RFC 2060
     *
     * @link http://us.php.net/imap_search
     * @link http://www.faqs.org/rfcs/rfc2060
     * @param  string   $criteria
     * @param  null|int $limit
     * @return array    An array of ImapMessage objects
     */
    public function search($criteria = 'ALL', $limit = null)
    {
        $cacheKey = $this->getServerString().'-'.$criteria;
        if($this->cacheHandler !== null)
        {
          
          $results = $this->cacheHandler->getData($cacheKey);
          if($results){
            $this->uidList = $results;
            return true;
          }
        }
        
        
        if ($results = imap_search($this->getImapStream(), $criteria, SE_UID)) {
            $this->uidList = $results;
            if($this->cacheHandler !== null)
            {
              $this->cacheHandler->saveData($cacheKey, $results);
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function retrieveNextMessagesInLine()
    {
      $results = array_slice($this->uidList, $this->page, $this->getLimitSize());
      $messages = array();
      $this->page ++;
      foreach ($results as $messageId)
      {
        $cacheKey = $this->getServerString().'-'.$messageId;
        $inCache = false;
        if($this->cacheHandler !== null)
        {
          $message  = $this->cacheHandler->getData($cacheKey);
          if($message){
            $messages[] = $message;
            $inCache = true;
          }
        }
        if(!$inCache)
        {
          $message = new Message($messageId, $this);
          $messages[] = $message;
          if($this->cacheHandler !== null)
          {
            $this->cacheHandler->saveData($cacheKey, $message);
          }
        }
      }
      return $messages;
    }
}


