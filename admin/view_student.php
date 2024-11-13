<?php
// الاتصال بقاعدة البيانات
include 'db.php';
include 'session.php';

// استعلام لجلب جميع الطلاب
$sql = "SELECT * FROM students";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll();
// التحقق إذا كان يوجد معرف الحذف في الرابط
if (isset($_GET['delete_id'])) {
    $student_id = $_GET['delete_id'];

    // استعلام لحذف الطالب
    $delete_sql = "DELETE FROM students WHERE id = :id";
    $delete_stmt = $pdo->prepare($delete_sql);
    $delete_stmt->execute(['id' => $student_id]);

    // رسالة تأكيد بعد الحذف
    echo '<script>alert("تم حذف الطالب بنجاح!"); window.location.href="view_student.php";</script>';
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الطلاب</title>
    <!-- ربط ملف CSS الخاص بـ Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- مركز الصفحة باستخدام Flexbox -->
    <div class="container mt-5">
        <h3 class="text-center text-primary mb-4">عرض الطلاب</h3>

        <!-- جدول عرض الطلاب -->
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الصف</th>
                    <th>تاريخ الإضافة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo $student['id']; ?></td>
                        <td><?php echo $student['name']; ?></td>
                        <td><?php echo $student['email']; ?></td>
                        <td><?php echo $student['class']; ?></td>
                        <td><?php echo $student['created_at']; ?></td>
                        <td>
                            <!-- زر حذف مع رابط حذف -->
                            <a href="view_student.php?delete_id=<?php echo $student['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا الطالب؟')">حذف</a>
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
