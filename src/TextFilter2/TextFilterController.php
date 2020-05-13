<?php

namespace Abbe\TextFilter2;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class TextFilterController implements AppInjectableInterface
{
    use AppInjectableTrait;

    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";

        // Use $this->app to access the framework services.
    }

    public function indexActionGet() : object
    {
        $title = "Testing Textfilter";
        $textFilter = new \Abbe\TextFilter2\MyTextFilter();

        $prebbcode2html = '[U]Underline[/U]
        [i]Italic[/i]
        [b]Bold[/b]

        [img]https://dbwebb.se/img/black_ball.svg[/img]
        [url]https://google.se[/url]
        [url=https://google.se]Google[/url]
        ';

        $premakeClickable = 'https://abbe.dev';    
        
        $premarkdown = <<<EOD
####h4

* one
* two
* tree
EOD;

        $prenl2br = "One \n Two \n three";



        $this->app->page->add("textfilter/index", [
            "prebbcode2html" => $prebbcode2html,
            "postbbcode2html" => $textFilter->parse($prebbcode2html, ["bbcode"]),
            "premakeClickable" => $premakeClickable,
            "postmakeClickable" => $textFilter->parse($premakeClickable, ["link"]),
            "premarkdown" => $premarkdown,
            "postmarkdown" => $textFilter->parse($premarkdown, ["markdown"]),
            "prenl2br" => $prenl2br,
            "postnl2br" => $textFilter->parse($prenl2br, ["nl2br"]),
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
