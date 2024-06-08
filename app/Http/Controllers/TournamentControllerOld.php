<?php

namespace App\Http\Controllers;

use App\Models\Tournament; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class TournamentController extends Controller
{
    // ... (fungsi index, create, show, edit, destroy)
    public function indextour(Request $request)
    {
        $tournaments = Tournament::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $tournaments->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%');
        }

        if ($request->has('tanggal')) {
            $tournaments->whereDate('jadwal_mulai', $request->input('tanggal'));
        }

        $tournaments = $tournaments->latest()->paginate(10); // Mengurutkan berdasarkan terbaru dan paginasi 10 data per halaman

        return view('indextour', compact('tournaments', 'request'));
    }

    public function createtour()
    {
        return view('createtour');
    }

    public function storetour(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'url' => 'required|string|max:255|unique:tournaments',
            'jadwal_mulai' => 'required|date',
            'jadwal_selesai' => 'required|date|after_or_equal:jadwal_mulai',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:Online,Offline',
            'alamat' => 'nullable|string|required_if:tipe,Offline',
            'hadiah' => 'nullable|string',
            'rules' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Tournament::create($request->all()); // Simpan data turnamen
        return redirect()->route('admin.tour.index')->with('success', 'Turnamen berhasil dibuat!');
    }

    public function edittour(Request $request, $id)
    {
        $tournament = Tournament::findOrFail($id);
        return view('edittour', compact('tournament'));
    }

    public function updatetour(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'url' => 'required|string|max:255|unique:tournaments,url,' . $id, // Unique kecuali ID saat ini
            'jadwal_mulai' => 'required|date',
            'jadwal_selesai' => 'required|date|after_or_equal:jadwal_mulai',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:Online,Offline',
            'alamat' => 'nullable|string|required_if:tipe,Offline',
            'hadiah' => 'nullable|string',
            'rules' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tournament = Tournament::findOrFail($id);
        $tournament->update($request->all()); // Update data turnamen
        return redirect()->route('admin.tour.index')->with('success', 'Turnamen berhasil diupdate!');
    }


   

    // ... (fungsi update)
    public function deletetour($id)
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->delete();

        return redirect()->route('admin.tour.index')->with('success', 'Turnamen berhasil dihapus!');
    }

}
