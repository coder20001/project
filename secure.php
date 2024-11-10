<?php
session_start();
if (!isset($_SESSION['access'])){
    header("location: who are you.php");
}
?>