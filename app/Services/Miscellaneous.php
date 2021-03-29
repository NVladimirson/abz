<?php

namespace App\Services;


class Miscellaneous
{

    private static $instance;
    public static function getInstance()
    {
      if (null === static::$instance) {
        static::$instance = new static();
      }
 
      return static::$instance;
    }
	public static function highlightSubstr($findfrom, $tofind, $tag = 'b'){
		$length_find_in = strlen($findfrom);
		$length_to_find = strlen($tofind);
		$position = stripos($findfrom,$tofind);
        if($tofind == '' || $position === false || strlen($length_find_in) < strlen($length_to_find)){
            return $findfrom;
        }
        else{
        	return substr($findfrom, 0,$position).'<'.$tag.'>'.substr($findfrom,$position,$length_to_find).'</'.$tag.'>'.substr($findfrom, $position+$length_to_find);	
        }

		}

}
