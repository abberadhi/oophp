<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
$classes[] = "article";
if (isset($class)) {
    $classes[] = $class;
}

?><h1>Guess my number</h1>
<article <?= classList($classes) ?>>
<p>Guess a number between 1 and 100, you have <?= $tries ?> left.</p>

<form action="" method="post">
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
</html>

</article>
