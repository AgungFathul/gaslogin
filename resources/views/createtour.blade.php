@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Berita</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tambah Tunamen</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="col-12">
                    <form action="{{ route('admin.tour.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- general form elements -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Form Tambah Turnamen</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Nama Turnamen</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    name="nama" placeholder="Masukan Nama Turnamen">
                                                @error('nama')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">URL Turnamen</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    name="url" placeholder="Masukan URL Turnamen">
                                                @error('url')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Jadwal Mulai</label>
                                                <input type="date" class="form-control" id="exampleInputEmail1"
                                                    name="jadwal_mulai">
                                                @error('jadwal_mulai')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Jadwal Selesai</label>
                                                <input type="date" class="form-control" id="exampleInputEmail1"
                                                    name="jadwal_selesai">
                                                @error('jadwal_selesai')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Deskripsi</label>
                                                <textarea class="summernote" name="deskripsi"></textarea>
                                                @error('deskripsi')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tipe Turnamen</label>
                                                <select class="form-select @error('tipe') is-invalid @enderror"
                                                    id="tipe" name="tipe">
                                                    <option value="Online" {{ old('tipe') == 'Online' ? 'selected' : '' }}>
                                                        Online</option>
                                                    <option value="Offline"
                                                        {{ old('tipe') == 'Offline' ? 'selected' : '' }}>
                                                        Offline</option>
                                                </select>
                                                @error('tipe')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group" id="alamat-container"
                                                style="{{ old('tipe') == 'Offline' ? '' : 'display:none;' }}">
                                                <label for="exampleInputEmail1">Alamat (jika Offline)</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    name="alamat" placeholder="Masukan Alamat">
                                                @error('alamat')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Hadiah Pemenang</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    name="hadiah" placeholder="Masukan Hadiah Pemenang">
                                                @error('hadiah')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Ruled</label>
                                                <textarea class="summernote" name="rules"></textarea>
                                                @error('rules')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->
                        </div>
                    </form>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
        </section>

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

        $(document).ready(function() {
            $('.summernote').summernote();
        });
    </script>
@endsection
