<?php
// الاتصال بقاعدة البيانات
include 'db.php';
include 'session.php';
// استعلام لجلب بيانات الأدمن
$sql = "SELECT * FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$admins = $stmt->fetchAll();
if (isset($_GET['delete_id'])) {
    $lesson_id = $_GET['delete_id'];

    // استعلام لحذف الدرس
    $delete_sql = "DELETE FROM users WHERE id = :id";
    $delete_stmt = $pdo->prepare($delete_sql);
    $delete_stmt->execute(['id' => $lesson_id]);

    // رسالة تأكيد بعد الحذف
    echo '<script>alert("تم حذف المدير بنجاح!"); window.location.href="view_admin.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الأدمن</title>
    <!-- ربط ملف CSS الخاص بـ Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light" style="text-align:center;">

<div class="container mt-5">
    <h2 class="text-center text-primary mb-4">عرض الأدمن</h2>
    <a href="add_admin.php" class="btn btn-success mb-4">إضافة أدمن جديد</a>

    <!-- جدول عرض الأدمن -->
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>اسم المستخدم</th>
                <th>البريد الإلكتروني</th>
                <th>تاريخ الإنشاء</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($admins): ?>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($admin['id']); ?></td>
                        <td><?php echo htmlspecialchars($admin['username']); ?></td>
                        <td><?php echo htmlspecialchars($admin['email']); ?></td>
                        <td><?php echo htmlspecialchars($admin['created_at']); ?></td>
                        <td>
                            <!-- زر حذف مع رابط حذف -->
                            <a href="view_admin.php?delete_id=<?php echo $admin['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا المدير')">حذف</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">لا يوجد أدمن في النظام</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<center><br><br><a href="dashboard.php" class="btn btn-primary btn-block">الرجوع الى الصفحة الرئيسية</a></center>

<!-- ربط مكتبة JavaScript الخاصة بـ Bootstrap -->
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
