<!DOCTYPE html>
<html>
    <head>
        <title>Guess the number</title>
    </head>
    <body>
        <h1>Guess my number</h1>
        <p>Guess a number between 1 and 100, you have <?= $game->tries() ?> left.</p>
        
        <form action="./process.php" method="post">
            <input type="number" name="guess">
            <input value="Make a guess" name="guessSubmit" type="submit">
            <input value="Start over" name="reset" type="submit">
            <input value="Cheat" name="cheat" type="submit">
        </form>
        <?php
        echo $secret;
        echo $message;
        $_SESSION["won"] = null;
        $message = "";

        if (isset($_SESSION["response"])) {
            echo $_SESSION["response"];
            $_SESSION["response"] = null;
        }
        ?>
    </body>
</html>
