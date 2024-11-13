<?php
// الاتصال بقاعدة البيانات
include 'admin/db.php';

// جلب المواد من قاعدة البيانات
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
    <title>ثاني ثنوي (أ) - المواد الدراسية</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center text-primary mb-4">المواد الدراسية</h2>
    <div class="row">
        <?php foreach ($subjects as $subject): ?>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $subject['subject_name']; ?></h5>
                        <a href="lessons.php?subject_id=<?php echo $subject['id']; ?>" class="btn btn-primary btn-block">عرض الدروس</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
