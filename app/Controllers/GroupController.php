<?php

namespace App\Controllers;

use App\Models\Group;
use App\Models\GroupNumber;
use App\Models\Number;

defined('BASEPATH') or exit('No direct script access allowed');

class GroupController extends Controller
{
    public function index($request, $response)
    {
        $groups = Group::withcount('groupNumbers')->orderBy('id', 'desc')->get();

        return $this->view->render($response, 'admin/groups/index.twig', [
            'groups' => $groups,
        ]);
    }

    public function create($request, $response)
    {
        $numbers = Number::all();

        return $this->view->render($response, 'admin/groups/create.twig', [
            'numbers' => $numbers,
        ]);
    }

    public function store($request, $response)
    {
        $post   = $request->getParams();
        $route = $response->withRedirect($this->router->pathFor('admin.groups.index'));

        $name   = $post['name'];

        $group = Group::create(['name' => $name]);

        $filteredPhones = [];
        $groupNumbers = [];

        foreach ($post['phones'] as $phone) {
            if (!in_array($phone, $filteredPhones)) {
                $filteredPhones[] = $phone;
            }
        }

        foreach ($filteredPhones as $phone) {
            $groupNumbers[] = [
                'number_id' => $phone,
                'group_id' => $group->id,
            ];
        }

        GroupNumber::insert($groupNumbers);

        $this->flashsuccess('تم إضافة المجموعة بنجاح');

        return $route;
    }

    public function edit($request, $response, $args)
    {
        $id = rtrim($args['id'], '/');

        $group = Group::with('groupNumbers', 'groupNumbers.phone')->findOrFail($id);
        $numbers = Number::all();

        return $this->view->render($response, 'admin/groups/edit.twig', ['numbers' => $numbers, 'group' => $group]);
    }

    public function update($request, $response, $args)
    {
        // Get the group
        $group = Group::findOrFail($args['id']);

        $post   = $request->getParams();
        $route = $response->withRedirect($this->router->pathFor('admin.groups.index'));

        $name   = $post['name'];
        $group->update([
            'name' => $name
        ]);

        $filteredPhones = [];
        $groupNumbers = [];

        foreach ($post['phones'] as $phone) {
            if (!in_array($phone, $filteredPhones)) {
                $filteredPhones[] = $phone;
            }
        }

        foreach ($filteredPhones as $phone) {
            $groupNumbers[] = [
                'number_id' => $phone,
                'group_id' => $group->id,
            ];
        }

        $group->groupNumbers()->delete();

        GroupNumber::insert($groupNumbers);

        $this->flashsuccess('تم تعديل المجموعة بنجاح');

        return $route;
    }

    public function delete($request, $response, $args)
    {
        $id = rtrim($args['id'], '/');
        $route = $response->withRedirect($this->router->pathFor('admin.groups.index'));

        $group = Group::findOrFail($id);
        $group->delete();

        $this->flashsuccess('تم حذف المجموعة بنجاح');

        return $route;
    }

    public function message($request, $response, $args)
    {
        $group = Group::findOrFail($args['id']);
        return $this->view->render($response, 'admin/groups/message.twig', ['group' => $group]);
    }

    public function sendMessage($request, $response, $args)
    {
        // Get params
        $post   = $request->getParams();
        $message = $post['message'];

        // Get the group
        $group = Group::with('groupNumbers', 'groupNumbers.phone')->findOrFail($args['id']);

        $ultramsg_token = "gz09ablfo1mrl5yi"; // Ultramsg.com token
        $instance_id = "instance9214"; // Ultramsg.com instance id
        $client = new \UltraMsg\WhatsAppApi($ultramsg_token, $instance_id);

        $group->groupNumbers->map(function ($group) use ($client, $message) {
            $client->sendChatMessage($group->phone->phone_number, $message);
        });

        $this->flashsuccess('تم إرسال الرلسالة إلى المجموعة بنجاح');

        $route = $response->withRedirect($this->router->pathFor('admin.groups.message', ['id' => $args['id']]));

        return $route;
    }
}
