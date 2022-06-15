<?php

namespace App\Controllers;

use App\Helpers\SimpleCSV;
use App\Helpers\SimpleXLSX;
use App\Models\Number;
use Slim\Http\UploadedFile;

defined('BASEPATH') or exit('No direct script access allowed');

class NumberController extends Controller
{
    const SUPPORTED_FILES = ['xlsx', 'csv'];

    private function cleanPhoneNumber($phone)
    {
        return trim(str_replace([" ", "-", "(", ")"], "", $phone));
    }

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
        $phone   = $this->cleanPhoneNumber($post['phone']);

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
        $phone   = $this->cleanPhoneNumber($post['phone']);

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

    public function upload($request, $response)
    {
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['file'];
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $route = $response->withRedirect($this->router->pathFor('admin.numbers.index'));

        if (!in_array($extension, self::SUPPORTED_FILES)) {
            return $route;
        }

        $filename = $this->moveUploadedFile(BASEPATH . '/public/uploads', $uploadedFile);

        $filepath = BASEPATH . '/public/uploads/' . $filename;

        if ($extension === self::SUPPORTED_FILES[0]) {
            $rows = SimpleXLSX::parse($filepath)->rows();
        } else {
            $rows = SimpleCSV::import($filename);
        }

        $numbers = [];

        foreach ($rows as $key => $row) {
            if ($key === 0) continue;

            $numbers[] = [
                'name' => $row[0],
                'phone_number' => $row[1],
            ];
        }

        Number::insert($numbers);

        $this->flashsuccess('تم إضافة الرقم بنجاح');

        // Delete the file
        unlink($filepath);

        return $route;
    }

    function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
