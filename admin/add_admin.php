<?php
// الاتصال بقاعدة البيانات
include 'db.php';
include 'session.php';
// التحقق من إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // الحصول على البيانات المدخلة
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // تشفير كلمة السر باستخدام SHA1
    $hashed_password = sha1($password);

    // استعلام لإضافة الأدمن إلى قاعدة البيانات
    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $hashed_password
    ]);

    // رسالة نجاح
    echo '<script>alert("تم إضافة الأدمن بنجاح!"); window.location.href="view_admins.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة أدمن جديد</title>
    <!-- ربط ملف CSS الخاص بـ Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4 w-100" style="max-width: 500px;">
            <h3 class="text-center mb-4 text-primary">إضافة أدمن جديد</h3>
        <!-- نموذج إضافة الأدمن -->
        <form method="POST" action="add_admin.php" style="text-align:right;">
            <div class="mb-3">
                <label for="username" class="form-label">اسم المستخدم</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">كلمة المرور</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <center><button type="submit" class="btn btn-success">إضافة الأدمن</button></center>
    <center><br><br><a href="dashboard.php" class="btn btn-primary btn-block">الرجوع الى الصفحة الرئيسية</a></center>
        </form>
        </div>
    </div>
    <!-- ربط مكتبة JavaScript الخاصة بـ Bootstrap -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
