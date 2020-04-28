<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * init the game, rediret to play the game.
 */
$app->router->get("dice100/init", function () use ($app) {
    $title = "init Dice100 game";
    // var_dump($a);s
    // return $app->response->redirect("guess/play");

    $app->page->add("dice100/init");
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

$app->router->post("dice100/init", function () use ($app) {
    $name = $_POST['name'] ?? null;
    $players = $_POST['players'] ?? null;
    $dices = intval($_POST['dices']) ?? null;

    $newGame = new Abbe\Dice100\Game($players, $dices, $name);

    $_SESSION["dice100"] = serialize($newGame);

    return $app->response->redirect("dice100/play");
});

$app->router->get("dice100/play", function () use ($app) {
    $title = "Play Dice100 game";

    $game = unserialize($_SESSION["dice100"]);

    $data = [
        "game" => $game,
        "players" => $game->players,
    ];

    $app->page->add("dice100/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

$app->router->post("dice100/play", function () use ($app) {
    $game = unserialize($_SESSION["dice100"]);

    $roll = $_POST["roll"] ?? null;
    $end = $_POST["end"] ?? null;
    $reset = $_POST["reset"] ?? null;
    
    if (isset($roll)) {
        $game->playerMove();
    } else if (isset($end)) {
        $game->botMove();
    } else if (isset($reset)) {
        $_SESSION["winner"] = null;
        session_destroy();
        return $app->response->redirect("dice100/init");
    }

    $_SESSION["dice100"] = serialize($game);

    return $app->response->redirect("dice100/play");
});
