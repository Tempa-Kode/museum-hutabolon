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

    public function event(Request $request)
    {
        $data = Event::latest()
            ->when($request->search, function($query) use ($request) {
                $query->where('nama_event', 'like', '%'.$request->search.'%');
            })
            ->cursorPaginate(10)
            ->withQueryString();
        return view('home.event', compact('data'));
    }

    public function detailGallery(SitusSejarah $situsSejarah)
    {
        $data = $situsSejarah->load('kategori', 'gambarVideo', 'komentar');
        $this->tambahTotalPencarian($situsSejarah);
        return view('home.detail-gallery', compact('data'));
    }

    /**
     * Menambah total pencarian untuk situs sejarah tertentu.
     */
    public function tambahTotalPencarian(SitusSejarah $situsSejarah)
    {
        $totalPencarianExists = $situsSejarah->totalPencarian;
        if (!$totalPencarianExists) {
            $situsSejarah->totalPencarian()->create(['jlh_pencarian' => 1]);
        } else {
            $situsSejarah->totalPencarian()->increment('jlh_pencarian');
        }
    }

    public function favorit()
    {
        return view('home.favorit');
    }
}
