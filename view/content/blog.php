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

?><h1>Blog</h1>
<article <?= classList($classes) ?>>
<?php foreach ($resultset as $row) : ?>
<section>
    <header>
        <h1><a href="?route=blog&slug=<?= htmlentities($row->slug) ?>"><?= htmlentities($row->title) ?></a></h1>
        <p><i>Published: <time datetime="<?= htmlentities($row->published_iso8601) ?>" pubdate><?= htmlentities($row->published) ?></time></i></p>
    </header>
    <?= $filter->parse(htmlentities($row->data), explode(",", $row->filter)) ?>
</section>
<?php endforeach; ?>
</article>
