<?php
session_start();
session_destroy();
require '../config/db.php';
header("Location: " . BASE_URL . "index.php");
exit;
?>
