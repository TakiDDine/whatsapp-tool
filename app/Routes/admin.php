<?php

// make namespace short
use \App\Controllers\AuthController as auth;
use \App\Middleware\flashMiddleware as flash;
use \App\Middleware\OldInputMidddleware as old;
use \App\Middleware\logoutMiddleware as logout;

// security , disable direct access
defined('BASEPATH') or exit('No direct script access allowed');

$app->post('/login[/]', auth::class . ':login')->setName('login');
$app->get('/logout[/]', auth::class . ':logout')->setName('logout')->add(new logout($container));

$app->group('/', function ($container) use ($app) {

    $this->get('[/]', 'Data:adminIndex')->setName('admin.index')->add(new App\Middleware\adminMiddleware($container));

    $this->get('instance', 'Instance:index')->setName('admin.instance.connect');
    $this->get('instance/logout', 'Instance:logout')->setName('admin.instance.logout');
    $this->post('instance/check', 'Instance:isAuth')->setName('admin.instance.is-auth');
    $this->post('instance/check-init', 'Instance:isInitialized')->setName('admin.instance.is-init');

    // Numbers
    $this->get('numbers', 'Number:index')->setName('admin.numbers.index');
    $this->get('numbers/create', 'Number:create')->setName('admin.numbers.create');
    $this->post('numbers/store', 'Number:store')->setName('admin.numbers.store');
    $this->get('numbers/{id}/edit', 'Number:edit')->setName('admin.numbers.edit');
    $this->post('numbers/{id}/update', 'Number:update')->setName('admin.numbers.update');
    $this->post('numbers/{id}/delete', 'Number:delete')->setName('admin.numbers.delete');
    $this->post('numbers/upload', 'Number:upload')->setName('admin.numbers.upload');

    // Groups
    $this->get('groups', 'Group:index')->setName('admin.groups.index');
    $this->get('groups/create', 'Group:create')->setName('admin.groups.create');
    $this->post('groups/store', 'Group:store')->setName('admin.groups.store');
    $this->get('groups/{id}/edit', 'Group:edit')->setName('admin.groups.edit');
    $this->post('groups/{id}/update', 'Group:update')->setName('admin.groups.update');
    $this->post('groups/{id}/delete', 'Group:delete')->setName('admin.groups.delete');
    $this->get('groups/{id}/message', 'Group:message')->setName('admin.groups.message');
    $this->post('groups/{id}/message', 'Group:sendMessage')->setName('admin.groups.message');
})->add(new App\Middleware\authMiddleware($container));

//   Middlewares
$app->add(new flash($container));
$app->add(new old($container));
