<?php
date_default_timezone_set('Asia/Tokyo');
header("Content-type: text/plain");

$i = filter_input(INPUT_GET, 'i', FILTER_SANITIZE_URL );

if (!isset($i) || strlen($i)<5 || substr($i,0,1)==='/' || substr($i,0,1)==='.' ){
  echo "image path invalid\n";
  echo "example: https://cutycapt.tobata.asia/info.php?i=img/_075/171213_212946_075.png";
  exit();
}

if (!file_exists($i)) {
  echo "nofile 0";
  exit();
}

$md5 = md5_file($i);
$fsize = filesize($i);
echo $md5." ".$fsize;

