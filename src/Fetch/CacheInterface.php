<?php

namespace Fetch;

/**
 * Description of CacheInterface
 *
 * @author Rodrigo Santellan
 */
interface CacheInterface {

  public function getData($key, $expiration = 3600);
  
  public function saveData($key, $data);
  
  
}


