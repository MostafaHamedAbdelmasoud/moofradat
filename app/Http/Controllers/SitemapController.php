<?php

namespace App\Http\Controllers;

use App\Discharges;
use App\Medical;
use App\Shortcut;
use App\Slang;
use App\Word;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    //
    public function index()
    {
        $words = Word::orderBy('updated_at', 'desc')->first();
        $discharges = Discharges::orderBy('updated_at', 'desc')->first();
        $medical = Medical::orderBy('updated_at', 'desc')->first();
        $shortcuts = Shortcut::orderBy('updated_at', 'desc')->first();
        $slang = Slang::orderBy('updated_at', 'desc')->first();

        return response()->view('sitemap.index', [
            'words' => $words,
            'discharges' => $discharges,
            'medical' => $medical,
            'shortcuts' => $shortcuts,
            'slang' => $slang
        ])->header('Content-Type', 'text/xml');
    }
}
