<?php

namespace Abbe\Dice1002;

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
class Dice100Controller implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";

        // Use $this->app to access the framework services.
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : object
    {
        // Deal with the action and return a response.

        return $this->initActionGet();
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexActionPost() : object
    {
        // Deal with the action and return a response.

        return $this->initActionPost();
    }
    

    /**
     * This is the debug method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}";
    }


    /**
     * This is the init method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function initActionGet() : object
    {
        $title = "init Dice100 game";
        $this->app->page->add("dice1002/init");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the init method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function initActionPost() : object
    {
        // $name = $_POST['name'] ?? null;
        $request = $this->app->request;
        $name = $request->getPost('name') ?? null;
        $players = $request->getPost('players') ?? null;
        $dices = intval($request->getPost('dices')) ?? null;
    
        $newGame = new Game($players, $dices, $name);
    
        $this->app->session->set("dice100", serialize($newGame));
    
        return $this->app->response->redirect("dice1002/play");
    }

    /**
     * This is the init method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionGet() : object
    {
        $title = "Play Dice100 game";

        // $game = unserialize($_SESSION["dice100"]);
        $game = unserialize($this->app->session->get("dice100"));
    
        $data = [
            "game" => $game,
            "players" => $game->players,
            "histogram" =>  $game->histogram(),
            "serie" =>  $game->calculateOdds(0),
        ];
    
        $this->app->page->add("dice1002/play", $data);
        // $this->app->page->add("guess/debug");
    
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the init method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionPost() : object
    {
        // $game = unserialize($_SESSION["dice100"]);
        $request = $this->app->request;
        $game = unserialize($this->app->session->get("dice100"));

        $roll = $request->getPost('roll') ?? null;
        $end = $request->getPost('end') ?? null;
        $reset = intval($request->getPost('reset')) ?? null;

        
        if (isset($roll)) {
            $this->app->session->set("winner", $game->playerMove());
        } else if (isset($end)) {
            $this->app->session->set("winner", $game->botMove());
        } else if (isset($reset)) {
            $this->app->session->set("winner", null);
            $this->app->session->set("dice100", null);
            return $this->app->response->redirect("dice1002/init");
        }
    
        $this->app->session->set("dice100", serialize($game));
    
        return $this->app->response->redirect("dice1002/play");
    }
}
