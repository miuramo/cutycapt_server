<?php

$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL );
$x = filter_input(INPUT_GET, 'x', FILTER_SANITIZE_NUMBER_INT);
$y = filter_input(INPUT_GET, 'y', FILTER_SANITIZE_NUMBER_INT);
$w = filter_input(INPUT_GET, 'w', FILTER_SANITIZE_NUMBER_INT);
$h = filter_input(INPUT_GET, 'h', FILTER_SANITIZE_NUMBER_INT);

if (!isset($url) || strlen($url)<5 ){
  header("Content-type: text/html");
  echo "<html><body><h1>CutyCapt<br>Usage: index.php?url=...&x=..&y=..&w=..&h=..</h1>";
  echo "<h2>Examples</h2>";
  echo "<a href=\"index.php?url=http://tobata.asia/\" >tobata.asia</a><br>";
  echo "<a href=\"index.php?url=http://tobata.asia/&x=100&y=100&w=200&h=150\" >tobata.asia +100+100_200x150</a><br>";
  echo "<a href=\"index.php?url=http://tobata.asia/&x=300&y=100&w=200&h=150\" >tobata.asia +300+100_200x150</a><br>";

  echo "<h2>Links</h2>";
  echo "<a href=\"link.php\">link.php</a> returns text/plain <br>";
  echo "<a href=\"index.php\">index.php</a> returns image/png";
  echo "</body></html>";
  exit();
}

// echo $url;

// ex. 171024_123456
$date = date("ymd_His");
$rnd = sprintf("_%03d", rand(0,999)); // avoid duplicated filenames

$fname = $date.$rnd.".png";

$out = exec( 'xvfb-run --server-args="-screen 0, 1024x1024x24" cutycapt --url='.$url.' --min-width=1024 --out='.$fname );

// Utilize PHP-GD function to crop
if (isset($x) && isset($y) && isset($w) && isset($h)){
  if (is_numeric($x) && is_numeric($y) && is_numeric($w) && is_numeric($h)){
    $im = imagecreatefrompng($fname);
    $im2 = imagecrop($im, ['x'=>$x, 'y'=>$y, 'width'=>$w, 'height'=>$h]);
    if ($im2 !== FALSE){
       $fname = $date.$rnd."crop.png";
       imagepng($im2, $fname); 
    }
  }
}

header("Content-type: image/png");
readfile($fname);

