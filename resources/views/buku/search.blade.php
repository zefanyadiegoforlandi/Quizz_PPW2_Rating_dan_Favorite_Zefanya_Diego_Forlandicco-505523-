<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    @if(Session::has('pesan'))
    <div class="alert alert-success p-4 my-4 rounded-lg shadow-md">
        {{ Session::get('pesan') }}
    </div>
    @endif

    @if(Session::has('delete'))
    <div class="alert alert-danger p-4 my-4 rounded-lg shadow-md">
        {{ Session::get('delete') }}
    </div>
    @endif

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <title>Data Buku</title>
</head>
<body>
    <div class="container mx-auto mt-10 p-4">
        <h1 class="text-3xl font-semibold text-center mb-6 bg-gray-200 py-2">Hasil Pencarian Buku</h1>
        <div class="mt-4 mb-4 p-4 bg-white shadow-md flex items-center justify-between">
            <form action="{{ route('buku.search') }}" method="GET" class="flex items-center">
                @csrf
                <input type="text" name="kata" class="border rounded-l py-2 px-3 w-full" placeholder="Cari judul atau penulis...">
                <button type="submit" class="btn btn-primary rounded-r px-4 py-2">Cari</button>
            </form>
        </div>
        

        @if (count($data_buku))
        <div class="alert alert-info p-4 my-4 rounded-lg shadow-md">
            Ditemukan <strong>{{ count($data_buku) }}</strong> data dengan kata: <strong>{{ $cari }}</strong>
        </div>
        @else
        <div class="alert alert-danger p-4 my-4 rounded-lg shadow-md">
            <h4>Data {{ $cari }} tidak ditemukan</h4> <a href="/buku" class="text-blue-500 hover:text-blue-700">Kembali ke Daftar Buku</a>
        </div>
        @endif

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Harga</th>
                    <th>Tgl. Terbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if(Session::has('pesan'))
                <div class="alert alert-success">{{ Session::get('pesan') }}</div>
                @endif
                @foreach($data_buku as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td>{{ $b->judul }}</td>
                    <td>{{ $b->penulis }}</td>
                    <td>{{ 'Rp'.number_format($b->harga, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($b->tgl_terbit)->format('D/m/Y') }}</td>
                    <td>  
                        <form action="{{ route('buku.edit', $b->id) }}">
                            <button class="btn btn-primary" onclick="return confirm('Yakin mau diedit?')">Edit</button>
                        </form>
    
                        <form action="{{ route('buku.destroy', $b->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>    
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <p><a href="{{ route('buku.create') }}">
            <button class="btn btn-success">Tambah Buku</button>
        </a></p>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
