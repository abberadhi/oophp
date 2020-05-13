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

?><h1>TextFilter tests</h1>
<article <?= classList($classes) ?>>
<h2>bbcode2html</h2>
<h3>pre</h3>
<?= $prebbcode2html ?>
<h3>post</h3>
<?= $postbbcode2html ?>

<h2>makeClickable</h2>
<h3>pre</h3>
<?= $premakeClickable ?>
<h3>post</h3>
<?= $postmakeClickable ?>

<h2>markdown</h2>
<h3>pre</h3>
<?= $premarkdown ?>
<h3>post</h3>
<?= $postmarkdown ?>

<h2>nl2br</h2>
<h3>pre</h3>
<?= $prenl2br ?>
<h3>post</h3>
<?= $postnl2br ?>
</article>

