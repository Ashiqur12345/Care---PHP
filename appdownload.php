<?php
$file = 'smile.apk';
echo "here";

if (file_exists($file)) {

    echo "exists";
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}

<?php header("Location: smile.apk"); ?>
?>