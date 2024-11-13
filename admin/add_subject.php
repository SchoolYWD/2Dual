<?php
// الاتصال بقاعدة البيانات
include 'db.php';
include 'session.php';
// التعامل مع الفورم عند الإرسال
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_name = $_POST['subject_name'];

    // التحقق من المدخلات
    if (!empty($subject_name)) {
        // إدخال المادة إلى قاعدة البيانات
        $sql = "INSERT INTO subjects (subject_name) VALUES (:subject_name)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['subject_name' => $subject_name]);

        echo '<script>alert("تم اضافة المادة بنجاح")</script>';
    } else {
        echo '<script>alert("اكتب اسم المادة هنالك خطاء")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة مادة جديدة</title>
    <!-- ربط ملف CSS الخاص بـ Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- مركز الصفحة باستخدام Flexbox -->
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4 w-100" style="max-width: 500px;">
            <h3 class="text-center mb-4 text-primary">إضافة مادة جديدة</h3>
            
            <!-- فورم إضافة المادة -->
            <form method="POST" action="add_subject.php">
                <div class="mb-3">
                    <label for="subject_name" class="form-label" style="float: right;">اسم المادة</label>
                    <input type="text" class="form-control" id="subject_name" name="subject_name" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">إضافة المادة</button>
            </form><center><br><br><a href="dashboard.php" class="btn btn-primary btn-block">الرجوع الى الصفحة الرئيسية</a></center>
        </div>
    </div>
    
    <!-- ربط مكتبة JavaScript الخاصة بـ Bootstrap -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
