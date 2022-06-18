<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Collective;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CollectiveTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CollectiveController extends Controller
{
    public function index()
    {
        $collectives = Collective::all();
        return $this->responseJson(201, 'Collectives Founds', [
            'collectives' => $collectives
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'type' => 'required',
            'bio' => 'required',
            'is_profit' => 'required',
            'description' => 'required',
            'website' => 'required',
            'twitter' => 'required',
            'tags' => 'required|array'
        ]);

        if ($validator->fails()) {
            return $this->responseJson(422, "", $validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'username' => Str::slug($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'avatar_url' => 'avatar.png'
        ]);

        $collective = Collective::create([
            'user_id' => $user->id,
            'bio' => $request->bio,
            'description' => $request->description,
            'website' => $request->website,
            'twitter' => $request->twitter
        ]);

        $tags = [];
        foreach ($request->tags as $tag) {
            array_push($tags, [
                'name' => $tag,
                'collective_id' => $collective->id
            ]);
        }

        $create = CollectiveTag::insert($tags);

        if (Auth::check()) {

            $collective->members->insert([
                'member_id' => Auth::user()->id,
                'role' => 'admin'
            ]);
        }

        return $this->responseJson(201, "collective created", $collective);
    }

    public function show(string $username)
    {
        $collective = User::with(['collective.members', 'collective.tags'])
            ->where('username', $username)
            ->first();

        if (!$collective) {
            return $this->responseJson(404, "Collective not found");
        }

        return $this->responseJson(200, 'Collective data found', [
            'collective' => $collective,
            'members' => $collective->members,
            'tags' => $collective->tags,
        ]);
    }

    public function update(Request $request, Collective $collective)
    {
        //
    }
    
    public function destroy(Collective $collective)
    {
        $collective->delete();
    }
}
