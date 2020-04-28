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
<form method="post">
    <label>Your name:<br>
        <input type="text" name="name" placeholder="Player">
    </label>
    <br>
    <br>
    <label>Total players:<span style="color:red;">*</span>
        <input min="2" style="width: 3em" type="number" name="players" >
    </label>
    <label>Dices:<span style="color:red;">*</span>
        <input min="1" style="width: 3em" type="number" name="dices" >
    </label>
    <br>
    <br>
    <input type="submit" value="Start">
</form>
</article>
</html>
