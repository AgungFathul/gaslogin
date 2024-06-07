<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\RegistrationSetting;
use App\Http\Controllers\GameController;
use App\Models\Game;
use App\Models\Tournament; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class TournamentController extends Controller
{
    public function indextour(Request $request)
    {
        
        $data = Tournament::with('game'); 

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

    public function createtour(Request $request)
    {
       
        $games = Game::all(); // Ambil semua game dari database
        return view('createtour', compact('games'));
    }

    public function storetour(Request $request): RedirectResponse
    {
        
        $validator = Validator::make($request->all(), [
            'user_id'         => 'required|exists:users,id',
            'game_id'         => 'required|exists:games,id',
            'nama'            => 'required|string|max:255',
            'url'             => 'required|string|max:255',
            'jadwal_mulai'    => 'required|date',
            'jadwal_selesai'  => 'required|date|after_or_equal:jadwal_mulai',
            'deskripsi'       => 'required|string',
            'tipe'            => 'required|in:Online,Offline',
            'alamat'          => 'nullable|string|required_if:tipe,Offline',
            'hadiah'          => 'required|string|max:255',
            'rules'           => 'required|string|max:255',
            'jenis_pendaftaran' => 'required|in:Individu,Tim',
            'jumlah_peserta'    => 'required|integer|min:1',
            'jumlah_anggota_tim' => 'nullable|integer|min:1|required_if:jenis_pendaftaran,Tim',
            'batas_pendaftaran' => 'required|date|after_or_equal:jadwal_mulai',
        ], [
            'nama.required'                     => 'Nama turnamen diperlukan.',
            'game_id.required'                  => 'Pilih Game.',
            'url.required'                      => 'URL turnamen diperlukan.',
            'jadwal_mulai.required'             => 'Jadwal mulai diperlukan.',
            'jadwal_selesai.required'           => 'Jadwal selesai diperlukan.',
            'jadwal_selesai.after_or_equal'     => 'Jadwal selesai harus setelah atau sama dengan jadwal mulai.',
            'deskripsi.required'                => 'Deskripsi diperlukan.',
            'hadiah.required'                   => 'Hadiah diperlukan.',
            'tipe.required'                     => 'Tipe turnamen diperlukan.',
            'alamat.required_if'                => 'Alamat diperlukan jika tipe turnamen adalah Offline.',
            'rules.required'                    => 'Rules diperlukan.',
            'jenis_pendaftaran.required'        => 'Jenis pendaftaran harus dipilih.',
            'jenis_pendaftaran.in'              => 'Jenis pendaftaran tidak valid.',
            'jumlah_peserta.required'           => 'Jumlah peserta harus diisi.',
            'jumlah_peserta.integer'            => 'Jumlah peserta harus berupa angka.',
            'jumlah_peserta.min'                => 'Jumlah peserta minimal 1.',
            'jumlah_anggota_tim.integer'        => 'Jumlah anggota tim harus berupa angka.',
            'jumlah_anggota_tim.min'            => 'Jumlah anggota tim minimal 1.',
            'jumlah_anggota_tim.required_if'    => 'Jumlah anggota tim harus diisi jika jenis pendaftaran adalah Tim.',
            'batas_pendaftaran.required'        => 'Batas pendaftaran harus diisi.',
            'batas_pendaftaran.date'            => 'Batas pendaftaran harus berupa tanggal yang valid.',
            'batas_pendaftaran.after_or_equal'  => 'Batas pendaftaran harus setelah atau sama dengan jadwal mulai.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $tournament = Tournament::create([
            'user_id'        => Auth::user()->id,
            'game_id'        => $request->game_id, 
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

        $tournament->registrationSetting()->create([
            'jenis_pendaftaran' => $request->jenis_pendaftaran,
            'jumlah_peserta'    => $request->jumlah_peserta,
            'jumlah_anggota_tim' => $request->jumlah_anggota_tim,
            'batas_pendaftaran' => $request->batas_pendaftaran,
        ]);

        return redirect()->route('admin.tour.index');
    }

    public function edittour(Request $request, $id)
    {
        $data = Tournament::with('registrationSetting')->findOrFail($id);
        $games = Game::all(); // Mengambil semua game dari database
        return view('edittour', compact('data', 'games'));
    }

    public function updatetour(Request $request, $id): RedirectResponse
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
            'jenis_pendaftaran' => 'required|in:Individu,Tim',
            'jumlah_peserta'    => 'required|integer|min:1',
            'jumlah_anggota_tim' => 'nullable|integer|min:1|required_if:jenis_pendaftaran,Tim',
            'batas_pendaftaran' => 'required|date|after_or_equal:jadwal_mulai',
        ], [
            'nama.required'                     => 'Nama turnamen diperlukan.',
            'url.required'                      => 'URL turnamen diperlukan.',
            'jadwal_mulai.required'             => 'Jadwal mulai diperlukan.',
            'jadwal_selesai.required'           => 'Jadwal selesai diperlukan.',
            'jadwal_selesai.after_or_equal'     => 'Jadwal selesai harus setelah atau sama dengan jadwal mulai.',
            'deskripsi.required'                => 'Deskripsi diperlukan.',
            'hadiah.required'                   => 'Hadiah diperlukan.',
            'tipe.required'                     => 'Tipe turnamen diperlukan.',
            'alamat.required_if'                => 'Alamat diperlukan jika tipe turnamen adalah Offline.',
            'rules.required'                    => 'Rules diperlukan.',
            'jenis_pendaftaran.required'        => 'Jenis pendaftaran harus dipilih.',
            'jenis_pendaftaran.in'              => 'Jenis pendaftaran tidak valid.',
            'jumlah_peserta.required'           => 'Jumlah peserta harus diisi.',
            'jumlah_peserta.integer'            => 'Jumlah peserta harus berupa angka.',
            'jumlah_peserta.min'                => 'Jumlah peserta minimal 1.',
            'jumlah_anggota_tim.integer'        => 'Jumlah anggota tim harus berupa angka.',
            'jumlah_anggota_tim.min'            => 'Jumlah anggota tim minimal 1.',
            'jumlah_anggota_tim.required_if'    => 'Jumlah anggota tim harus diisi jika jenis pendaftaran adalah Tim.',
            'batas_pendaftaran.required'        => 'Batas pendaftaran harus diisi.',
            'batas_pendaftaran.date'            => 'Batas pendaftaran harus berupa tanggal yang valid.',
            'batas_pendaftaran.after_or_equal'  => 'Batas pendaftaran harus setelah atau sama dengan jadwal mulai.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = Tournament::findOrFail($id);
        $data->update([
            'nama'             => $request->nama,
            'game_id'          => $request->game_id, 
            'url'              => $request->url,
            'jadwal_mulai'     => $request->jadwal_mulai,
            'jadwal_selesai'   => $request->jadwal_selesai,
            'deskripsi'        => $request->deskripsi,
            'tipe'             => $request->tipe,
            'alamat'           => $request->alamat,
            'hadiah'           => $request->hadiah,
            'rules'            => $request->rules,
        ]);

        $data->registrationSetting()->update([
            'jenis' => $request->jenis_pendaftaran,
            'jumlah_peserta'    => $request->jumlah_peserta,
            'jumlah_anggota_tim' => $request->jumlah_anggota_tim,
            'batas_pendaftaran' => $request->batas_pendaftaran,
        ]);

        return redirect()->route('admin.tour.index')->with('success', 'Turnamen berhasil diperbarui!');
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
