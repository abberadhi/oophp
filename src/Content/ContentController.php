<?php

namespace Abbe\Content;

use Abbe\Content;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;
// use Anax\Route\Exception\InternalErrorException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 * @SuppressWarnings(PHPMD.StaticAccess)
 * @SuppressWarnings("PMD.CyclomaticComplexity")
 */
class ContentController implements AppInjectableInterface
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
    public function indexActionGet() : object
    {
        $title = "Testing Textfilter";

        $route = $this->app->request->getGet("route") ?? null;
        $id = $this->app->request->getGet("id") ?? null;
        $slug = $this->app->request->getGet("slug") ?? null;
        $path = $this->app->request->getGet("path") ?? null;
        $this->app->db->connect();
        
        if ($route == "edit") {
            $title = "Testing Textfilter";
            $id = $this->app->request->getGet("id") ?? null;
            if ($id) {
                return $this->editPage($id);
            }
        } else if ($route == "create") {
            $title = "Create";
            $this->app->page->add("content/create", []);
    
            return $this->app->page->render([
                "title" => $title,
            ]);
        } else if ($route == "blog") {
            // die($route);
            if (isset($slug)) {
                $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE 
    slug = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;
                $res = $this->app->db->executeFetchAll($sql, [$slug]);
                $title = $res[0]->title;
                $this->app->page->add("content/blogpost", [
                    "content"=> $res[0],
                ]);
        
                return $this->app->page->render([
                    "title" => $title,
                ]);
            }
            return $this->viewBlog("post");
        } else if ($route == "page") {
            if (isset($path)) {
                $sql = <<<EOD
SELECT
*,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
path = ?
AND (deleted IS NULL OR deleted > NOW())
AND published <= NOW()
;
EOD;
                $res = $this->app->db->executeFetchAll($sql, [$path]);
                $title = $res[0]->title;
                $this->app->page->add("content/page", [
                    "content"=> $res[0],
                ]);
        
                return $this->app->page->render([
                    "title" => $title,
                ]);
            }
            return $this->viewPage("page");
        }
        
        $sql = "SELECT * FROM content";
        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("content/index", [
            "resultset"=> $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function indexActionPost() : object // mom's spaghetti
    {
        $route = $this->app->request->getGet("route") ?? null;
        $doCreate = $this->app->request->getPost("doCreate") ?? null;
        $doSave = $this->app->request->getPost("doSave") ?? null;
        $doDelete = $this->app->request->getPost("doDelete") ?? null;
        $contentId = $this->app->request->getPost("contentId") ?? null;
        $contentTitle = $this->app->request->getPost("contentTitle") ?? null;
        $contentPath = $this->app->request->getPost("contentPath") ?? null;
        $contentSlug = $this->app->request->getPost("contentSlug") ?? null;
        $contentData = $this->app->request->getPost("contentData") ?? null;
        $contentType = $this->app->request->getPost("contentType") ?? null;
        $contentFilter = $this->app->request->getPost("contentFilter") ?? null;
        $contentPublish = $this->app->request->getPost("contentPublish") ?? null;


        $this->app->db->connect();
        if (isset($doCreate)) {
            $sql = "INSERT INTO content (title) VALUES (?);";
            $this->app->db->execute($sql, [$contentTitle]);
            $id = $this->app->db->lastInsertId();
            return $this->editPage($id);
        } else if (isset($doSave)) {
            if (!isset($contentSlug) || $contentPath != "") { // ok
                $contentSlug = \Abbe\Content\Slugify2::slugify($contentTitle);
            }

            // if slug already exists, add id
            $sql = "SELECT * FROM content WHERE slug = ? AND id <> ?;";
            $res = $this->app->db->executeFetchAll($sql, [$contentSlug, $contentId]);
            if (count($res) > 0) { // ok
                if ($contentType == "post") {
                    $contentSlug .= ("-" . strval($contentId));
                }
            }

            // if post, add blogpost-id, else make path with slugify
            if ($contentType == "post" && (!isset($contentPath) || $contentPath == "")) {
                $contentPath = "blogpost" . ("-" . strval($contentId));
            } else { // if page
                if (!isset($contentPath) || $contentPath == "") {
                    $contentPath = \Abbe\Content\Slugify2::slugify($contentTitle);
                } else {
                    $contentPath = \Abbe\Content\Slugify2::slugify($contentPath);
                }
            }

            // if path already exists, add id
            $sql = "SELECT * FROM content WHERE path = ? AND id <> ?;";
            $res = $this->app->db->executeFetchAll($sql, [$contentPath, $contentId]);
            if (count($res) > 0) {
                $contentPath .= ("-" . strval($contentId));
            }

            $sql = <<<EOD
UPDATE content 
SET 
    path = ?,
    slug = ?,
    title = ?,
    data = ?,
    type = ?,
    filter = ?,
    published = ?,
    updated = NOW()
WHERE
    id = ?
LIMIT 1;
EOD;
            $this->app->db->execute($sql, [
                $contentPath,
                $contentSlug,
                $contentTitle,
                $contentData,
                $contentType,
                $contentFilter,
                $contentPublish,
                $contentId
            ]);
            $id = $this->app->db->lastInsertId();
        } else if (isset($doDelete)) {
            $sql = <<<EOD
UPDATE content 
SET 
    deleted = NOW()
WHERE
    id = ?
LIMIT 1;
EOD;
            $this->app->db->execute($sql, [
                $contentId
            ]);
            $id = $this->app->db->lastInsertId();
        }
        
        return $this->app->response->redirect("content/");
    }

    public function editPage($id) : object
    {
        $title = "Edit id " . strval($id);
        $this->app->db->connect();
        $sql = "SELECT * FROM content WHERE id = ? LIMIT 1;";
        $res = $this->app->db->executeFetchAll($sql, [$id]);

        $this->app->page->add("content/edit", [
            "content"=> $res[0],
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    
    public function viewBlog($type) : object
    {
        $title = "blog";
        $this->app->db->connect();
        $sql = <<<EOD
SELECT
*,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
AND deleted IS NULL
ORDER BY published DESC
;
EOD;

        $res = $this->app->db->executeFetchAll($sql, [$type]);
        $this->app->page->add("content/blog", [
            "resultset"=> $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function viewPage($type) : object
    {
        $title = "blog";
        $this->app->db->connect();
        $sql = <<<EOD
SELECT
*,
CASE 
    WHEN (deleted <= NOW()) THEN "isDeleted"
    WHEN (published <= NOW()) THEN "isPublished"
    ELSE "notPublished"
END AS status
FROM content
WHERE type=?
AND deleted IS NULL
;
EOD;

        $res = $this->app->db->executeFetchAll($sql, [$type]);
        $this->app->page->add("content/pages", [
            "resultset"=> $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
