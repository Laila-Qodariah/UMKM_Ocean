<?php
session_start();

header("Content-type: image/png");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$width  = 150;
$height = 50;

$image = imagecreate($width, $height);

$bg        = imagecolorallocate($image, 235, 247, 255);
$textColor = imagecolorallocate($image, 7, 72, 117);
$lineColor = imagecolorallocate($image, 104, 165, 207);
$dotColor  = imagecolorallocate($image, 0, 119, 182);

$characters = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
$captcha = '';

for ($i = 0; $i < 4; $i++) {
    $captcha .= $characters[random_int(0, strlen($characters) - 1)];
}

$_SESSION['captcha'] = $captcha;

for ($i = 0; $i < 6; $i++) {
    imageline(
        $image,
        random_int(0, $width),
        random_int(0, $height),
        random_int(0, $width),
        random_int(0, $height),
        $lineColor
    );
}

for ($i = 0; $i < 120; $i++) {
    imagesetpixel($image, random_int(0, $width - 1), random_int(0, $height - 1), $dotColor);
}

imagestring($image, 5, 38, 18, $captcha, $textColor);

imagepng($image);
imagedestroy($image);
?>