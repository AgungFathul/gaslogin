@extends('layout.main')

@section('title', 'Buat Turnamen Baru')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Buat Turnamen Baru</div>

                    <div class="card-body">
                        <form action="{{ route('admin.tour.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Turnamen</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="url" class="form-label">URL Turnamen</label>
                                <input type="text" class="form-control @error('url') is-invalid @enderror" id="url" name="url" value="{{ old('url') }}">
                                @error('url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jadwal_mulai" class="form-label">Jadwal Mulai</label>
                                <input type="date" class="form-control @error('jadwal_mulai') is-invalid @enderror" id="jadwal_mulai" name="jadwal_mulai" value="{{ old('jadwal_mulai') }}">
                                @error('jadwal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jadwal_selesai" class="form-label">Jadwal Selesai</label>
                                <input type="date" class="form-control @error('jadwal_selesai') is-invalid @enderror" id="jadwal_selesai" name="jadwal_selesai" value="{{ old('jadwal_selesai') }}">
                                @error('jadwal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tipe" class="form-label">Tipe Turnamen</label>
                                <select class="form-select @error('tipe') is-invalid @enderror" id="tipe" name="tipe">
                                    <option value="Online" {{ old('tipe') == 'Online' ? 'selected' : '' }}>Online</option>
                                    <option value="Offline" {{ old('tipe') == 'Offline' ? 'selected' : '' }}>Offline</option>
                                </select>
                                @error('tipe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="alamat-container" style="{{ old('tipe') == 'Offline' ? '' : 'display:none;' }}">
                                <label for="alamat" class="form-label">Alamat (jika Offline)</label>
                                <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}">
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="hadiah" class="form-label">Hadiah Pemenang</label>
                                <textarea class="form-control @error('hadiah') is-invalid @enderror" id="hadiah" name="hadiah">{{ old('hadiah') }}</textarea>
                                @error('hadiah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="rules" class="form-label">Rules</label>
                                <textarea class="form-control @error('rules') is-invalid @enderror" id="rules" name="rules">{{ old('rules') }}</textarea>
                                @error('rules')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Buat Turnamen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const tipeSelect = document.getElementById('tipe');
        const alamatContainer = document.getElementById('alamat-container');

        tipeSelect.addEventListener('change', function() {
            if (this.value === 'Offline') {
                alamatContainer.style.display = 'block';
            } else {
                alamatContainer.style.display = 'none';
            }
        });
    </script>
@endsection
