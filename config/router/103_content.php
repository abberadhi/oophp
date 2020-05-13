<?php
/**
 * dice100 controller
 */
return [
    // Path where to mount the routes, is added to each route path.
    // "mount" => "sample",

    // All routes in order
    "routes" => [
        [
            "info" => "content.",
            "mount" => "content",
            "handler" => "\Abbe\Content\ContentController",
        ],
    ]
];
