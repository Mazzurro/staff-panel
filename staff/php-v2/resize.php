<?php

if (isset($_GET["resizeThis"])) {

header("Content-Type: image/jpeg");
function resizeImage($source, $height) {
  $imageSize = getimagesize($source);
  $thumb = new Imagick($source);
  $thumb->resizeImage((($imageSize[0] * $height) / $imageSize[1]), $height, Imagick::FILTER_LANCZOS, 1);
  $thumbnail = $thumb->getImageBlob();
  echo $thumbnail;
}

if (isset($_GET["height"]))
  resizeImage($_SERVER["DOCUMENT_ROOT"].$_GET["resizeThis"], $_GET["height"]);
else
  echo $_GET["url"];

}

function resizeThis($img, $height) {
  return "/php/resize.php?resizeThis=$img&height=$height";
}

?>