<?php
$host = 'localhost'; // عادة سيكون localhost
$dbname = 'study_schedule'; // اسم قاعدة البيانات التي أنشأناها
$username = 'root'; // اسم المستخدم (عادة ما يكون root)
$password = ''; // كلمة المرور (غالباً تكون فارغة في البيئة المحلية)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
