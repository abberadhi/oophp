<?php
include "config.php";
include "autoload.php";

$userGuess = $_POST["guess"];

$game = unserialize($_SESSION["game"]);

var_dump($_SESSION["game"]);
echo '<br>';

if (isset($_POST["cheat"])) {
    $_SESSION["cheat"] = $game->number();
    header("Location: ./");
    return;
}

if (isset($_POST["reset"])) {
    echo "run";
    $_SESSION["game"] = null;
    $a = new Guess();
    $_SESSION["cheat"] = $game->number();
    $_SESSION["game"] = serialize($a);
    session_destroy();
    header("Location: ./");
    return;
}

try {
    $_SESSION["won"] = $game->makeGuess($userGuess);
} catch (GuessException $e) {
    $_SESSION["response"] = $e->getMessage();
}

$_SESSION["game"] = serialize($game);

header("Location: ./");
