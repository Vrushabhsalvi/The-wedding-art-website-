<?php
session_start();
session_destroy();

// Redirect to home page (public side)
header("Location: ../index.html"); 
exit;