<?php
// namespace ETLAB;

function spaceremove($str){
	return str_replace(' ', '-', $str);
}

function redirect($url) 
{
echo '<script type="text/javascript">window.location="'.$url.'";</script>';
}

function baseurl(){
    // return sprintf(
    //   "%s://%s",
    //   isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',$_SERVER['SERVER_NAME']
    // );
    return 'http://localhost/SkyLineKart';
}


function slugify($text, $divider = '-'){
  // replace non letter or digits by divider
  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, $divider);

  // remove duplicate divider
  $text = preg_replace('~-+~', $divider, $text);

  // lowercase
  $text = strtolower($text);

  return $text;
}
?>