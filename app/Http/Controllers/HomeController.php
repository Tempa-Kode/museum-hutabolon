<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
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

    public function gallery(Request $request)
    {
        $kategori = Kategori::all();

        $gallery = SitusSejarah::with('kategori', 'gambarVideo')
            ->when($request->kategori, function($query) use ($request) {
                $query->whereHas('kategori', function($q) use ($request) {
                    $q->where('nama_kategori', $request->kategori);
                });
            })
            ->when($request->search, function($query) use ($request) {
                $query->where('nama', 'like', '%'.$request->search.'%');
            })
            ->latest()
            ->cursorPaginate(15)
            ->withQueryString();
        return view('home.gallery', compact('gallery', 'kategori'));
    }
}
