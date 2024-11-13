<?php
// الاتصال بقاعدة البيانات
include 'db.php';
include 'session.php';
// جلب المواد من جدول subjects
$subjects = $pdo->query("SELECT id, subject_name FROM subjects")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استلام البيانات من الفورم
    $question_title = $_POST['question_title'];
    $question_type = $_POST['question_type'];
    $correct_answer = $_POST['correct_answer'];
    $subject_id = $_POST['subject_id']; // معرف المادة المختارة

    // التحقق من المدخلات
    if (!empty($question_title) && !empty($question_type) && !empty($correct_answer) && !empty($subject_id)) {
        // إدخال السؤال مع معرف المادة إلى قاعدة البيانات
        $sql = "INSERT INTO questions (question_title, question_type, correct_answer, subject_id) 
                VALUES (:question_title, :question_type, :correct_answer, :subject_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'question_title' => $question_title,
            'question_type' => $question_type,
            'correct_answer' => $correct_answer,
            'subject_id' => $subject_id
        ]);

        echo '<div class="alert alert-success text-center" role="alert">تم إضافة السؤال بنجاح!</div>';
    } else {
        echo '<div class="alert alert-danger text-center" role="alert">الرجاء ملء جميع الحقول.</div>';
    }
}
?>


    <!DOCTYPE html>
    <html lang="ar">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>إضافة سؤال اختبار</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">

        <!-- مركز الصفحة باستخدام Flexbox -->
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">
                <h3 class="text-center mb-4 text-primary">إضافة سؤال اختبار</h3>
                
                <form method="POST" action="add_question.php">
                    <div class="mb-3">
                        <label for="question_title" class="form-label">عنوان السؤال</label>
                        <textarea class="form-control" id="question_title" name="question_title" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                    <label for="subject_id" class="form-label">المادة</label>
                    <select class="form-select" id="subject_id" name="subject_id" required>
                        <option value="">اختر المادة</option>
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?= $subject['id'] ?>"><?= $subject['subject_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                    
                    <div class="mb-3">
                        <label for="question_type" class="form-label">نوع السؤال</label>
                        <select class="form-select" id="question_type" name="question_type" required>
                            <option value="مقالي">مقالي</option>
                            <option value="علل">علل</option>
                            <option value="صح وغلط">صح وغلط</option>
                        </select>
                    </div>

                    <!-- قسم الاختيارات يظهر فقط في حالة "اختر الاجابة الصحيحة" -->
                    <div class="mb-3" id="options_section" style="display: none;">
                        <label for="options" class="form-label">الاختيارات (فصل بينهم بفواصل)</label>
                        <input type="text" class="form-control" id="options" name="options[]" placeholder="الاختيارات" />
                    </div>

                    <!-- قسم سؤال صح وغلط يظهر فقط عند اختيار صح وغلط -->
                    <div class="mb-3" id="true_false_section" style="display: none;">
                        <label for="correct_answer" class="form-label">الإجابة الصحيحة (صح أم غلط)</label>
                        <select class="form-select" id="correct_answer" name="correct_answer" required>
                            <option value="صح">صح</option>
                            <option value="غلط">غلط</option>
                        </select>
                    </div>

                    <!-- حقل الإجابة الصحيحة يظهر دائمًا عندما يكون السؤال من نوع "مقالي" أو "علل" -->
                    <div class="mb-3" id="correct_answer_section">
                        <label for="correct_answer_input" class="form-label">الإجابة الصحيحة</label>
                        <textarea class="form-control" id="correct_answer_input" name="correct_answer" rows="2" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-warning w-100">إضافة السؤال</button>
                </form><center><br><br><a href="dashboard.php" class="btn btn-primary btn-block">الرجوع الى الصفحة الرئيسية</a></center>
            </div>
        </div>

        <!-- ربط مكتبة JavaScript الخاصة بـ Bootstrap -->
        <script src="js/bootstrap.bundle.min.js"></script>
        <script>
            // عرض الحقل الخاص بالاختيارات في حال كان نوع السؤال "اختر الاجابة الصحيحة"
            // عرض الحقل الخاص بالإجابة "صح وغلط" إذا تم اختيار صح وغلط
            document.getElementById('question_type').addEventListener('change', function() {
                const type = this.value;
                if (type === 'اختر الاجابة الصحيحة') {
                    document.getElementById('options_section').style.display = 'block';
                    document.getElementById('true_false_section').style.display = 'none';
                    document.getElementById('correct_answer_section').style.display = 'none';
                } else if (type === 'صح وغلط') {
                    document.getElementById('options_section').style.display = 'none';
                    document.getElementById('true_false_section').style.display = 'block';
                    document.getElementById('correct_answer_section').style.display = 'none'; // إخفاء حقل الإجابة الصحيحة
                    document.getElementById('correct_answer_input').value = 'صح'; // تعبئة الإجابة الصحيحة تلقائيًا بالقيمة "صح"
                } else {
                    document.getElementById('options_section').style.display = 'none';
                    document.getElementById('true_false_section').style.display = 'none';
                    document.getElementById('correct_answer_section').style.display = 'block'; // إبقاء حقل الإجابة الصحيحة
                }
            });

            // التفاعل مع اختيار الإجابة الصحيحة
            document.getElementById('correct_answer').addEventListener('change', function() {
                const answer = this.value;
                if (answer === 'غلط') {
                    document.getElementById('correct_answer_section').style.display = 'block'; // إظهار حقل الإجابة الصحيحة عندما تكون الإجابة "غلط"
                } else {
                    document.getElementById('correct_answer_section').style.display = 'none'; // إخفاء حقل الإجابة الصحيحة عندما تكون الإجابة "صح"
                }
            });
        </script>
        
    </body>
    </html>
