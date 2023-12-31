<!DOCTYPE html>
<html lang="en">
@include('template.head')

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    {{-- sidebar --}}
    @include('template.sidebar')
    {{-- end sidebar --}}
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        @include('template.navbar')
        {{-- end navbar --}}

        {{-- --------------------------------------- S T A R T - P E G A W A I ----------------------------------------}}

        <!--start container-->
        <div class="container-fluid py-4">

            <div class="row">
                <div class="col-md-12">
                    @if (session()->has('msg'))
                    <div class="alert alert-success" style="color:white;">
                        {{ session()->get('msg') }}
                        <div style="float: right">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                </div>



                <div class="col-12">
                    @if(session()->has('pesan'))
                    <div class="alert alert-success" style="color:white;">
                        {{ session()->get('pesan')}}
                        <div style="float: right">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Data Pegawai</h6>
                            <button id="addPegawai" class="btn  bg-gradient-dark mb-3" data-bs-toggle="modal"
                                data-bs-target="#addPegawaiModal">Tambah Data</button>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="pegawai-table" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                NIP</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Email</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jabatan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Foto</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pegawai as $key => $p)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="px-2 mb-0 text-xs">{{$key+1}}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$p->nip}}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold mb-0">{{$p->name??'N/A'}}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold mb-0">{{$p->email??'N/A'}}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-xs font-weight-bold mb-0">{{$p->jabatan??'N/A'}}
                                                </span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <img src="{{env('APP_URL')}}/api/file/{{$p->foto ?? 'master_user.png'}}" alt="File Photo" class="img-thumbnail " style="width: 4rem; height: 4rem;">
                                            </td>

                                            <td class="align-middle text-center">
                                                <a href="#" data-bs-toggle="modal"
                                                   data-bs-target=" #editPegawai-{{$p->id}}">
                                                    <button class="btn btn-warning">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                                <a href="#" data-bs-toggle="modal"
                                                   data-bs-target="#deletePegawai-{{ $p->id }}">
                                                    <button class="btn btn-danger">
                                                        <i class="fa fa-trash"></i></button>
                                                </a>
                                                <a href="#" data-bs-toggle="modal"
                                                   data-bs-target="#editPassword-{{ $p->id }}">
                                                    <button class="btn btn-secondary">
                                                        <i class="fa fa-key"></i></button>
                                                </a>
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



            {{-- --------------------------------------- E N D  - P E G A W A I -----------------------------------------}}

            {{-- ----------------------------------------- S T A R T - A D D -----------------------------------------}}

            <div class="modal fade" id="addPegawaiModal" aria-labelledby="addPegawaiLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPegawaiLabel">Pendaftaran Pegawai</h5>
                            <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('pegawai.createPegawai') }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class='mb-3'>
                                    <input type="hidden" name="id" id="id" value="">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="number" name="nip" id="nip" class="form-control" autofocus>
                                    <div id="nip-feedback" class="invalid-feedback"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                    <div id="name-feedback" class="invalid-feedback"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" id="email" class="form-control">
                                    <div id="email-feedback" class="invalid-feedback"></div>
                                </div>


                                <div class="mb-3">
                                    <label for="jabatan" class="form-label">jabatan</label>
                                    <input type="text" name="jabatan" id="jabatan" class="form-control">
                                    <div id="jabatan-feedback" class="invalid-feedback"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">password</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                    <div id="password-feedback" class="invalid-feedback"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="foto" class="form-label">foto</label>
                                    <input type="file" name="foto" id="foto" class="form-control">
                                    <div id="foto-feedback" class="invalid-feedback"></div>
                                </div>

                                <div style="float: right">
                                    <button type="submit" class="btn btn-primary mb-2">Simpan</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ------------------------------------------- E N D - A D D -------------------------------------------}}

            {{---------------------------------------- E D I T ----------------------------------------}}

            @foreach($pegawai as $p)
                <div class="modal fade" id="editPegawai-{{$p->id}}" aria-labelledby="addPegawaiLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPegawaiLabel">Edit Pegawai</h5>
                                <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="pegawai/update/{{ $p->id }}" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nip" class="form-label">Nip Lengkap</label>
                                        <input type="text" name="nip" id="nip" class="form-control"
                                               value="{{ old('nip') ?? $p->nip}}">
                                        <div id="nip-feedback" class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ old('name') ?? $p->name}}">
                                        <div id="name-feedback" class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                               value="{{ old('email') ?? $p->email }}">
                                        <div id="email-feedback" class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan</label>
                                        <input type="text" name="jabatan" id="jabatan" class="form-control"
                                               value="{{ old('jabatan') ?? $p->jabatan }}">
                                        <div id="jabatan-feedback" class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="foto" class="form-label">foto</label>
                                        <input type="file" name="foto" id="foto" class="form-control">
                                        <div id="foto-feedback" class="invalid-feedback"></div>
                                    </div>


                                    <div style="float: right">
                                        <button type="submit" class="btn btn-primary mb-2">Update</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{----------------------------------- E N D - E D I T  -----------------------------------}}



            {{---------------------------------------- P A S S W O R D ----------------------------------------}}

            @foreach($pegawai as $p)
                <div class="modal fade" id="editPassword-{{ $p->id }}" aria-labelledby="passwordLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="passwordLabel">Edit Password</h5>
                                <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="pegawai/passwordupdate/{{ $p->id }}" method="POST">
                                    @csrf
                                    <div class='mb-3'>
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="text" name="password" id="password" class="form-control"
                                               value="">
                                        <div id="password" class="invalid-feedback"></div>
                                    </div>

                                    <div style="float: right">
                                        <button type="submit" class="btn btn-primary mb-2">Update Password</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{----------------------------------- E N D - P A S S W O R D -----------------------------------}}


            {{-------------------------------------- D E L E T E --------------------------------------}}
            @foreach($pegawai as $p)
                <div class="modal fade" id="deletePegawai-{{ $p->id }}"
                     aria-labelledby="exampleModalLabel{{ $p->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="padding: 15px">
                            <div class="modal-body">Hapus data {{$p->nama }} ?</div>
                            <div style="margin-right: 10px;">
                                <a class="btn btn-danger" href="pegawai/delete/{{$p->id}}"
                                   style="float: right">Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{----------------------------------- E N D - D E L E T E --------------------------------------}}


            <!--end container-->
        {{-- footer --}}
        @include('template.footer')
        {{-- end footer --}}
        </div>
    </main>
    <!--   Core JS Files   -->
    @include('template.script')

</body>

</html>
