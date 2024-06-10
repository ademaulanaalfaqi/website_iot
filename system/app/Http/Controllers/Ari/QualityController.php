<?php

namespace App\Http\Controllers\Ari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QualityController extends Controller
{
    public function quality()
    {
        return view('admin.ari.index');
    }
}
