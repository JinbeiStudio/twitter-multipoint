<?php
//Suppression de la session et redirection
session_start();
session_unset();
session_destroy();
header("Location: ../index.php");
