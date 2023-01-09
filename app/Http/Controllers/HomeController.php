<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $batch = null;
        if ($request->batch_id) {
            $batch = Bus::findBatch($request->batch_id);
        }

        return view('dashboard', compact('batch'));
    }
}
