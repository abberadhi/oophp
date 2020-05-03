<?php

namespace Abbe\Dice1002;

use Anax\DI\DIMagic;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class Dice1002ControllerTest extends TestCase
{

    private $controller;
    private $app;
    
    protected function setUp() : void
    {
        global $di;
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->app = $di;
        $di->set("app", $this->app);

        $this->controller = new Dice100Controller();
        $this->controller->setApp($this->app);
        // $this->controller->initialize();
    }

    /**
     * check indexActon contains input, returns correct
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * check indexActon contains input, returns correct
     */
    public function testInitAction()
    {
        $res = $this->controller->initActionGet();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * check posts to init
     */
    public function testInitActionPost()
    {
        // echo var_dump($this->app);

        $this->app->request->setGlobals([
            "post" => [
                "name" => "abe",
                "players" => 2,
                "dices" => 3,
            ],
        ]);
        $res = $this->controller->initActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

        /**
     * check posts to init
     */
    public function testplayActionGet()
    {
        // echo var_dump($this->app);
        $res = $this->controller->playActionGet();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

        /**
     * check posts to init
     */
    public function testplayActionPostRoll()
    {
        // echo var_dump($this->app);

        $this->app->request->setGlobals([
            "post" => [
                "roll" => 1,
            ],
        ]);
        $res = $this->controller->playActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testplayActionPostEnd()
    {
        // echo var_dump($this->app);

        $this->app->request->setGlobals([
            "post" => [
                "end" => 1,
            ],
        ]);
        $res = $this->controller->playActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testplayActionPostReset()
    {
        // echo var_dump($this->app);

        $this->app->request->setGlobals([
            "post" => [
                "reset" => 1,
            ],
        ]);
        $res = $this->controller->playActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
}
