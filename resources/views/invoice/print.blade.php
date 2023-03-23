<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $page_title ?? '' }} | {{ setting('title') }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/brand/logo.png') }}" type="image/png">
    <!-- Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"> --}}
    @stack('up')
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.1.0') }}" type="text/css">

    <style>
        th,
        td {
            padding-bottom: 0 !important;
            padding-top: .5rem !important;
            font-size: 14px !important;
            color: #262626;
        }

        h1,
        h4 {
            color: #262626;
            margin-bottom: 0;
        }

        p {
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 500;
            color: #262626;
        }
    </style>
</head>

<body class="text-darker">

    <div class="py-5 mx-auto" style="max-width: 60rem;">
        <div class="mb-4 d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/img/brand/logo.png') }}" height="100px" alt="{{ setting('title') }}">
        </div>
        <div class="text-right mb-4">
            <button onclick="window.print()" class="btn btn-warning" id="printBtn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 18px; height:18px;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                </svg>
            </button>
        </div>
        <div class="text-center mb-4 bg-light text-darker py-2 rounded-lg border">
            <h1 class="mb-0">NO PEMBAYARAN: {{ $t->no_transaksi }}</h1>
        </div>

        <div class="row justify-content-between">
            <div class="col-4">
                <table class="table table-borderless">
                    <tr>
                        <th>NIS</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Nama siswa</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ $user->rombel->major_competency }}</td>
                    </tr>
                    <tr>
                        <th>tanggal pembayaran</th>
                        <td>{{ $t->approved_at }}</td>
                    </tr>
                    <tr>
                        <th>Nama Petugas</th>
                        <td>{{ Auth::user()->name }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-4 text-right">
                <p>{{ setting('title') }}</p>
                <p>{{ setting('alamat') }}</p>
                <p>{{ setting('telepon') }}</p>
                <p>{{ env('APP_URL') }}</p>
            </div>
        </div>

        <div
            class="text-center mt-4 bg-light text-darker py-2 px-4 rounded-lg d-flex align-items-center justify-content-between border">
            <h4 class="mb-0">Pembayaran SPP Bulan {{ $t->for_month . date(' Y') }}</h4>
            <h4>Rp. {{ number_format($t->amount) }}</h4>
        </div>

				<div style="margin-top: 4rem;">
					<h5 class="mb-0">NOTICE:</h5>
					<p class="text-danger">Bukti pembayaran harap disimpan dengan baik.</p>
				</div>
    </div>

    @include('partials.scripts')
    <script>
        // window.print();
    </script>
</body>

</html>
