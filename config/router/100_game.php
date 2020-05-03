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
            "info" => "Dice100 controller.",
            "mount" => "dice1002",
            "handler" => "\Abbe\Dice1002\Dice100Controller",
        ],
    ]
];
