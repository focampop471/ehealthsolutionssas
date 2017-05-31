<?php
$user = $_POST["user"];
$password = $_POST["password"];
echo json_encode('funciona ' . $user . " " . $password)
?>