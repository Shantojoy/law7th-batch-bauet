<?php
require_once __DIR__ . '/db_config.php';

$query = 'SELECT id, name, student_id, address, phone, email, quote, photo, created_at FROM students_bauet ORDER BY created_at DESC';
$result = $mysqli->query($query);
$students = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    $result->free();
} else {
    $error = $mysqli->error;
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>BAUET – Batch 7 Student Submissions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: #f4f9f7;
        }
        .table thead {
            background: var(--primary-green);
            color: #fff;
        }
        .table tbody tr:nth-of-type(even) {
            background: rgba(218, 243, 228, 0.5);
        }
        .table tbody tr:hover {
            background: rgba(47, 122, 89, 0.12);
        }
        .admin-wrapper {
            background: #ffffff;
            border-radius: 22px;
            padding: 2rem;
            box-shadow: 0 30px 60px -40px rgba(0, 0, 0, 0.2);
        }
        .admin-header {
            border-left: 6px solid var(--accent-gold);
            padding-left: 1rem;
            margin-bottom: 2rem;
        }
        .admin-table-wrapper {
            max-height: 70vh;
            overflow-y: auto;
            border-radius: 18px;
        }
        .admin-table-wrapper::-webkit-scrollbar {
            width: 8px;
        }
        .admin-table-wrapper::-webkit-scrollbar-thumb {
            background: rgba(47, 122, 89, 0.4);
            border-radius: 4px;
        }
        .table img {
            border-radius: 10px;
            max-width: 70px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="admin-wrapper">
            <div class="admin-header">
                <h1 class="bangla-text mb-0">ছাত্র-ছাত্রীদের জমাকৃত তথ্য</h1>
                <p class="text-muted mb-0">Department of Law and Justice – Batch 7</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger bangla-text">ডাটাবেস ত্রুটি: <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <?php if (empty($students)): ?>
                <div class="alert alert-info bangla-text">এখনও কোনো তথ্য জমা পড়েনি।</div>
            <?php else: ?>
                <div class="admin-table-wrapper">
                    <table class="table table-hover align-middle text-nowrap">
                        <thead>
                            <tr class="bangla-text">
                                <th scope="col">ID</th>
                                <th scope="col">নাম</th>
                                <th scope="col">আইডি</th>
                                <th scope="col">ঠিকানা</th>
                                <th scope="col">মোবাইল</th>
                                <th scope="col">ইমেইল</th>
                                <th scope="col">প্রিয় কথা</th>
                                <th scope="col">ছবি</th>
                                <th scope="col">তারিখ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td class="english-text fw-semibold"><?= (int) $student['id']; ?></td>
                                    <td class="bangla-text"><?= htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="bangla-text"><?= htmlspecialchars($student['student_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="bangla-text" style="white-space: normal;"><?= nl2br(htmlspecialchars($student['address'], ENT_QUOTES, 'UTF-8')); ?></td>
                                    <td class="english-text"><?= htmlspecialchars($student['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="english-text"><?= htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="bangla-text" style="white-space: normal;"><?= nl2br(htmlspecialchars($student['quote'], ENT_QUOTES, 'UTF-8')); ?></td>
                                    <td>
                                        <?php if (!empty($student['photo'])): ?>
                                            <img src="<?= htmlspecialchars('uploads/' . $student['photo'], ENT_QUOTES, 'UTF-8'); ?>" alt="Photo of <?= htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php endif; ?>
                                    </td>
                                    <td class="english-text"><?= htmlspecialchars(date('d M Y, h:i A', strtotime($student['created_at'])), ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
