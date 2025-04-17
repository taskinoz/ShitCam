<?php
$videoDir = '/var/lib/motion';

if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filePath = "$videoDir/$file";

    if (file_exists($filePath)) {
        unlink($filePath);
        header("Location: index.php"); // Redirect back to the main page
        exit;
    }
}

http_response_code(404);
echo "File not found.";
