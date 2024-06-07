@extends('layout.main')

@section('title', 'Daftar Turnamen')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="col-sm-6">
                        Daftar Turnamen
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('admin.tour.create') }}" class="btn btn-primary">Tambah Turnamen</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Turnamen</th>
                                <th>URL Turnamen</th>
                                <th>Jadwal Mulai</th>
                                <th>Jadwal Selesai</th>
                                <th>Tipe</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tournaments as $tournament)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tournament->nama }}</td>
                                <td>{{ $tournament->url }}</td>
                                <td>{{ $tournament->jadwal_mulai }}</td>
                                <td>{{ $tournament->jadwal_selesai }}</td>
                                <td>{{ $tournament->tipe }}</td>
                                <td>
                                    <a href="{{ route('admin.tour.edit', $tournament->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.tour.delete', $tournament->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus turnamen ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
