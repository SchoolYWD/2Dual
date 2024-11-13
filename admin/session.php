<?php
// بدء الجلسة
session_start();

// التحقق من وجود جلسة للمستخدم
if (!isset($_SESSION['user_id'])) {
    // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول إذا لم يكن مسجل الدخول
    header("Location: index.php");
    exit();
}
?>
