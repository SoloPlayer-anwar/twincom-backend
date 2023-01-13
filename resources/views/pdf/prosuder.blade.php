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
                    SURAT OTOMATIS PROSUDER
                </u>
            </div>
            <br>
            <br>
        </div>


        {{-- BODY --}}
        <div class="col-lg-12">

            <div class="ml-12 mb-3">
                <span>
                    Dengan Hormat.
                    <br>
                    Saya bertanda tangan dibawah ini :
                </span>
            </div>

            @php
                $detail_ajuan = [
                    ['name'=>'Nama', 'value'=>$prosuder->name_bm ?? '-'],
                    ['name'=>'Jabatan', 'value'=>$prosuder->jabatan_bm ?? '-'],
                    ['name'=>'Cabang', 'value'=>$prosuder->cabang_bm ?? '-'],
                ];



                $detail_user = [
                    ['name'=>'Nama', 'value'=>$prosuder->user->name ?? '-'],
                    ['name'=>'Jabatan', 'value'=>$prosuder->user->role ?? '-'],
                    ['name'=>'Cabang', 'value'=>$prosuder->user->cabang ?? '-'],
                ];

                $detail_keterangan = [
                    ['name' => 'Keterangan', 'value' => $prosuder->options->keterangan ?? '-'],
                ];

                $detail_sistem = [
                    ['name' => 'Dengan alasan dibawah ini :', 'value' => $prosuder->tdm ?? '-'],
                ];


            @endphp
            {{-- PERBAIKAN --}}
            <table class="table table-sm table-borderless">
                <tbody>
                    @foreach ($detail_ajuan as $row)
                    <tr>
                        <td width="30%">{{$row['name']}}</td>
                        <td width="70%">: {{$row['value']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="my-3"></div>
            {{-- KELUHAN --}}

            <div class="me-10">
                <span>
                    @foreach ($detail_keterangan as $row )
                    <span class="text-sm">{{$row['name']}}:</span>
                    <br>
                        <span class="me-10">{{$row['value']}}</span>
                    @endforeach
                </span>
            </div>
            <br>

            <table class="table table-sm table-borderless">
                <tbody>
                    @foreach ($detail_user as $row)
                    <tr>
                        <td width="30%">{{$row['name']}}</td>
                        <td width="70%">: {{$row['value']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="ml-12 mb-3">
                @foreach ($detail_sistem as $row )
                <span>
                    {{$row['name']}}
                    <br>
                    <b>{{$row['value']}}</b>
                </span>
                @endforeach
            </div>

            <br>
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
