<?php
$filename = 'discussion.txt';
header('Content-Type: application/json');

// Add new discussion (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || empty($input['name']) || empty($input['question'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
        exit();
    }

    $entry = [
        'id' => uniqid(),
        'time' => date('Y-m-d H:i:s'),
        'name' => htmlspecialchars(trim($input['name'])),
        'question' => htmlspecialchars(trim($input['question']))
    ];

    file_put_contents($filename, json_encode($entry) . PHP_EOL, FILE_APPEND);
    echo json_encode(['success' => true]);
    exit();
}

// Edit existing discussion (PUT)
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || empty($input['id']) || empty($input['question'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
        exit();
    }

    if (!file_exists($filename)) {
        echo json_encode(['success' => false, 'error' => 'Discussion not found']);
        exit();
    }

    $updated = false;
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    $newLines = [];

    foreach ($lines as $line) {
        $entry = json_decode($line, true);
        if ($entry && $entry['id'] === $input['id']) {
            $entry['question'] = htmlspecialchars(trim($input['question']));
            $entry['time'] = date('Y-m-d H:i:s'); // update time
            $updated = true;
        }
        $newLines[] = json_encode($entry);
    }

    if ($updated) {
        file_put_contents($filename, implode(PHP_EOL, $newLines) . PHP_EOL);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'ID not found']);
    }
    exit();
}
