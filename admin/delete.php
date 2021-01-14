<?php
    require_once "../config/config.php";
    $statement = $pdo->prepare("DELETE FROM posts WHERE id=".$_GET['id']);
    $statement->execute();
    header("location:index.php");
?>