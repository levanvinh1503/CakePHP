<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...Router::scope('/', function (RouteBuilder $routes) {
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/register', ['controller' => 'Users', 'action' => 'register']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
});

Router::scope('/users', function ($routes) {
    $routes->connect('/dash-board', ['controller' => 'Users', 'action' => 'dashBoard']);
    $routes->connect('/list-category', ['controller' => 'Users', 'action' => 'listCategory'], ['id' => '\d+']);

    $routes->connect('/list-post', ['controller' => 'Users', 'action' => 'listPost'], ['id' => '\d+']);

    $routes->connect('/add-post', ['controller' => 'Users', 'action' => 'addPost'], ['name' => 'addpost']);

    $routes->connect('/edit-post/:id', ['controller' => 'Users', 'action' => 'editPost'], ['id' => '\d+', 'pass' => ['id']]);
    $routes->connect('/edit-category/:id', ['controller' => 'Users', 'action' => 'editCategory'], ['id' => '\d+', 'pass' => ['id']]);
    $routes->connect('/add-category', ['controller' => 'Users', 'action' => 'addCategory']);
    $routes->connect('/add-post', ['controller' => 'Users', 'action' => 'addPost']);
    $routes->connect('/delete-category', ['controller' => 'Users', 'action' => 'deleteCategory']);
    $routes->connect('/delete-post', ['controller' => 'Users', 'action' => 'deletePost']);
    $routes->connect('/list-user', ['controller' => 'Users', 'action' => 'listUser'], ['id' => '\d+']);
    $routes->connect('/export', ['controller' => 'Users', 'action' => 'exportFile']);
    $routes->connect('/send-data', ['controller' => 'Users', 'action' => 'saveData']);
});
