<?php

namespace ETLAB;

/**
 * Class to give PHP Oprattions which help in consistent PHP for project.
 *
 * @author ETLAB Team
 */

class Operation
{

    public static function dirToArray($dir){
        $result = array();
		$cdir = scandir($dir);
		foreach ($cdir as $key => $value)
		{
		  if (!in_array($value,array(".","..","temp")) && strpos($value,"_") === false && strpos($value,"bak") === false)
		  {
			 if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
			 {
				$result[$value] = Operation::dirToArray($dir . DIRECTORY_SEPARATOR . $value);
			 }
			 else
			 {
				$result[] = $value;
			 }
		  }
		}
		return $result;
    }

}