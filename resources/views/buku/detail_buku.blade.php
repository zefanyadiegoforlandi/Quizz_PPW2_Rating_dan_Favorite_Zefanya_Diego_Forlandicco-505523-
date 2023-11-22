<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('DAFTAR BUKU') }}
        </h2>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('dist/css/lightbox.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </x-slot>

<body>   
    <h1 class="text-3xl font-semibold text-center mb-6 bg-gray-200 py-2">DETAIL BUKU</h1>
    

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Gambar</th>
                    <th>Judul Buku</th>
                </tr>
            </thead>
            <tbody>
                @if(Session::has('pesan'))
                <div class="alert alert-success">{{ Session::get('pesan') }}</div>
                @endif
                @foreach($data_buku as $b)
                <tr>
                    <td>
                        <div class="gallery_items mt-6 grid grid-cols-2 gap-4">
                            @foreach($b->galleries as $gallery)
                                <div class="relative group flex items-center justify-between  transition duration-300 transform hover:scale-105">
                                    <a href="{{ asset($gallery->path) }}"
                                        data-lightbox="image-1" data-title="{{ $b->keterangan }}">
                                        <img src="{{ asset($gallery->path) }}" alt="Gallery Image" class="rounded-lg object-cover h-32 w-full">
                                    </a>
                                    
                                    
                                </div>
                            @endforeach
                        </div>
                    </td>
                    <td>{{ $b->judul }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('dist/js/lightbox-plus-jquery.min.js') }}"></script>

</x-app-layout>

