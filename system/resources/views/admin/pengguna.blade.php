@extends('admin.base')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title pb-2">
                        Pengguna
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah</button>
                    </h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Selengkapnya</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_pengguna as $pengguna)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$pengguna->nama}}</td>
                                        <td>{{$pengguna->username}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#editModal{{$pengguna->id}}">Edit</a>
                                                <button class="btn btn-danger tombol-delete" data-id="{{ $pengguna->id }}">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>                                    
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete" action="" method="post" style="display: none">
                            @csrf
                            @method('delete')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal tambah --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{url('tambah-pengguna')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" required/>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required/>
                            </div>
                            <div class="col mb-0">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal edit --}}
    @foreach ($list_pengguna as $pengguna)
        <div class="modal fade" id="editModal{{$pengguna->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Edit Data Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{url('edit-pengguna', $pengguna->id)}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" class="form-control" required value="{{$pengguna->nama}}"/>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" required value="{{$pengguna->username}}"/>
                                </div>
                                <div class="col mb-0">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
    @endforeach
@endsection
@push('pengguna')
    {{-- swal --}}
    <script>
        $(document).ready(function() {
            $('.tombol-delete').click(function() {
                var sensorId = $(this).data('id');
                var deleteUrl = '/hapus-pengguna/' + sensorId;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Anda tidak dapat mengembalikan ini!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#002ca3',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-delete').attr('action', deleteUrl).submit();
                    }
                });
            });
        });
    </script>
@endpush
