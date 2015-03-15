<?php
session_start();
session_unset();
session_destroy();

header('Location: http://web.engr.oregonstate.edu/~kernsbi/finalProject/login.html');
?>