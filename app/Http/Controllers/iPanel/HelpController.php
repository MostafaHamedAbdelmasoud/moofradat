<?php

namespace App\Http\Controllers\iPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelpController extends Controller
{
    //
    public function index()
    {
        $title = "مساعدة";
        return view('ipanel.helps.index', compact(['title']));
    }
}
