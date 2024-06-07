<?php
namespace App\Http\Controllers;
use App\Models\Tournament; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class TournamentController extends Controller
{
    public function indextour(Request $request)
    {
        $data = new Tournament;

        if ($request->get('search')) {
            $search = $request->input('search');
            $data->where('nama', 'LIKE', '%' . $search . '%')
                        ->orWhere('deskripsi', 'LIKE', '%' . $search . '%');
        }

        if ($request->get('tanggal')) {
            $data = $data->where('nama', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhere('deskripsi', 'LIKE', '%' . $request->get('search') . '%');
        }

        $data = $data->get();

        return view('indextour', compact('data', 'request'));
    }

    public function createtour()
    {
        return view('createtour');
    }

    public function storetour(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nama'            => 'required|string|max:255',
            'url'             => 'required|string|max:255',
            'jadwal_mulai'    => 'required|date',
            'jadwal_selesai'  => 'required|date|after_or_equal:jadwal_mulai',
            'deskripsi'       => 'required|string',
            'tipe'            => 'required|in:Online,Offline',
            'alamat'          => 'nullable|string|required_if:tipe,Offline',
            'hadiah'          => 'required|string|max:255',
            'rules'           => 'required|string|max:255',
        ], [
            'nama.required'                 => 'Nama turnamen diperlukan.',
            'url.required'                  => 'URL turnamen diperlukan.',
            'jadwal_mulai.required'         => 'Jadwal mulai diperlukan.',
            'jadwal_selesai.required'       => 'Jadwal selesai diperlukan.',
            'jadwal_selesai.after_or_equal' => 'Jadwal selesai harus setelah atau sama dengan jadwal mulai.',
            'deskripsi.required'            => 'Deskripsi diperlukan.',
            'hadiah.required'               => 'Hadiah diperlukan.',
            'tipe.required'                 => 'Tipe turnamen diperlukan.',
            'alamat.required_if'            => 'Alamat diperlukan jika tipe turnamen adalah Offline.',
            'rules.required'                => 'Rules diperlukan.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        Tournament::create([
            'nama'           => $request->nama,
            'url'            => $request->url,
            'jadwal_mulai'   => $request->jadwal_mulai,
            'jadwal_selesai' => $request->jadwal_selesai,
            'deskripsi'      => $request->deskripsi,
            'tipe'           => $request->tipe,
            'alamat'         => $request->alamat,
            'hadiah'         => $request->hadiah,
            'rules'          => $request->rules,
        ]);

        return redirect()->route('admin.tour.index');
    }

    public function edittour(Request $request, $id)
    {
        $data = Tournament::findOrFail($id);
        return view('edittour', compact('data'));
    }

    public function updatetour(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nama'            => 'required|string|max:255',
            'url'             => 'required|string|max:255',
            'jadwal_mulai'    => 'required|date',
            'jadwal_selesai'  => 'required|date|after_or_equal:jadwal_mulai',
            'deskripsi'       => 'required|string',
            'hadiah'          => 'required|string|max:255',
            'tipe'            => 'required|in:Online,Offline',
            'alamat'          => 'nullable|string|required_if:tipe,Offline',
            'rules'           => 'required|string|max:255',
        ], [
            'nama.required'                 => 'Nama turnamen diperlukan.',
            'url.required'                  => 'URL turnamen diperlukan.',
            'jadwal_mulai.required'         => 'Jadwal mulai diperlukan.',
            'jadwal_selesai.required'       => 'Jadwal selesai diperlukan.',
            'jadwal_selesai.after_or_equal' => 'Jadwal selesai harus setelah atau sama dengan jadwal mulai.',
            'deskripsi.required'            => 'Deskripsi diperlukan.',
            'hadiah.required'               => 'Hadiah diperlukan.',
            'tipe.required'                 => 'Tipe turnamen diperlukan.',
            'alamat.required_if'            => 'Alamat diperlukan jika tipe turnamen adalah Offline.',
            'rules.required'                => 'Rules diperlukan.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = Tournament::findOrFail($id);
        $data->update([
            'nama'             => $request->nama,
            'url'              => $request->url,
            'jadwal_mulai'     => $request->jadwal_mulai,
            'jadwal_selesai'   => $request->jadwal_selesai,
            'deskripsi'        => $request->deskripsi,
            'tipe'             => $request->tipe,
            'alamat'           => $request->alamat,
            'hadiah'           => $request->hadiah,
            'rules'            => $request->rules,
        ]);

        return redirect()->route('admin.tour.index');
    }

    // ... (fungsi update)
    public function deletetour($id)
    {
        $data = Tournament::find($id);

        if ($data) {
            $data->forceDelete();
        }

        return redirect()->route('admin.tour.index')->with('success', 'Turnamen berhasil dihapus!');
    }

}
