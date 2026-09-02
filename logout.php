<?php
session_start();

// Session ke tamam variables ko clear aur destroy karein
session_unset();
session_destroy();

// User ko direct Home Page (index.php) par bhejein
header("Location: index.php");
exit();
?>
