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
<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="contentId" value="<?= htmlentities($content->id) ?>"/>

    <p>
        <label>Title:<br> 
        <input type="text" name="contentTitle" value="<?= htmlentities($content->title) ?>"/>
        </label>
    </p>

    <p>
        <label>Path:<br> 
        <input type="text" name="contentPath" value="<?= htmlentities($content->path) ?>"/>
    </p>

    <p>
        <label>Slug:<br> 
        <input type="text" name="contentSlug" placeholder="Auto-generated" value="<?= htmlentities($content->slug) ?>" disabled/>
    </p>

    <p>
        <label>Text:<br> 
        <textarea name="contentData"><?= htmlentities($content->data) ?></textarea>
     </p>

     <p>
         <label>Type:<br> 
         <input type="text" name="contentType" value="<?= htmlentities($content->type) ?>"/>
     </p>

     <p>
         <label>Filter:  (comma separated)<br> 
         <input type="text" name="contentFilter" value="<?= htmlentities($content->filter) ?>"/>
     </p>

     <p>
         <label>Publish:<br> 
         <input type="datetime" name="contentPublish" value="<?= htmlentities($content->published) ?>"/>
     </p>

    <p>
        <button type="submit" name="doSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
        <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
    </p>
    </fieldset>
</form>
</article>
