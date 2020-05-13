<?php

namespace Anax\View;

use Abbe\TextFilter2;

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

// prepare filter
$filter = new \Abbe\TextFilter2\MyTextFilter();

?>
<article <?= classList($classes) ?>>
    <header>
        <h1><?= htmlentities($content->title) ?></h1>
        <p><i>Published: <time datetime="<?= htmlentities($content->published_iso8601) ?>" pubdate><?= htmlentities($content->published) ?></time></i></p>
    </header>
    <?= $filter->parse(htmlentities($content->data), explode(",", $content->filter)) ?>
</article>
