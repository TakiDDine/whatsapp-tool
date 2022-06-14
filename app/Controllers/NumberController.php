<?php

namespace App\Controllers;

use App\Models\Number;

defined('BASEPATH') or exit('No direct script access allowed');

class NumberController extends Controller
{
    public function index($request, $response)
    {
        $numbers = Number::all();
        return $this->view->render($response, 'admin/numbers/index.twig', [
            'numbers' => $numbers,
        ]);
    }

    public function create($request, $response)
    {
        return $this->view->render($response, 'admin/numbers/create.twig');
    }

    public function store($request, $response)
    {
        $post   = $request->getParams();
        $route = $response->withRedirect($this->router->pathFor('admin.numbers.index'));

        $name   = $post['name'];
        $phone   = trim($post['phone']);

        Number::create(['name' => $name, 'phone_number' => $phone]);

        $this->flashsuccess('تم إضافة الرقم بنجاح');

        return $route;
    }

    public function edit($request, $response, $args)
    {
        $id = rtrim($args['id'], '/');

        $number = Number::findOrFail($id);

        return $this->view->render($response, 'admin/numbers/edit.twig', ['number' => $number]);
    }

    public function update($request, $response, $args)
    {
        $id = rtrim($args['id'], '/');
        $post   = $request->getParams();
        $route = $response->withRedirect($this->router->pathFor('admin.numbers.index'));

        $name   = $post['name'];
        $phone   = trim($post['phone']);

        $number = Number::findOrFail($id);

        $number->update(['name' => $name, 'phone_number' => $phone]);
        $this->flashsuccess('تم تعديل الرقم بنجاح');

        return $route;
    }

    public function delete($request, $response, $args)
    {
        $id = rtrim($args['id'], '/');
        $route = $response->withRedirect($this->router->pathFor('admin.numbers.index'));

        $number = Number::findOrFail($id);
        $number->delete();

        $this->flashsuccess('تم حذف الرقم بنجاح');

        return $route;
    }
}
