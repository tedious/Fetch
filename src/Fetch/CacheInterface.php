<?php

namespace Fetch;

/**
 * Description of CacheInterface
 *
 * @author Rodrigo Santellan
 */
interface CacheInterface
{
  public function getData($key, $datatype);

  public function saveData($key, $datatype, $data);

}
