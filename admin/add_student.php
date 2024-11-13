<?php
// بدء الجلسة والتحقق من تسجيل الدخول
include 'session.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // جلب البيانات من النموذج
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $class = htmlspecialchars($_POST['class']);
    $student_number = htmlspecialchars($_POST['student_number']);
    
    // استعلام الإدخال
    $sql = "INSERT INTO students (name, email, class, student_number, created_at) VALUES (:name, :email, :class, :student_number, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':class' => $class,
        ':student_number' => $student_number
    ]);

    // رسالة النجاح
    echo '<script>alert("تمت إضافة الطالب بنجاح!"); window.location.href="view_student.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة طالب جديد</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    


     <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4 w-100" style="max-width: 500px;">
            <h3 class="text-center mb-4 text-primary">إضافة طالب جديد</h3>
            
            <!-- فورم إضافة المادة -->
            <form method="POST" action="add_student.php">
                <div class="mb-3">
                    <label for="name" class="form-label" style="float: right;">اسم الطالب</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label" style="float: right;">البريد الالكتروني</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="class" class="form-label" style="float: right;">الصف</label>
                    <input type="text" class="form-control" id="class" name="class" value="الثاني ثنوي (أ)" required>
                </div>
                <div class="mb-3">
                    <label for="student_number" class="form-label" style="float: right;">رقم الدخول</label>
                    <input type="text" class="form-control" id="student_number" name="student_number" required>
                </div>

                <button type="submit" class="btn btn-warning w-100">إضافة الطالب</button>
            </form><center><br><br><a href="dashboard.php" class="btn btn-primary btn-block">الرجوع الى الصفحة الرئيسية</a></center>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
