<?php
use Zeero\facades\Request;

/**
 * 
 * DEFINE THE ACTION OF THE NOT FOUND AND UNAUTHORIZED ROUTES
 * 
 */


$router = new Zeero\Core\Router\Router;


// NOT FOUND ACTION
$router->NotFoundAction(function () {

    if (Request::isAjax()) {
        json_response(['message' => 'REQUEST NOT FOUND'], 404);
    } else {
        errorPage('Opps | NOT FOUND', 'Not Found', 404);
    }
});




/**
 * set an action for not unauthorized errors
 * 
 * 1 - Invalid Token
 * 
 * 2 - Require User Logged
 * 
 * 3 - Require Admin Logged
 * 
 * 4 - Require User Level
 * **/

$router->UnauthorizedAction(function ($id) {

    if (Request::isAjax()) {
        json_response([ 'message' => 'REQUEST UNAUTHORIZED'], 401);
    } else {
        errorPage('Opps | Unauthorized', 'Unauthorized', 401);
    }
});
