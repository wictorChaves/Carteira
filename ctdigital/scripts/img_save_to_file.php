<?php

$imagePath = ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "temp" . DIRECTORY_SEPARATOR;

$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
$temp = explode(".", $_FILES["img"]["name"]);
$extension = end($temp);

if (!is_writable($imagePath)) {
    $response = Array(
        "status" => 'error',
        "message" => 'Can`t upload File; no write Access '
    );
    print json_encode($response);
    return;
}

if (in_array($extension, $allowedExts)) {
    if ($_FILES["img"]["error"] > 0) {
        $response = array(
            "status" => 'error',
            "message" => 'ERROR Return Code: ' . $_FILES["img"]["error"],
        );
    } else {

        $filename = $_FILES["img"]["tmp_name"];
        list($width, $height) = getimagesize($filename);

        $caminhoArquivo = $imagePath . $_FILES["img"]["name"];
        $contador = 0;
        while (file_exists($caminhoArquivo)) {
            $caminhoArquivo = $imagePath . $contador . $_FILES["img"]["name"];
            $contador++;
        }

        $barras = array("\\", "/");
        $caminhoArquivo = str_replace($barras, DIRECTORY_SEPARATOR, $caminhoArquivo);

        move_uploaded_file($filename, $caminhoArquivo);

        $response = array(
            "status" => 'success',
            "url" => ".." . DIRECTORY_SEPARATOR . $caminhoArquivo,
            "width" => $width,
            "height" => $height
        );
    }
} else {
    $response = array(
        "status" => 'error',
        "message" => 'something went wrong, most likely file is to large for upload. check upload_max_filesize, post_max_size and memory_limit in you php.ini',
    );
}

print json_encode($response);
?>
