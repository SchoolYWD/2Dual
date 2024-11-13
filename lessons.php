<?php
// الاتصال بقاعدة البيانات
include 'admin/db.php';

// التحقق من وجود معرف المادة
if (!isset($_GET['subject_id'])) {
    die("المادة غير موجودة!");
}


$subject_id = $_GET['subject_id'];

// جلب الدروس المرتبطة بالمادة
$sql = "SELECT * FROM lessons WHERE subject_id = :subject_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['subject_id' => $subject_id]);
$lessons = $stmt->fetchAll();

$subjects_id = $_GET['subject_id'];

// جلب الدروس المرتبطة بالمادة
$sql = "SELECT * FROM questions WHERE subject_id = :subject_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['subject_id' => $subjects_id]);
$questions = $stmt->fetchAll();


?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثاني ثنوي (أ) - الدروس</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        table {
            text-align: right; /* محاذاة النص إلى اليمين */
            direction: rtl;
        }
        .modal-content {
            text-align: right; /* محاذاة محتوى المودال إلى اليمين */
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center text-primary mb-4">الدروس</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>اسم الدرس</th>
                <th>الإجراء</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lessons as $lesson): ?>
                <tr>
                    <td><?php echo $lesson['lesson_title']; ?></td>
                    <td>
                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#lessonModal<?php echo $lesson['id']; ?>">
                            اقرأ الدرس
                        </button>
                    </td>
                </tr>

                <!-- مودال عرض محتويات الدرس -->
                <div class="modal fade" id="lessonModal<?php echo $lesson['id']; ?>" tabindex="-1" aria-labelledby="lessonModalLabel<?php echo $lesson['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="lessonModalLabel<?php echo $lesson['id']; ?>"><?php echo $lesson['lesson_title']; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><?php echo nl2br($lesson['lesson_content']); ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<center><br><br><a href="index.php" class="btn btn-primary btn-block">الرجوع الى المواد</a></center><br><br>
<?php foreach ($questions as $question): ?><?php endforeach; ?>
    <?php if (count($questions) > 0): ?>
    <center>
        <a href="questions.php?subject_id=<?php echo $question['subject_id']; ?>" 
           class="btn btn-primary btn-block">اسئلة اختبار تجريبية</a>
    </center>
    <br><br>
<?php else: ?>
    <p class="text-center text-danger">لا توجد أسئلة مرتبطة بهذه المادة حالياً.</p>
<?php endif; ?>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
