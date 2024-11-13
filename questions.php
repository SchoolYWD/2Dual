<?php
// الاتصال بقاعدة البيانات
include 'admin/db.php';

// التحقق من وجود معرف المادة
if (!isset($_GET['subject_id'])) {
    die("المادة غير موجودة!");
}

$subject_id = $_GET['subject_id'];

// جلب الأسئلة المرتبطة بالمادة
$sql = "SELECT * FROM questions WHERE subject_id = :subject_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['subject_id' => $subject_id]);
$questions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثاني ثنوي (أ) - الاسئلة التجريبية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center text-primary mb-4">الأسئلة</h2>
    <div class="row">
        <?php if (count($questions) > 0): ?>
            <?php foreach ($questions as $question): ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($question['question_title']); ?></h5>
                            <p><strong>الإجابة الصحيحة:</strong> <?php echo htmlspecialchars($question['correct_answer']); ?></p>
                           
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-danger">لا توجد أسئلة مرتبطة بهذه المادة حالياً.</p>
        <?php endif; ?>
    </div>
</div>
<center><br><br><a href="index.php" class="btn btn-primary btn-block">الرجوع الى المواد</a></center><br><br>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
