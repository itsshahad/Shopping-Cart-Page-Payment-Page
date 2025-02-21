<?php
session_start();
session_destroy(); // تدمير الجلسة
header("Location: index.php"); // إعادة توجيه المستخدم للصفحة الأولى بعد تسجيل الخروج
exit();
