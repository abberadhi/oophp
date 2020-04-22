<?php

include "config.php";
include "autoload.php";

$message = "";
$secret = "";

// first time
if (!isset($_SESSION["game"])) {
    // set new game
    $a = new Guess();
    $_SESSION["game"] = serialize($a);
}
// unserialize game
$game = unserialize($_SESSION["game"]);

if (isset($_SESSION["won"])) {
    $message = "<b>CORRECT</b>!";
}

if (isset($_SESSION["cheat"])) {
    $secret = "CHEAT! number is <b>". $_SESSION["cheat"] . "</b><br>";
}



include 'view/index.php';
