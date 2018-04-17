<?php

/**
 * @OAS\Info(
 *     description="Lumen API Demo",
 *     version="1.0.0",
 *     title="Lumen API Demo",
 *     termsOfService="http://swagger.io/terms/",
 *     @OAS\Contact(
 *         email="gabpearl@gmail.com"
 *     ),
 *     @OAS\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/**
     * @OAS\Post(
     *     path="/lumenapi2/public/login",
     *     tags={"Authen"},
     *     summary="Login",
     *     operationId="login",
     *     @OAS\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *	   @OAS\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email",
     *         required=true,
     *         explode=true,
     *         @OAS\Schema(
     *             type="string"
     *            
     *         )
     *     ),
     *	   @OAS\Parameter(
     *         name="password",
     *         in="query",
     *         description="Password",
     *         required=true,
     *         explode=true,
     *         @OAS\Schema(
     *             type="string"
     *            
     *         )
     *     ),
     *     
     * )
     */

$router->post('/login', 'UserController@login');

/**
     * @OAS\Post(
     *     path="/lumenapi2/public/logout",
     *     tags={"Authen"},
     *     summary="Logout",
     *     operationId="logout",
     *     @OAS\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *	   
     *     
     * )
     */
$router->post('/logout', 'UserController@logout');

/**
     * @OAS\Post(
     *     path="/lumenapi2/public/register",
     *     tags={"Authen"},
     *     summary="Register with email and password",
     *     operationId="register",
     *     @OAS\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *	   @OAS\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email",
     *         required=true,
     *         explode=true,
     *         @OAS\Schema(
     *             type="string"
     *            
     *         )
     *     ),
     *	   @OAS\Parameter(
     *         name="password",
     *         in="query",
     *         description="Password",
     *         required=true,
     *         explode=true,
     *         @OAS\Schema(
     *             type="string"
     *            
     *         )
     *     ),
     *     
     * )
     */
$router->post('/register', 'UserController@register');

/**
     * @OAS\Get(
     *     path="/lumenapi2/public/me",
     *     tags={"Authen"},
     *     summary="Get info",
     *     operationId="me",
     *     @OAS\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *	   @OAS\Parameter(
     *         name="api_token",
     *         in="header",
     *         description="API token - got after login OK",
     *         required=true,
     *         explode=true,
     *         @OAS\Schema(
     *             type="string"
     *            
     *         )
     *     ),
     *	   
     *     
     * )
     */
$router->get('/me', ['middleware' => 'auth', 'uses' =>  'UserController@me']);


