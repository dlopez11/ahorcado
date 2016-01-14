<?php
    session_start();

    
    if(isset($_SESSION['username'])) {
        session_destroy();
        $_SESSION['good'] = "Sesión finalizada!";
    }

    header("Location: session.php");
?>  