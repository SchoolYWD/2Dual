<?php
// الاتصال بقاعدة البيانات
include 'db.php';
include 'session.php';
// استعلام لجلب جميع الأسئلة مع تفاصيل المادة
$sql = "SELECT questions.id, questions.question_title, questions.question_type, questions.correct_answer, questions.subject_id, questions.created_at, subjects.subject_name 
        FROM questions 
        JOIN subjects ON questions.subject_id = subjects.id 
        ORDER BY questions.subject_id ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$questions = $stmt->fetchAll();

// التحقق إذا كان يوجد معرف الحذف في الرابط
if (isset($_GET['delete_id'])) {
    $question_id = $_GET['delete_id'];

    // استعلام لحذف السؤال
    $delete_sql = "DELETE FROM questions WHERE id = :id";
    $delete_stmt = $pdo->prepare($delete_sql);
    $delete_stmt->execute(['id' => $question_id]);

    // رسالة تأكيد بعد الحذف
    echo '<script>alert("تم حذف السؤال بنجاح!"); window.location.href="view_question.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الأسئلة</title>
    <!-- ربط ملف CSS الخاص بـ Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- مركز الصفحة باستخدام Flexbox -->
    <div class="container mt-5">
        <h3 class="text-center text-primary mb-4">عرض الأسئلة</h3>

        <!-- جدول عرض الأسئلة -->
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>وقت الإضافة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $question): ?>
                    <tr>
                        <td><?php echo $question['id']; ?></td>
                        <td><?php echo $question['created_at']; ?></td>
                        <td>
                            <!-- زر حذف مع رابط حذف -->
                            <a href="view_question.php?delete_id=<?php echo $question['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا السؤال؟')">حذف</a>

                            <!-- زر عرض التفاصيل -->
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#questionModal<?php echo $question['id']; ?>">عرض</button>
                        </td>
                    </tr>

                    <!-- Modal لعرض تفاصيل السؤال -->
                    <div class="modal fade" id="questionModal<?php echo $question['id']; ?>" tabindex="-1" aria-labelledby="questionModalLabel<?php echo $question['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="questionModalLabel<?php echo $question['id']; ?>"><?php echo $question['question_title']; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>نوع السؤال:</strong> <?php echo $question['question_type']; ?></p>
                                    <p><strong>الإجابة الصحيحة:</strong> <?php echo $question['correct_answer']; ?></p>
                                    <p><strong>اسم المادة:</strong> <?php echo $question['subject_name']; ?></p>
                                    <p><strong>وقت الإضافة:</strong> <?php echo $question['created_at']; ?></p>
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
    <center><br><br><a href="dashboard.php" class="btn btn-primary btn-block">الرجوع الى الصفحة الرئيسية</a></center>
    <!-- ربط مكتبة JavaScript الخاصة بـ Bootstrap -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
