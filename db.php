<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$variable = new PDO('mysql:host=localhost;dbname=bd_agriculture;charset=utf8','root','');
?>