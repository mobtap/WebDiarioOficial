<?php
session_start();
            unset($_SESSION['id']);
            unset($_SESSION['usuario']);
            unset($_SESSION['nome']);
            unset($_SESSION['logado']);
            header("Location: index.php");
            exit;

?>