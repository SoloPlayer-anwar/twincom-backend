@extends('pdf.layouts')
@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- HEADER --}}
        <div class="col-lg-25">
            <table class="table table-sm table-borderless">
                <tr>
                    <td width="20%">
                        <img src="data:image/png;base64, {!! $images['logo']!!}" alt="" class="img img-fluid" width="100px;">

                    </td>
                    <td width="60%" class="text-center font-weight-bolder">
                        PERUSAHAAN CV.TWIN GROUP KALIMATAN SELATAN
                        <br>
                        JL.KP.BARU RT.03 RW.02 JL.SEROJA NO.11 LANDASAN ULIN TIMUR
                    </td>
                    <td width="20%">
                        <img src="data:image/png;base64, {!! $images['logo1']!!}" alt="" class="img img-fluid" width="100px;">
                    </td>
                </tr>

            </table>
            <div class="d-block mb-3" style="border-bottom: solid 1px black;"></div>
            <div class="text-center font-weight-bolder text-underline mb-3">
                <u>
                    SURAT PERSETUAN MAGANG
                </u>
            </div>
            <br>
            <br>
        </div>


        {{-- BODY --}}
        <div class="col-lg-12">

            <div class="ml-12 mb-3">
                <span>
                    Yang bertanda tangan dibawah ini:
                </span>
            </div>

            @php
                $detail_admin = [
                    ['name'=>'Nama', 'value'=>$magang->name ?? '-'],
                    ['name'=>'Jabatan', 'value'=> 'Admin. HRD' ?? '-'],
                    ['name'=>'Nama perusahaan', 'value'=>$magang->name_perusahaan ?? '-'],
                    ['name' => 'Alamat', 'value' => $magang->alamat ?? '-'],
                ];

                $detail_ket = [
                    ['name' =>  $magang->sekolah, 'value'=> $magang->tanggal ?? '-'],
                ];

                $detail_siswa = [
                    ['name' => 'NAMA', 'value' =>$magang->user->name],
                    ['name' => 'NIS', 'value' =>$magang->nis],
                    ['name' => 'KOMPETENSI KEAHLIAN', 'value' =>$magang->keahlian],
                    ['name' => 'PENEMPATAN', 'value' =>$magang->user->cabang],
                ];


            @endphp
            {{-- FORM ADMIN --}}
            <table class="table table-sm table-borderless">
                <tbody>
                    @foreach ($detail_admin as $row)
                    <tr>
                        <td width="30%">{{$row['name']}}</td>
                        <td width="70%">: {{$row['value']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="my-3"></div>
            {{-- FORM KETERANGAN --}}

            <div class="col-lg-25">
                    @foreach ($detail_ket as $row )
                    <table>
                        <tr>
                            <td width ="60%">
                                Sehubungan dengan surat permohonan yang kami terima pada tanggal {{$row['value']}}<br>Bersama ini kami bersedia untuk menerima siswa dari {{$row['name']}}<br>untuk melakukan PKL (Prakter Kerja Lapangan)<br>dari tanggal {{$row['value']}} di perusahaan kami<br>
                                Adapun siswa didik yang kami terima adalah sebagai berikut:
                            </td>
                        </tr>
                    </table>
                    @endforeach
            </div>
            <br>

            <table class="table table-sm table-borderless">
                <tbody>
                    @foreach ($detail_siswa as $row)
                    <tr>
                        <td width="30%">{{$row['name']}}</td>
                        <td width="70%">: {{$row['value']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="ml-12 mb-3">
               <span>
                Demikian surat persetuan dari kami mohon<br>untuk dapat diketahui dan dipergunakan sebagai mestinya
               </span>
            </div>
            <br>
        </div>

        {{-- FOOTER --}}
        <div class="col-lg-12">
            <table class="table table-sm table-borderless">
                <thead>
                    <tr>
                        <br>
                        <td width="60%" class="text-center">
                            BANJARBARU, {{date('d-m-Y')}}
                            <br>
                            Hormat Kami,
                            <br>
                            <br>
                            <br>
                            Anisa Ayu Lestari
                            <br>
                            Adm.HRD
                            <br>
                            TWIN GROUP
                        </td>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>
@endsection
