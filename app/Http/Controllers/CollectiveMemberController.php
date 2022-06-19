<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CollectiveMember;
use Illuminate\Validation\Rules\Enum;
use App\Enums\OrganizationMemberTypes;
use App\Models\Collective;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class CollectiveMemberController extends Controller
{
    public function index(string $collectiveName)
    {
        $collectiveMembers = User::with(['collective.members'])
            ->where('username', $collectiveName)
            ->get()
            ->makeHidden(['collective']);

        return $this->responseJson(200, "Success", $collectiveMembers);
    }

    public function addMember(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'collective_id' => 'required',
            'user_id' => 'required',
            'role' => ['required', new Enum(OrganizationMemberTypes::class)],
        ]);

        if ($validation->fails()) {
            return $this->responseJson(422, 'Invalid data', $validation->errors());
        }

        $getCollectiveMembers = CollectiveMember::where('collective_id', $request->collective_id)->where('user_id', $request->user_id)->get();

        if ($getCollectiveMembers->count() > 0) {
            return $this->responseJson(422, 'User already exists in this collective');
        }

        $collectiveMember = CollectiveMember::create([
            'collective_id' => $request->collective_id,
            'user_id' => $request->user_id,
            'role' => $request->role,
        ]);

        return $this->responseJson(201, "succesfully added user to collective", $collectiveMember);
    }

    public function show(CollectiveMember $collectiveMember)
    {
        //
    }

    public function update(Request $request, CollectiveMember $collectiveMember)
    {
        //
    }

    public function removeMember(Request $request, CollectiveMember $collectiveMember)
    {
        // $collectiveMember = CollectiveMember::where('collective_id', $request->collective_id)->where('user_id', $request->user_id)->delete();
        $collectiveMember = CollectiveMember::find($request->route('member'));
        if ($collectiveMember == null) {
            return $this->responseJson(404, "Member not found");
        }
        $collectiveMember->delete();
        return $this->responseJson(200, "Success delete member", $collectiveMember);
    }
}
