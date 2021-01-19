<?php
    require_once "../config/config.php";
    $statement = $pdo->prepare("DELETE FROM users WHERE id=".$_GET['id']);
    $statement->execute();
    header("location:userlist.php");
?>