<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lugare;

class lugareController extends Controller
{
    public function lugare(lugare $lugare)
    {
        return view('lugare', compact('lugare'));
    }
}
