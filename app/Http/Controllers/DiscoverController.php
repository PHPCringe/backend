<?php

namespace App\Http\Controllers;

use App\Models\Collective;
use Illuminate\Http\Request;

class DiscoverController extends Controller
{
    public function discover(Request $request)
    {
        $sortBy = $request->sortBy || "created_at"; // oldest created | recently created | name [a-z] 
        $sort = $request->sort || "asc";
        $search = $request->search || "";

        $collectives = Collective::where('name', 'LIKE', "%{$search}%")
            ->orderBy($sortBy, $sort)
            ->get();

        return $this->responseJson(200, "Success", $collectives);
    }
}
