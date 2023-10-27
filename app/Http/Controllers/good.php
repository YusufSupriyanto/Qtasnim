<?php

namespace App\Http\Controllers;

use App\Models\goods;
use Illuminate\Http\Request;

class good extends Controller
{
    public function index()
    {
        $goods = goods::all();
        return response()->json(['data' => $goods]);
    }
}
