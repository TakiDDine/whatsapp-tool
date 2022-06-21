<?php

namespace App\Controllers;

use App\Models\Group;
use App\Models\GroupNumber;
use App\Models\Number;

defined('BASEPATH') or exit('No direct script access allowed');

class InstanceController extends Controller
{
    public function index($request, $response)
    {
        $isAuth = isAuthenticated();
        $isInit = isInit();
        return $this->view->render($response, 'admin/instance/connect.twig', [
            'isAuth' => $isAuth,
            'isInit' => $isInit,
        ]);
    }

    public function logout($request, $response)
    {
        $data = logoutFomInstance();
        $route = $response->withRedirect($this->router->pathFor('admin.instance.connect'));
        return $route;
    }

    public function isAuth($request, $response)
    {
        return json_encode([
            'is_auth' => isAuthenticated()
        ]);
    }

    public function isInitialized($request, $response)
    {
        return json_encode([
            'is_init' => isInitialized()
        ]);
    }
}
