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

?>
<style>
.playfield {
    width: 100%;
    text-align: center;
}
.playfield > div {
    width: calc(100% / 4);  
    display: inline-block;
    vertical-align: top;   
    border: 1px solid rgb(200, 0, 0);
    text-align: center;
    margin: 2%;    
    padding: 20px;
}
.playfield .player {
    border: 1px solid rgb(255, 0, 0); 
}
.playfield .increase {
    background-color: #baff91; 
}
.playfield .decrease {
    background-color: #ff8066; 
}


</style>
<h1>Play Dice100</h1>
<article <?= classList($classes) ?>>
    
    <form method="POST">
    <?php if (isset($_SESSION["winner"])) : ?>
    <h2><?= $_SESSION["winner"] ?> won the game!</h2>
    <?php else : ?>
    <div class="playfield">
        <?php foreach ($players as $person) : ?>
        <div class="player <?php 
            echo $person->human ? "human " : ""; 
            echo in_array(1, $person->getDices()) ? "decrease" : "increase"; 
        ?>">
        <p><?php echo $person->name; ?></p> 
        <p>Total points: <?php echo $person->getTotalPoints(); ?></p>
            <?php if ($person->human) : ?>
        <p><b>current points: <?php echo $person->getCurrentPoints(); ?></b></p>
            <?php endif; ?>
            <p><?php echo "Last roll - <br>[" . implode(", ", $person->getDices()) . "]"; ?></p>
        </div>
        <?php endforeach; ?>
        <?php //var_dump($game);?>
    </div>
    <hr>
        <?php if (!in_array(1, $players[0]->getDices())) : ?>
    <input type="submit" name="roll" value="Roll">
        <?php endif; ?>
        <?php if (!$players[0]->getCurrentPoints() == 0 || in_array(1, $players[0]->getDices())) : ?>
    <input type="submit" name="end" value="End">
        <?php endif; ?>
    <?php endif; ?>
    <input type="submit" name="reset" value="Reset">
    </form>
    <?= $histogram ?>
</article>
</html>