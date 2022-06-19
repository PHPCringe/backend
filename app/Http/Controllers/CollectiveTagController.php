<?php

namespace App\Http\Controllers;

use App\Models\CollectiveTag;
use Illuminate\Http\Request;

class CollectiveTagController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $tags = CollectiveTag::where('name', 'LIKE', "%{$search}%")->get();

        return $this->responseJson(200, "Success get tags", $tags);
    }

    public function store(Request $request)
    {
        $name = $request->name;
        $collective_id = $request->collective_id;


        $tags = [];
        foreach ($name as $tag) {
            array_push($tags, [
                'name' => $tag,
                'collective_id' => $collective_id
            ]);
        }

        CollectiveTag::insert($tags);

        return $this->responseJson(201, "Success add tag", $tags);
    }
}
