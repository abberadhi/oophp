<?php

namespace Abbe\Movie;

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
class MovieController implements AppInjectableInterface
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
        $title = "Movie database | oophp";
        $this->app->db->connect();

        $delete = $this->app->request->getGet("delete");
        $add = $this->app->request->getGet("add");

        if (isset($delete)) {
            $movieId = $this->app->request->getGet("movieid");
            $sql = "DELETE FROM movie WHERE id = ?;";
            $this->app->db->executeFetchAll($sql, [$movieId]);
        } else if (isset($add)) {
            $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
            $this->app->db->execute($sql, ["A title", 0000, "img/noimage.png"]);
        }
        
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);
    
        $this->app->page->add("movie/index", [
            "res" => $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function indexActionPost() : object
    {
        $title = "Movie database | oophp";

        $search = "%" . $this->app->request->getPost("search") . "%";

        $this->app->db->connect();
        $sql = <<<EOD
SELECT * FROM movie 
WHERE 
    title LIKE ? OR
    year LIKE ?;
EOD;
        $res = $this->app->db->executeFetchAll($sql, [
            $search, 
            $search
        ]);
    
        $this->app->page->add("movie/index", [
            "res" => $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function editActionGet() : object
    {
        $title = "Edit Movie database | oophp";
        
        $movieId = $this->app->request->getGet("movieid");
        
        $sql = "SELECT * FROM movie WHERE id = ? LIMIT 1;";
        $this->app->db->connect();
        $res = $this->app->db->executeFetchAll($sql, [$movieId]);
    
        $this->app->page->add("movie/movie-edit", [
            "movie" => $res[0],
            "res" => $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function editActionPost() : object
    {        
        $movieId = $this->app->request->getPost("movieId");
        $movieTitle = $this->app->request->getPost("movieTitle");
        $movieYear = $this->app->request->getPost("movieYear");
        $movieImage = $this->app->request->getPost("movieImage");
        $doSave = $this->app->request->getPost("doSave");
        
        if (isset($doSave)) {
            $sql = <<<EOD
UPDATE movie SET 
    title = ?,
    year = ?,
    image = ?
WHERE
    id = ?;
EOD;
        }

        $this->app->db->connect();
        $this->app->db->execute($sql, [
            $movieTitle, 
            $movieYear, 
            $movieImage, 
            $movieId
        ]);
    
        return $this->app->response->redirect("movie/");
    }
}
