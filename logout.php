<?php
session_start();

    session_unset();    
    session_destroy();
    header('Location: /site/restaurant-bar-a-soupe/index.php');
    die();
?>