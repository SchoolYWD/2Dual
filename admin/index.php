<?php
// الاتصال بقاعدة البيانات
include 'db.php';

$error_message = ""; // لعرض رسائل الخطأ

// التحقق من وجود طلب POST لتسجيل الدخول
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // جلب البيانات المدخلة من المستخدم
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);

    // التحقق من أن الحقول غير فارغة
    if (!empty($username) && !empty($email) && !empty($password)) {
        // تشفير كلمة السر باستخدام SHA1
        $hashed_password = sha1($password);

        // استعلام للتحقق من صحة البيانات في قاعدة البيانات
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND email = :email AND password = :password");
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password]);
        $user = $stmt->fetch();

        // إذا تم العثور على المستخدم
        if ($user) {
            // بدء جلسة وتوجيه المستخدم إلى لوحة التحكم بعد تسجيل الدخول بنجاح
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: dashboard.php');
            exit();
        } else {
            // رسالة خطأ في حالة فشل تسجيل الدخول
            $error_message = "اسم المستخدم أو البريد الإلكتروني أو كلمة السر غير صحيحة.";
        }
    } else {
        $error_message = "يرجى ملء جميع الحقول.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <!-- ربط ملفات CSS الخاصة بـ Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center text-primary">تسجيل الدخول</h3>

                    <!-- عرض رسالة الخطأ إن وجدت -->
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger text-center mt-3">
                            <?= $error_message ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST"  class="mt-4">
                        <div class="mb-3">
                            <label for="username" class="form-label">اسم المستخدم</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="أدخل اسم المستخدم" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="أدخل البريد الإلكتروني" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة السر</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="أدخل كلمة السر" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ربط مكتبة JavaScript الخاصة بـ Bootstrap -->
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
