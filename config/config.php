<?php

    try {
        $pdo = new PDO ('mysql:dbname=blog; host=localhost', 'root', '');
        $pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die($e->getMessage());
    } catch (Exception $e) {
        die($e->getMessage());
    }

?>