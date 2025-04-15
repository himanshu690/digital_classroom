<?php
$filename = 'discussion.txt';
header('Content-Type: application/json');

$discussions = [];

if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $entry = json_decode($line, true);
        if ($entry) {
            $discussions[] = $entry;
        }
    }
}

echo json_encode($discussions);

