<?php
// الاتصال بقاعدة البيانات
include 'db.php';
include 'session.php';
// التعامل مع الفورم عند الإرسال
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = $_POST['subject_id'];
    $lesson_title = $_POST['lesson_title'];
    $lesson_content = $_POST['lesson_content'];
    $lesson_date = $_POST['lesson_date'];
    $lesson_time = $_POST['lesson_time'];

    // التحقق من المدخلات
    if (!empty($subject_id) && !empty($lesson_title) && !empty($lesson_content) && !empty($lesson_date) && !empty($lesson_time)) {
        // إدخال الدرس إلى قاعدة البيانات
        $sql = "INSERT INTO lessons (subject_id, lesson_title, lesson_content, lesson_date, lesson_time) 
                VALUES (:subject_id, :lesson_title, :lesson_content, :lesson_date, :lesson_time)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'subject_id' => $subject_id,
            'lesson_title' => $lesson_title,
            'lesson_content' => $lesson_content,
            'lesson_date' => $lesson_date,
            'lesson_time' => $lesson_time
        ]);

        // رسالة تأكيد عند إضافة الدرس بنجاح
        echo '<div class="mt-5 mb-5 container alert alert-success text-center" role="alert">تم إضافة الدرس بنجاح!</div>';
    } else {
        // رسالة خطأ في حالة المدخلات الفارغة
        echo '<div class="mt-5 mb-5 container alert alert-danger text-center" role="alert">الرجاء ملء جميع الحقول.</div>';
    }
}

// استعلام لجلب المواد
$sql = "SELECT * FROM subjects";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$subjects = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة درس جديد</title>
    <!-- ربط ملف CSS الخاص بـ Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- مركز الصفحة باستخدام Flexbox -->
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%;">
            <h3 class="text-center mb-4 text-primary">إضافة درس جديد</h3>

            <!-- فورم إضافة الدرس -->
            <form method="POST" action="add_lesson.php">
                <div class="mb-3">
                    <label for="subject_id" class="form-label">اسم المادة</label>
                    <select class="form-select" id="subject_id" name="subject_id" required>
                        <option value="">اختر المادة</option>
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?php echo $subject['id']; ?>"><?php echo $subject['subject_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="lesson_title" class="form-label">عنوان الدرس</label>
                    <input type="text" class="form-control" id="lesson_title" name="lesson_title" required>
                </div>
                <div class="mb-3">
                    <label for="lesson_content" class="form-label">محتوى الدرس</label>
                    <textarea class="form-control" id="lesson_content" name="lesson_content" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="lesson_date" class="form-label">تاريخ الدرس</label>
                    <input type="date" class="form-control" id="lesson_date" name="lesson_date" required>
                </div>
                <div class="mb-3">
                    <label for="lesson_time" class="form-label">وقت الدرس</label>
                    <input type="time" class="form-control" id="lesson_time" name="lesson_time" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">إضافة الدرس</button>
            </form><center><br><br><a href="dashboard.php" class="btn btn-primary btn-block">الرجوع الى الصفحة الرئيسية</a></center>
        </div>
    </div>
    
    <!-- ربط مكتبة JavaScript الخاصة بـ Bootstrap -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
