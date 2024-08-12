<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Surat Pengantar {{ $request->document_no }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
         <style>
            /* http://meyerweb.com/eric/tools/css/reset/ 
            v2.0 | 20110126
            License: none (public domain)
            */

            html, body, div, span, applet, object, iframe,
            h1, h2, h3, h4, h5, h6, p, blockquote, pre,
            a, abbr, acronym, address, big, cite, code,
            del, dfn, em, img, ins, kbd, q, s, samp,
            small, strike, strong, sub, sup, tt, var,
            b, u, i, center,
            dl, dt, dd, ol, ul, li,
            fieldset, form, label, legend,
            table, caption, tbody, tfoot, thead, tr, th, td,
            article, aside, canvas, details, embed, 
            figure, figcaption, footer, header, hgroup, 
            menu, nav, output, ruby, section, summary,
            time, mark, audio, video {
                margin: 0;
                padding: 0;
                border: 0;
                font-size: 100%;
                font: inherit;
                vertical-align: baseline;
            }
            /* HTML5 display-role reset for older browsers */
            article, aside, details, figcaption, figure, 
            footer, header, hgroup, menu, nav, section {
                display: block;
            }
            body {
                line-height: 1;
            }
            ol, ul {
                list-style: none;
            }
            blockquote, q {
                quotes: none;
            }
            blockquote:before, blockquote:after,
            q:before, q:after {
                content: '';
                content: none;
            }
            table {
                border-collapse: collapse;
                border-spacing: 0;
            }
         </style>
        <style>
            body {
                margin: 0;
                font-size: 14px;
            }
            p {
                padding : 5px;
            }
            h1 {
                font-size: 1.5em;
            }
            .font-bold {
                font-weight: 800;
            }
            .text-center {
                text-align: center;
            }
            .text-left {
                text-align: left;
            }
            .text-right {
                text-align: right;
            }
            .p-2 {
                padding: 20px;
            }
            .pt-2 {
                padding-top: 20px;
            }
            table {
                border-collapse: separate;
                border-spacing: 10px;
            }
            .mt-2 {
                margin-top: 20px;
            }
            .w-full { 
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div class="p-2 text-center">
            <h1 class="font-bold text-xl">RUKUN TETANGGA {{ Str::padLeft($request->rt,3,'0') }} / 08</h1>
            <h2 class="font-medium text-md">KELURAHAN KELAPA DUA KECAMATAN KEBON JERUK</h2>
            <h2 class="font-medium text-md">KOTA ADMINISTRASI JAKARTA BARAT</h2>
            <p>Sekretariat : {{ $rt->address }} {{ $rt->phone?'Telp : '.$rt->phone:'' }} {{ $rt->email?'Email : '.$rt->email:'' }}</p>
            <p>JAKARTA</p>
            <p class="text-right">Kode Pos 11550</p>
            <hr class="border border-1 border-black order-double" />
            <div class="text-sm">
            <p class="pt-2 underline text-md font-bold">SURAT PENGANTAR</p>
            <p class="">NOMOR : {{ $request->document_no }}</p>
            <div class="text-left">
                <p>Yang bertanda tangan ini, menerangkan bahwa :</p>
                <table class="mt-2 w-full">
                    <tr>
                        <td width="150px">Nama</td>
                        <td width="10px">: </td>
                        <td>{{ $request->name }}</td>
                    </tr>
                    <tr>
                        <td>Tempat/Tgl. Lahir</td>
                        <td>: </td>
                        <td>{{ $request->birth_place }}, {{ $request->birth_date->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>: </td>
                        <td>@lang('gender.'.$request->gender)</td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>: </td>
                        <td>{{ $request->religion }}</td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>: </td>
                        <td>{{ $request->work }}</td>
                    </tr>
                    <tr>
                        <td>No KTP</td>
                        <td>: </td>
                        <td>{{ $request->nik }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: </td>
                        <td>{{ $request->address }} RT. {{ Str::padLeft($request->rt,3,'0') }} / RW. 008 Kelurahan  Kelapa Dua  kecamatan Kebon Jeruk Kota Jakarta Barat</td>
                    </tr>
                    <tr>
                        <td>Keperluan</td>
                        <td>: </td>
                        <td>{{ $request->description }}</td>
                    </tr>
                </table>
                <p class="mt-2">Demikian surat pengantar ini dibuat untuk dapat dipergunakan sebagaimana semestinya dan yang berkepentingan untuk menjadi maklum.</p>
                <p class="mt-2">Nomor : {{ $request->document_no }}</p>
                <p class="">Tanggal : {{ $request->created_at->format('d M Y') }}</p>
                <table class="w-full mt-2">
                    <tr>
                        <td class="text-center">
                            <p>KETUA RW 08<br/>
                            KELURAHAN KELAPA <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            ( {{ $rw->name }} )</p>
                        </td>
                        <td class="text-center">
                            <p>KETUA RT {{ Str::padLeft($request->rt,3,'0') }} / 08<br/>
                            KELURAHAN KELAPA <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>( {{ $rt->name }} )</p>
                        </td>
                    </tr>
                </table>
            </div>
            </div>
        </div>
    </body>
</html>
