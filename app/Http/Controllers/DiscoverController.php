<?php

namespace App\Http\Controllers;

use App\Models\Collective;
use App\Models\User;
use Illuminate\Http\Request;

class DiscoverController extends Controller
{
    public function discover(Request $request)
    {
        $sortBy = $request->query('sortBy') ?? "created_at"; // oldest created | recently created | name [a-z] 
        $sort = $request->query('sort') ?? "asc";
        $search = $request->query('search') ?? "";

        // $collectives = Collective::where('name', 'LIKE', "%{$search}%")
        //     ->orderBy($sortBy, $sort)
        //     ->paginate();

        $collectives = User::with(['collective', 'collective.tags'])
            ->where('type', '!=', 'personal')
            ->where('name', 'LIKE', '%' . $search . '%')
            ->orderBy($sortBy, $sort)
            ->paginate();

        return $this->responseJson(200, "Success", $collectives);
    }
}
