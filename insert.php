<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$fields = [
    'name' => trim($_POST['name'] ?? ''),
    'student_id' => trim($_POST['student_id'] ?? ''),
    'address' => trim($_POST['address'] ?? ''),
    'phone' => trim($_POST['phone'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'quote' => trim($_POST['quote'] ?? ''),
];

foreach ($fields as $key => $value) {
    if ($value === '') {
        echo json_encode(['success' => false, 'message' => 'সমস্ত ঘর পূরণ করুন।']);
        exit;
    }
}

$banglaFields = ['name', 'student_id', 'address', 'quote'];
foreach ($banglaFields as $field) {
    if (preg_match('/[A-Za-z]/', $fields[$field])) {
        echo json_encode(['success' => false, 'message' => 'বাংলা ঘরে ইংরেজি বর্ণ ব্যবহার করা যাবে না।']);
        exit;
    }
}

if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'সঠিক ইমেইল প্রদান করুন।']);
    exit;
}

if (!preg_match('/^01[0-9]{9}$/', $fields['phone'])) {
    echo json_encode(['success' => false, 'message' => 'মোবাইল নম্বর অবশ্যই ০১ দিয়ে শুরু হয়ে ১১ ডিজিট হতে হবে।']);
    exit;
}

if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'একটি বৈধ ছবি আপলোড করুন।']);
    exit;
}

$allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
$fileTmp = $_FILES['photo']['tmp_name'];
$fileName = $_FILES['photo']['name'];
$fileSize = $_FILES['photo']['size'];
$fileType = mime_content_type($fileTmp);

if (!in_array($fileType, $allowedMime, true)) {
    echo json_encode(['success' => false, 'message' => 'শুধুমাত্র JPEG, PNG অথবা WEBP ফাইল গ্রহণযোগ্য।']);
    exit;
}

if ($fileSize > 2 * 1024 * 1024) {
    echo json_encode(['success' => false, 'message' => 'ছবির আকার ২ এমবি-র কম হতে হবে।']);
    exit;
}

$uploadsDir = __DIR__ . '/uploads/';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

$extension = pathinfo($fileName, PATHINFO_EXTENSION) ?: 'jpg';
$storedName = uniqid('student_', true) . '.' . strtolower($extension);
$storedPath = $uploadsDir . $storedName;

if (!move_uploaded_file($fileTmp, $storedPath)) {
    echo json_encode(['success' => false, 'message' => 'ছবি সংরক্ষণ করা সম্ভব হয়নি।']);
    exit;
}

$stmt = $mysqli->prepare('INSERT INTO students_bauet (name, student_id, address, phone, email, quote, photo) VALUES (?, ?, ?, ?, ?, ?, ?)');

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'ডাটাবেস ত্রুটি: ' . $mysqli->error]);
    exit;
}

$stmt->bind_param(
    'sssssss',
    $fields['name'],
    $fields['student_id'],
    $fields['address'],
    $fields['phone'],
    $fields['email'],
    $fields['quote'],
    $storedName
);

if (!$stmt->execute()) {
    @unlink($storedPath);
    echo json_encode(['success' => false, 'message' => 'তথ্য সংরক্ষণ করতে ব্যর্থ।']);
    exit;
}

$stmt->close();

$responseData = $fields;
$responseData['photo'] = 'uploads/' . $storedName;
$responseData['created_at'] = date('Y-m-d H:i:s');

echo json_encode([
    'success' => true,
    'message' => 'তথ্য সফলভাবে জমা হয়েছে! ধন্যবাদ।',
    'data' => $responseData,
]);
