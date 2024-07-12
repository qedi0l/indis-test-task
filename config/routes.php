<?php

use App\Controller\AuthorController;
use App\Controller\BookController;
use App\Controller\ProductController;
use App\Controller\PublisherController;
use App\Controller\UserController;
use App\Entity\Product;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    /*$routes->add('user/add', '/user/add')
        ->controller([UserController::class, 'add']);

    $routes->add('delete.user', '/user/delete/{id}')
        ->controller([UserController::class, 'delete']);

    $routes->add('user/add', '/user/add')
        ->controller([UserController::class, 'add']);

    $routes->add('user/addproduct', '/user/addproduct/{id}/{id_prod}')
        ->controller([UserController::class, 'addProd']);

    $routes->add('delete.user', '/user/delete/{id}')
        ->controller([UserController::class, 'delete']);

    $routes->add('product/add', '/product/add')
        ->controller([ProductController::class, 'add']);
        */

    $routes->add('book.create', '/book/create/{book_json}')
        ->controller([BookController::class, 'create']);
    
    $routes->add('book.all', '/book/all')
        ->controller([BookController::class, 'getAll']);

    $routes->add('book.delete', '/book/delete/{id}')
        ->controller([BookController::class, 'delete']);

    $routes->add('author.create', '/author/create/{author_json}')
        ->controller([AuthorController::class, 'create']);

    $routes->add('author.delete', '/author/delete/{id}')
        ->controller([AuthorController::class, 'delete']);
        
    $routes->add('publisher.create', '/publisher/create/{publisher_json}')
        ->controller([PublisherController::class, 'create']);

    $routes->add('publisher.update', '/publisher/update/{publisher_json}')
        ->controller([PublisherController::class, 'update']);

    $routes->add('publisher.delete', '/publisher/delete/{id}')
        ->controller([PublisherController::class, 'delete']);

};
