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

?><h1>Content</h1>
<article <?= classList($classes) ?>>
<a href="?route=create">Create new</a> |
<a href="?route=page">View pages</a> |
<a href="?route=blog">View blog</a>
<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Path</th>
        <th>Slug</th>
        <th>Type</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <th>Actions</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= htmlentities($row->id) ?></td>
        <td><?= htmlentities($row->title) ?></td>
        <td><?= htmlentities($row->path) ?></td>
        <td><?= htmlentities($row->slug) ?></td>
        <td><?= htmlentities($row->type) ?></td>
        <td><?= htmlentities($row->published) ?></td>
        <td><?= htmlentities($row->created) ?></td>
        <td><?= htmlentities($row->updated) ?></td>
        <td><?= htmlentities($row->deleted) ?></td>
        <td>
        <a href="?route=edit&amp;id=<?= htmlentities($row->id) ?>" title="Edit this content">Edit</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
</article>
