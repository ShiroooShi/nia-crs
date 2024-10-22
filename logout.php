<?php
session_start();
session_unset(); // I-clear ang session variables
session_destroy(); // I-destroy ang session
header('Location: login.php'); // Balik sa login page
exit;
