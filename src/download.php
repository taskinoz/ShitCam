<?php
$videoDir = '/var/lib/motion';

if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filePath = "$videoDir/$file";

    if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
}

http_response_code(404);
echo "File not found.";
