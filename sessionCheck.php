<?php
session_start();
// we need a BOOLEAN VARIABLE that tells us IF the user has ALREADY logged in OR NOT !
// BUT DOES THE $_SESSION["UserLogged"] ALREADY EXIST OR NOT !?
if (!isset($_SESSION["UserLogged"])) {
    $_SESSION["UserLogged"] = false;
}

?>
