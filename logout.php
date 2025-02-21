<?php
session_start();
session_destroy();
$file_name = isset($_GET['file_name'])? $_GET['file_name']: "index.php";
header("Location: $file_name");
exit();
?>
