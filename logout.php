<?php
    session_start();
    $_SESSION['loggedin'] = FALSE;
    session_destroy();
    header("Location:login.php", true, 302);