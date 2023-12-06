<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('BUKU FAVORITKU') }}
        </h2>
    </x-slot>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
        <link href="{{ asset('dist/css/lightbox.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    @if(count($errors) > 0)
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    @endif 

    <body>   
        <h1 class="text-3xl font-semibold text-center mb-6 bg-gray-200 py-2">DAFTAR FAVORIT</h1>
        @if($favouriteBooks->isEmpty())
            <p class="text-center">Belum ada buku favorit.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Gambar</th>
                            <th>Judul Buku</th>
                            <th>Pengarang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($favouriteBooks as $favorite)
                            <tr>
                                <td>
                                    @if($favorite->buku->filepath)
                                        <div class="relative h-24 w-24">
                                            <img
                                                class="h-full w-full object-cover object-center"
                                                src="{{ asset($favorite->buku->filepath) }}"
                                                alt=""
                                                style="padding-right: 20px;"
                                            />
                                        </div>
                                    @endif
                                </td>    
                                <td>{{ $favorite->buku->judul }}</td>
                                <td>{{ $favorite->buku->penulis }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        <script src="{{ asset('dist/js/lightbox-plus-jquery.min.js') }}"></script>
    </body>
</x-app-layout>
