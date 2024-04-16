<?php
if (!isset($_SESSION)) {
    session_start();
};

session_destroy();
header('Location: /u4-w13-d3/login.php');
