<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));
/**
 * init the game, rediret to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // init session for gmae start
    $a = new Abbe\Guess\Guess();
    $_SESSION["game"] = serialize($a);
    return $app->response->redirect("guess/play");
});


/**
 * play
 */
$app->router->get("guess/play", function () use ($app) {

    $message = "";
    $secret = "";

    // first time
    if (!isset($_SESSION["game"])) {
        // set new game
        $a = new Abbe\Guess\Guess();
        $_SESSION["cheat"] = $game->number();
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


    $title = "Hello World as a page";
    $data = [
        "message" => $message,
        "secret" => $secret,
        "guess" => $game,
        "tries" => $game->tries(),
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * process
 */
$app->router->post("guess/play", function () use ($app) {

    $userGuess = $_POST["guess"];

    $game = unserialize($_SESSION["game"]);

    if (isset($_POST["cheat"])) {
        $_SESSION["cheat"] = $game->number();
        return $app->response->redirect("guess/play");
    }

    if (isset($_POST["reset"])) {
        echo "run";
        $_SESSION["game"] = null;
        $a = new Abbe\Guess\Guess();
        $_SESSION["cheat"] = $game->number();
        $_SESSION["game"] = serialize($a);
        session_destroy();
        return $app->response->redirect("guess/init");
    }

    try {
        $_SESSION["won"] = $game->makeGuess($userGuess);
    } catch (Abbe\Guess\GuessException $e) {
        $_SESSION["response"] = $e->getMessage();
    }

    $_SESSION["game"] = serialize($game);

    return $app->response->redirect("guess/play");
});
