<?php
$videoDir = '/var/lib/motion';
$videos = glob("$videoDir/*.mp4");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motion Videos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Live Stream</h1>
        <div class="w-full bg-black flex justify-center">
            <img src="http://localhost:8081/0/stream" class="w-full max-w-lg" alt="Live Stream">
        </div>

        <h2 class="text-xl font-bold mt-8 mb-4">Recorded Videos</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($videos as $video): ?>
                <?php $filename = basename($video); ?>
                <div class="bg-gray-800 p-4 rounded-lg">
                    <video class="w-full rounded-lg mb-2" controls>
                        <source src="videos/<?= $filename ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <a href="download.php?file=<?= urlencode($filename) ?>" class="block text-center bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Download</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
