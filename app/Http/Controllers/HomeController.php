<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\SitusSejarah;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function beranda()
    {
        $gallery = SitusSejarah::with('kategori', 'gambarVideo')->limit(3)->get();
        $events = Event::limit(2)->latest()->get();
        return view('home.index', compact('gallery', 'events'));
    }
}
