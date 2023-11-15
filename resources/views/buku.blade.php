<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* CSS styles for tables */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        /* CSS styles for the header row (first row) */
        table th {
            background-color: #3498db;
            color: white;
        }

        /* CSS styles for the "Delete" button */
        .button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        .button:hover {
            background-color: #45a049;
        }

        /* Special CSS styles for the "Delete" button */
        .button.delete {
            background-color: #e74c3c;
        }

        .button.delete:hover {
            background-color: #c0392b;
        }

        /* Additional CSS styles for alerts */
        .bg-red-200 {
            background-color: #f87171;
        }

        .text-red-800 {
            color: #c53030;
        }

        .p-4 {
            padding: 1rem;
        }

        .my-4 {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .rounded-lg {
            border-radius: 1rem;
        }

        .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body>
    <h1 class="text-3xl font-semibold text-center mb-6 bg-gray-200 py-2">DAFTAR BUKU</h1>
    <div class="mt-4 mb-4 p-4 bg-white shadow-md flex items-center justify-between">
        <form action="{{ route('buku.search') }}" method="GET" class="flex items-center">
            @csrf
            <input type="text" name="kata" class="border rounded-l py-2 px-3 w-full" placeholder="Cari judul atau penulis...">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white rounded-r px-4 py-2">Cari</button>
        </form>
    </div>
   
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>Judul Buku</th>
                <th>penulis</th>
                <th>Harga</th>
                <th>Tgl. Terbit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        
            @if(Session::has('pesan'))
            <div class="alert alert-success">{{ Session::get('pesan') }}</div>
            @endif
            @php
            $no = 0;
            @endphp
            @foreach($data_buku as $b)
            <tr>
                <td>{{ $b->id }}</td>
                <td>
                    @if($b->filepath)
                        <div class="relative h-24 w-24">
                            <img
                                class="h-full w-full object-cover object-center"
                                src="{{ asset($buku->filepath) }}"
                                alt=""
                                style="padding-right: 20px;"
                            />
                        </div>
                    @endif
                </td>
                <td>{{ $b->judul }}</td>
                <td>{{ $b->penulis }}</td>
                <td>{{ 'Rp'.number_format($b->harga, 2, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($b->tgl_terbit)->format('D/m/Y') }}</td>
                <td>  
                    <form action="{{ route('buku.edit', $b->id) }}">
                        <button class="button" onclick="return confirm('Yakin mau diedit?')">Edit</button>
                    </form>

                    <form action="{{ route('buku.destroy', $b->id) }}" method="post">
                        @csrf
                        <button class="button delete" onclick="return confirm('Yakin mau dihapus?')">Hapus</button>
                    </form>
                </td>
            </tr>    
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $data_buku->links() }}
    </div>
    <div>
        <p><a href="{{ route('buku.create') }}">
            <button class="button">Tambah Buku</button>
        </a></p>
        <p class="text-lg">Jumlah data buku : {{ $jumlah_buku }}</p>
        <p class="text-lg">Jumlah harga semua buku adalah : Rp {{ number_format($b->harga, 2, ',', '.') }}</p>
    </div>
</body>
</html>
@endif
