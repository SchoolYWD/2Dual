<?php
// الاتصال بقاعدة البيانات
include 'db.php';
include 'session.php';
// التحقق من وجود المعرف `id` في الرابط
if (isset($_GET['id'])) {
    $lesson_id = $_GET['id'];

    // استعلام لجلب تفاصيل الدرس بناءً على المعرف
    $sql = "SELECT * FROM lessons WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $lesson_id]);
    $lesson = $stmt->fetch();

    // التحقق إذا كانت المادة موجودة
    if (!$lesson) {
        die('الدرس غير موجود');
    }

    // التعامل مع الفورم عند الإرسال
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // استلام القيم من الفورم
        $lesson_title = $_POST['lesson_title'];
        $lesson_content = $_POST['lesson_content'];
        $lesson_date = $_POST['lesson_date'];
        $lesson_time = $_POST['lesson_time'];
        $subject_id = $_POST['subject_id'];

        // التحقق من المدخلات
        if (!empty($lesson_title) && !empty($lesson_content) && !empty($lesson_date) && !empty($lesson_time) && !empty($subject_id)) {
            // استعلام لتحديث بيانات الدرس
            $update_sql = "UPDATE lessons SET lesson_title = :lesson_title, lesson_content = :lesson_content, lesson_date = :lesson_date, lesson_time = :lesson_time, subject_id = :subject_id WHERE id = :id";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute([
                'lesson_title' => $lesson_title,
                'lesson_content' => $lesson_content,
                'lesson_date' => $lesson_date,
                'lesson_time' => $lesson_time,
                'subject_id' => $subject_id,
                'id' => $lesson_id
            ]);

            // رسالة تأكيد بعد التعديل
            echo '<div class="alert alert-success text-center" role="alert">تم تعديل الدرس بنجاح!</div>';
        } else {
            // رسالة خطأ في حال كانت هناك قيم فارغة
            echo '<div class="alert alert-danger text-center" role="alert">جميع الحقول مطلوبة.</div>';
        }
    }
} else {
    die('لم يتم العثور على الدرس');
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الدرس</title>
    <!-- ربط ملف CSS الخاص بـ Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h3 class="text-center text-primary mb-4">تعديل الدرس</h3>

        <!-- نموذج تعديل الدرس -->
        <form method="POST" action="edit_lesson.php?id=<?php echo $lesson_id; ?>">
            <div class="mb-3">
                <label for="subject_id" class="form-label">اسم المادة</label>
                <select class="form-select" id="subject_id" name="subject_id" required>
                    <option value="">اختر المادة</option>
                    <?php
                    // جلب قائمة المواد
                    $subjects_sql = "SELECT * FROM subjects";
                    $subjects_stmt = $pdo->prepare($subjects_sql);
                    $subjects_stmt->execute();
                    $subjects = $subjects_stmt->fetchAll();
                    
                    foreach ($subjects as $subject) {
                        echo '<option value="' . $subject['id'] . '"';
                        if ($lesson['subject_id'] == $subject['id']) {
                            echo ' selected';
                        }
                        echo '>' . $subject['subject_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="lesson_title" class="form-label">عنوان الدرس</label>
                <input type="text" class="form-control" id="lesson_title" name="lesson_title" value="<?php echo $lesson['lesson_title']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="lesson_content" class="form-label">محتوى الدرس</label>
                <textarea class="form-control" id="lesson_content" name="lesson_content" rows="5" required><?php echo $lesson['lesson_content']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="lesson_date" class="form-label">تاريخ الدرس</label>
                <input type="date" class="form-control" id="lesson_date" name="lesson_date" value="<?php echo $lesson['lesson_date']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="lesson_time" class="form-label">وقت الدرس</label>
                <input type="time" class="form-control" id="lesson_time" name="lesson_time" value="<?php echo $lesson['lesson_time']; ?>" required>
            </div>

            <button type="submit" class="btn btn-warning w-100">تعديل الدرس</button>
        </form>
    </div>
    <center><br><br><a href="dashboard.php" class="btn btn-primary btn-block">الرجوع الى الصفحة الرئيسية</a></center><br></br>
    <!-- ربط مكتبة JavaScript الخاصة بـ Bootstrap -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
