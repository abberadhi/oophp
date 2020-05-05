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

?><h1>Movies</h1>
<article <?= classList($classes) ?>>
<form method="post">
    <label>search 
    <input type="text" name="search">
    </label>
    <input type="submit" name="submitButton">
</form>

<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År</th>
        <th>Hantera</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= htmlentities($id) ?></td>
        <td><?= htmlentities($row->id) ?></td>
        <td><img class="thumb" src="<?= htmlspecialchars($row->image) ?>"></td>
        <td><?= htmlentities($row->title) ?></td>
        <td><?= htmlentities($row->year) ?></td>
        <td><a href="movie/edit?movieid=<?= $row->id ?>">Edit</a> | <a href="?delete&movieid=<?= $row->id ?>">Delete</a></td>
    </tr>
<?php endforeach; ?>
</table>
<a href="?add">Add</a>
</article>

