<?php
// الاتصال بقاعدة البيانات
include 'db.php';
include 'session.php';
// استعلام لجلب جميع الدروس
$sql = "SELECT lessons.id, lessons.lesson_title, lessons.lesson_date, lessons.lesson_time, lessons.lesson_content, subjects.subject_name 
        FROM lessons 
        JOIN subjects ON lessons.subject_id = subjects.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$lessons = $stmt->fetchAll();

// التحقق إذا كان يوجد معرف الحذف في الرابط
if (isset($_GET['delete_id'])) {
    $lesson_id = $_GET['delete_id'];

    // استعلام لحذف الدرس
    $delete_sql = "DELETE FROM lessons WHERE id = :id";
    $delete_stmt = $pdo->prepare($delete_sql);
    $delete_stmt->execute(['id' => $lesson_id]);

    // رسالة تأكيد بعد الحذف
    echo '<script>alert("تم حذف الدرس بنجاح!"); window.location.href="view_lesson.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الدروس</title>
    <!-- ربط ملف CSS الخاص بـ Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- مركز الصفحة باستخدام Flexbox -->
    <div class="container mt-5">
        <h3 class="text-center text-primary mb-4">عرض الدروس</h3>

        <!-- جدول عرض الدروس -->
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المادة</th>
                    <th>عنوان الدرس</th>
                    <th>تاريخ الدرس</th>
                    <th>وقت الدرس</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessons as $lesson): ?>
                    <tr>
                        <td><?php echo $lesson['id']; ?></td>
                        <td><?php echo $lesson['subject_name']; ?></td>
                        <td><?php echo $lesson['lesson_title']; ?></td>
                        <td><?php echo $lesson['lesson_date']; ?></td>
                        <td><?php echo $lesson['lesson_time']; ?></td>
                        <td>
                            <!-- زر تعديل -->
                            <a href="edit_lesson.php?id=<?php echo $lesson['id']; ?>" class="btn btn-warning btn-sm">تعديل</a>
                            
                            <!-- زر حذف مع رابط حذف -->
                            <a href="view_lesson.php?delete_id=<?php echo $lesson['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا الدرس؟')">حذف</a>

                            <!-- زر عرض المحتوى -->
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#lessonModal<?php echo $lesson['id']; ?>">عرض المحتوى</button>
                        </td>
                    </tr>

                    <!-- Modal لعرض محتوى الدرس -->
                    <div style="text-align: right;" class="modal fade" id="lessonModal<?php echo $lesson['id']; ?>" tabindex="-1" aria-labelledby="lessonModalLabel<?php echo $lesson['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="lessonModalLabel<?php echo $lesson['id']; ?>"><?php echo $lesson['lesson_title']; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <strong>: المحتوى</strong>
                                    <p><?php echo nl2br($lesson['lesson_content']); ?></p> <!-- عرض المحتوى مع الحفاظ على الفواصل الجديدة -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                </div>
                            </div>
                                    </div>
                            </div>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<center><br><br><a href="dashboard.php" class="btn btn-primary btn-block">الرجوع الى الصفحة الرئيسية</a></center><br><br>
    <!-- ربط مكتبة JavaScript الخاصة بـ Bootstrap -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
