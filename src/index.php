<?php
$videoDir = '/var/lib/motion';
$videos = glob("$videoDir/*.mp4");

// Get sort order and page from query params
$sortOrder = $_GET['sort'] ?? 'newest';
$page = max((int)($_GET['page'] ?? 1), 1);
$videosPerPage = 20;

// Sort videos
usort($videos, function ($a, $b) use ($sortOrder) {
    return $sortOrder === 'oldest'
        ? filemtime($a) - filemtime($b)
        : filemtime($b) - filemtime($a);
});

$totalVideos = count($videos);
$totalPages = ceil($totalVideos / $videosPerPage);
$videos = array_slice($videos, ($page - 1) * $videosPerPage, $videosPerPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motion Videos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function confirmDelete(filename) {
            if (confirm("Are you sure you want to delete " + filename + "?")) {
                window.location.href = "delete.php?file=" + encodeURIComponent(filename);
            }
        }
        function goToPage(page) {
            const params = new URLSearchParams(window.location.search);
            params.set('page', page);
            window.location.search = params.toString();
        }
    </script>
</head>
<body class="bg-gray-900 text-white p-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Live Stream</h1>
        <div class="w-full bg-black flex justify-center">
            <img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . ':8081/0/stream' ?>" class="w-full max-w-lg" alt="Live Stream">
        </div>

        <h2 class="text-xl font-bold mt-8 mb-4">Recorded Videos</h2>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <label class="text-white">Sort by:</label>
                <select onchange="window.location.href='?sort=' + this.value" class="bg-gray-800 text-white px-2 py-1 rounded">
                    <option value="newest" <?= $sortOrder === 'newest' ? 'selected' : '' ?>>Newest</option>
                    <option value="oldest" <?= $sortOrder === 'oldest' ? 'selected' : '' ?>>Oldest</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button <?= $page <= 1 ? 'disabled' : '' ?> onclick="goToPage(<?= $page - 1 ?>)" class="px-3 py-1 rounded bg-gray-700 hover:bg-gray-600 disabled:opacity-50">Prev</button>
                <select onchange="goToPage(this.value)" class="bg-gray-800 text-white px-2 py-1 rounded">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <option value="<?= $i ?>" <?= $i === $page ? 'selected' : '' ?>>Page <?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <button <?= $page >= $totalPages ? 'disabled' : '' ?> onclick="goToPage(<?= $page + 1 ?>)" class="px-3 py-1 rounded bg-gray-700 hover:bg-gray-600 disabled:opacity-50">Next</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($videos as $video): ?>
                <?php $filename = basename($video); ?>
                <div class="bg-gray-800 p-4 rounded-lg">
                    <video class="w-full rounded-lg mb-2" controls preload="none">
                        <source src="videos/<?= $filename ?>" type="video/mp4">
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
