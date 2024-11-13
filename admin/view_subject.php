<?php
// الاتصال بقاعدة البيانات
include 'db.php';
include 'session.php';


// استعلام لجلب جميع المواد
$sql = "SELECT * FROM subjects";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$subjects = $stmt->fetchAll();
// التحقق إذا كان يوجد معرف الحذف في الرابط
if (isset($_GET['delete_id'])) {
    $question_id = $_GET['delete_id'];

    // استعلام لحذف السؤال
    $delete_sql = "DELETE FROM subjects WHERE id = :id";
    $delete_stmt = $pdo->prepare($delete_sql);
    $delete_stmt->execute(['id' => $question_id]);

    // رسالة تأكيد بعد الحذف
    echo '<script>alert("تم حذف السؤال بنجاح!"); window.location.href="view_subject.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المواد</title>
    <!-- ربط ملف CSS الخاص بـ Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h3 class="text-center text-primary mb-4">عرض المواد</h3>

        <!-- جدول عرض المواد -->
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <th>المعرف</th>
                    <th>اسم المادة</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subjects as $subject): ?>
                    <tr>
                        <td><?php echo $subject['id']; ?></td>
                        <td><?php echo $subject['subject_name']; ?></td>
                        <td>
                            <!-- زر حذف مع رابط حذف -->
                            <a href="view_subject.php?delete_id=<?php echo $subject['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا السؤال؟')">حذف</a>

                            </td>
                    </tr>
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
                    