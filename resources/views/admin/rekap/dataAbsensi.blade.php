<!DOCTYPE html>
<html lang="en">
@include('template.head')

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>

    <!-- Sidebar -->
    @include('template.sidebar')
    <!-- End Sidebar -->

    <main class="main-content position-relative border-radius-lg ">

        <!-- Navbar -->
        @include('template.navbar')
        <!-- End Navbar -->

        {{----------------------------------------- V I E W -----------------------------------------}}

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
                            <h6>Data Presensi</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="dataabsensi" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Tanggal</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                NIP</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama</th>

                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jam Masuk</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jam Pulang</th>

                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($absen->count() > 0)
                                        @foreach($absen as $key => $p)

                                        <?php $no = 1 ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="px-2 mb-0 text-xs">{{$no++}}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{$p->tgl_presensi??'N/A'}}
                                                </span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{$p->nip??'N/A'}}</span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{$p->name??'-'}}</span>
                                            </td>


                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{$p->jam_masuk??'N/A'}}</span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{$p->jam_pulang??'N/A'}}</span>
                                            </td>



                                            <td class="align-middle text-center">
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target=" #editDataPresensi-{{$p->id}}">
                                                    <button class="btn btn-warning">
                                                        <i class="fa fa-edit"></i></button>
                                                </a>

                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deleteDataPresensi-{{ $p->id }}">
                                                    <button class="btn btn-danger">
                                                        <i class="fa fa-trash"></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                    <tbody>
                                        <tr>
                                            <td class="text-center">Tidak Ada Data</td>
                                        </tr>
                                    </tbody>
                                    @endif
                                    </tbody>

                                </table>
                                <div class="px-3 page d-flex justify-content-between">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


        {{----------------------------------------- E N D  - V I E W -----------------------------------------}}



        <!-- Footer -->
        @include('template.footer')
        {{-- End Footer --}}

        <!--   Core JS Files   -->
        @include('template.script')

</body>
</html>
