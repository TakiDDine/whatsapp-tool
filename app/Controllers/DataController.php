<?php

namespace App\Controllers;

defined('BASEPATH') or exit('No direct script access allowed');

class DataController extends Controller
{
    public function adminIndex($request, $response)
    {
        return $response->withRedirect($this->router->pathFor('admin.numbers.index'));
    }
}
