<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

if (!$res) {
    return;
}

// Prepare classes
$classes[] = "article";
if (isset($class)) {
    $classes[] = $class;
}

?><h1>Movies</h1>
<article <?= classList($classes) ?>>

<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="movieId" value="<?= htmlentities($movie->id) ?>"/>

    <p>
        <label>Title:<br> 
        <input type="text" name="movieTitle" value="<?= htmlentities($movie->title) ?>"/>
        </label>
    </p>

    <p>
        <label>Year:<br> 
        <input type="number" name="movieYear" value="<?= htmlentities($movie->year) ?>"/>
    </p>

    <p>
        <label>Image:<br> 
        <input type="text" name="movieImage" value="<?= htmlentities($movie->image) ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Save">
    </p>
    </fieldset>
</form>
</article>
