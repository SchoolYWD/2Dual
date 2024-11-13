<?php
// بدء الجلسة والتحقق من تسجيل الدخول
include 'session.php';
include 'db.php';

// جلب عدد الدروس
$lesson_count = $pdo->query("SELECT COUNT(*) FROM lessons")->fetchColumn();

// جلب عدد الأسئلة
$question_count = $pdo->query("SELECT COUNT(*) FROM questions")->fetchColumn();

// جلب عدد المواد
$subject_count = $pdo->query("SELECT COUNT(*) FROM subjects")->fetchColumn();

// جلب عدد الطلاب
$student_count = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
// جلب عدد الادمن
$admin_count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">لوحة التحكم</h2>

    <div class="row">
        

  

        <!-- Div لإضافة سؤال وعدد الأسئلة -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-header bg-success text-white">
                    إضافة سؤال جديد
                </div>
                <div class="card-body">
                    <h5 class="card-title">عدد الأسئلة</h5>
                    <p class="card-text display-4"><?php echo $question_count; ?></p>
                    <a href="add_question.php" class="btn btn-success">إضافة سؤال</a>
                    <a href="view_question.php" class="btn btn-secondary">عرض جميع الأسئلة</a>
                </div>
            </div>
        </div>

        <!-- Div لإضافة درس وعدد الدروس -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-header bg-primary text-white">
                    إضافة درس جديد
                </div>
                <div class="card-body">
                    <h5 class="card-title">عدد الدروس</h5>
                    <p class="card-text display-4"><?php echo $lesson_count; ?></p>
                    <a href="add_lesson.php" class="btn btn-primary">إضافة درس</a>
                    <a href="view_lesson.php" class="btn btn-secondary">عرض جميع الدروس</a>
                </div>
            </div>
        </div>
        
        <!-- Div لإضافة مادة جديدة وعدد المواد -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-header bg-warning text-white">
                    إضافة مادة جديدة
                </div>
                <div class="card-body">
                    <h5 class="card-title">عدد المواد</h5>
                    <p class="card-text display-4"><?php echo $subject_count; ?></p>
                    <a href="add_subject.php" class="btn btn-warning">إضافة مادة</a>
                    <a href="view_subject.php" class="btn btn-secondary">عرض جميع المواد</a>
                </div>
            </div>
        </div>
          <!-- Div لإضافة طالب وعدد الطلاب -->
    <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-header bg-danger text-white">
                    إضافة طالب جديد
                </div>
                <div class="card-body">
                    <h5 class="card-title">عدد الطلاب</h5>
                    <p class="card-text display-4"><?php echo $student_count; ?></p>
                    <a href="add_student.php" class="btn btn-danger">إضافة طالب</a>
                    <a href="view_student.php" class="btn btn-secondary">عرض جميع الطلاب</a>
                </div>
            </div>
        </div>  
          <!-- Div لإضافة ادمن وعدد المدراء -->
    <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-header bg-info text-white">
                    إضافة مدير جديد
                </div>
                <div class="card-body">
                    <h5 class="card-title">عدد الادمن</h5>
                    <p class="card-text display-4"><?php echo $admin_count; ?></p>
                    <a href="add_admin.php" class="btn btn-info">إضافة مدير</a>
                    <a href="view_admin.php" class="btn btn-secondary">عرض جميع الادمن</a>
                </div>
            </div>
        </div>


    </div>
</div>

<!-- روابط Bootstrap JavaScript -->
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
