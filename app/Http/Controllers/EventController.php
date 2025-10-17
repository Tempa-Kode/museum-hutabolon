<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Menampilkan seluruh daftar event dari yang terbaru.
     */
    public function index()
    {
        $events = Event::latest()->get();
        return view('event.index', compact('events'));
    }

    /**
     * menampilkan form untuk membuat event baru.
     */
    public function create()
    {
        return view('event.create');
    }

    /**
     * Menyimpan event baru ke dalam database.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama_event' => 'required|string|max:100',
            'tanggal_event' => 'required|date',
            'waktu_event' => 'required|date_format:H:i',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'deskripsi_event' => 'required',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('poster')) {
                $file = $request->file('poster');
                $namaFile = time() . '_' . $file->getClientOriginalName();

                $tujuan = public_path('thumbnails/event');
                if (!file_exists($tujuan)) {
                    mkdir($tujuan, 0755, true);
                }

                $file->move($tujuan, $namaFile);

                $validasi['thumbnail'] = 'thumbnails/event/' . $namaFile;

                Event::create($validasi);
                DB::commit();
                return redirect()->route('event.index')->with('success', 'Event berhasil ditambahkan.');
            } else {
                return redirect()->back()->with('error', 'Poster event tidak ditemukan.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan event: ' . $e->getMessage());
        }
    }

    /**
     * menampilkan form untuk mengedit event yang sudah ada.
     */
    public function edit(Event $event)
    {
        return view('event.edit', compact('event'));
    }

    /**
     * Memperbarui data event di database.
     */
    public function update(Request $request, Event $event)
    {
        $validasi = $request->validate([
            'nama_event' => 'required|string|max:100',
            'tanggal_event' => 'required|date',
            'waktu_event' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'deskripsi_event' => 'required',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('poster')) {
                // Hapus poster lama jika ada
                if ($event->thumbnail && file_exists(public_path($event->thumbnail))) {
                    unlink(public_path($event->thumbnail));
                }

                $file = $request->file('poster');
                $namaFile = time() . '_' . $file->getClientOriginalName();

                $tujuan = public_path('thumbnails/event');
                if (!file_exists($tujuan)) {
                    mkdir($tujuan, 0755, true);
                }

                $file->move($tujuan, $namaFile);

                $validasi['thumbnail'] = 'thumbnails/event/' . $namaFile;
            }

            $event->update($validasi);
            DB::commit();
            return redirect()->route('event.index')->with('success', 'Event berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui event: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus event dari database.
     */
    public function destroy(Event $event)
    {
        try {
            if ($event->thumbnail && file_exists(public_path($event->thumbnail))) {
                unlink(public_path($event->thumbnail));
            }
            $event->delete();
            return redirect()->route('event.index')->with('success', 'Event berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus event: ' . $e->getMessage());
        }
    }
}
