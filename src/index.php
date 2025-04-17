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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        let video = entry.target;
                        let source = video.querySelector("source");
                        source.src = source.dataset.src;
                        video.load();
                        observer.unobserve(video);
                    }
                });
            }, { threshold: 0.5 });
            
            document.querySelectorAll("video").forEach(video => {
                observer.observe(video);
            });
        });
        
        function confirmDelete(filename) {
            if (confirm("Are you sure you want to delete " + filename + "?")) {
                window.location.href = "delete.php?file=" + encodeURIComponent(filename);
            }
        }
    </script>
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
                        <source data-src="videos/<?= $filename ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="flex justify-between">
                        <a href="download.php?file=<?= urlencode($filename) ?>" class="text-center bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Download</a>
                        <button onclick="confirmDelete('<?= $filename ?>')" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">Delete</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
