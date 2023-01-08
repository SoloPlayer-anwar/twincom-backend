@extends('pdf.layouts')
@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- HEADER --}}
        <div class="col-lg-25">
            <table class="table table-sm table-borderless">
                <tr>
                    <td width="20%">
                        <img src="data:image/png;base64, {!! $images['logo1']!!}" alt="" class="img img-fluid" width="50px;">

                    </td>
                    <td width="60%" class="text-center font-weight-bolder">
                        PERUSAHAAN CV.TWIN GROUP KALIMATAN SELATAN
                        <br>
                        JL.KP.BARU RT.03 RW.02 JL.SEROJA NO.11 LANDASAN ULIN TIMUR
                    </td>
                    <td width="20%">
                        <img src="data:image/png;base64, {!! $images['logo2']!!}" alt="" class="img img-fluid" width="50px;">
                    </td>
                </tr>

            </table>
            <div class="d-block mb-3" style="border-bottom: solid 1px black;"></div>
            <div class="text-center font-weight-bolder text-underline mb-3">
                <u>
                    SURAT OTOMATIS PROSUDER
                </u>
            </div>
        </div>

        {{-- BODY --}}
        <div class="col-lg-12">
            @php
                $detail_ajuan = [
                    ['name'=>'NAMA', 'value'=>$prosuder->name_bm],
                    ['name'=>'JABATAN', 'value'=>$prosuder->jabatan_bm ?? '-'],
                    ['name'=>'CABANG', 'value'=>$keluhan->cabang_bm ?? '-'],
                ];

                <div class="d-block mb-3" style="border-bottom: solid 1px black;"></div>
                <div class="font-weight-bolder text-underline mb-3">
                    <u>
                        DENGAN INI SAYA BERMAKSUD INI MENGUSULKAN PERMOHONAN $prosuder->options->options
                    </u>
                </div>

                $detail_user = [
                    ['name'=>'NAMA', 'value'=>$prosuder->user->name ?? '-'],
                    ['name'=>'JABATAN', 'value'=>$keluhan->user->role ?? '-'],
                    ['name'=>'CABANG', 'value'=>$keluhan->user->cabang ?? '-'],
                ];

                <div class="d-block mb-3" style="border-bottom: solid 1px black;"></div>
                <div class="font-weight-bolder text-underline mb-3">
                    <u>
                        Demikian permohonan ini dibuat untuk ditindak lanjuti, atas perhatian dan kerjasamanya, saya ucapkan terima kasih
                    </u>
                </div>

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
                            <br>
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
