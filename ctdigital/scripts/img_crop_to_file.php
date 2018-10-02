<?php

function guidv4() {
    if (function_exists('com_create_guid') === true)
        return trim(com_create_guid(), '{}');

    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function str_replace_first($from, $to, $subject) {
    $from = '/' . preg_quote($from, '/') . '/';
    return preg_replace($from, $to, $subject, 1);
}

$imgUrl = str_replace_first(".." . DIRECTORY_SEPARATOR, "", $_POST['imgUrl']);
// original sizes
$imgInitW = $_POST['imgInitW'];
$imgInitH = $_POST['imgInitH'];
// resized sizes
$imgW = $_POST['imgW'];
$imgH = $_POST['imgH'];
// offsets
$imgY1 = $_POST['imgY1'];
$imgX1 = $_POST['imgX1'];
// crop box
$cropW = $_POST['cropW'];
$cropH = $_POST['cropH'];
// rotation angle
$angle = $_POST['rotation'];

$jpeg_quality = 100;

$output_filename = ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "temp" . DIRECTORY_SEPARATOR . guidv4();

// uncomment line below to save the cropped image in the same location as the original image.
//$output_filename = dirname($imgUrl). "/croppedImg_".rand();

$what = getimagesize($imgUrl);

switch (strtolower($what['mime'])) {
    case 'image/png':
        $img_r = imagecreatefrompng($imgUrl);
        $source_image = imagecreatefrompng($imgUrl);
        $type = '.png';
        break;
    case 'image/jpeg':
        $img_r = imagecreatefromjpeg($imgUrl);
        $source_image = imagecreatefromjpeg($imgUrl);
        error_log("jpg");
        $type = '.jpg';
        break;
    case 'image/gif':
        $img_r = imagecreatefromgif($imgUrl);
        $source_image = imagecreatefromgif($imgUrl);
        $type = '.gif';
        break;
    default: die('image type not supported');
}


//Check write Access to Directory

if (!is_writable(dirname($output_filename))) {
    $response = Array(
        "status" => 'error',
        "message" => 'Can`t write cropped File'
    );
} else {

    // resize the original image to size of editor
    $resizedImage = imagecreatetruecolor($imgW, $imgH);
    imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
    // rotate the rezized image
    $rotated_image = imagerotate($resizedImage, -$angle, 0);
    // find new width & height of rotated image
    $rotated_width = imagesx($rotated_image);
    $rotated_height = imagesy($rotated_image);
    // diff between rotated & original sizes
    $dx = $rotated_width - $imgW;
    $dy = $rotated_height - $imgH;
    // crop rotated image to fit into original rezized rectangle
    $cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
    imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
    imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
    // crop image into selected area
    $final_image = imagecreatetruecolor($cropW, $cropH);
    imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
    imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
    // finally output png image
    //imagepng($final_image, $output_filename.$type, $png_quality);
    imagejpeg($final_image, $output_filename . $type, $jpeg_quality);
    unlink($imgUrl);
    $response = Array(
        "status" => 'success',
        "url" => "../" . $output_filename . $type
    );
}
print json_encode($response);
