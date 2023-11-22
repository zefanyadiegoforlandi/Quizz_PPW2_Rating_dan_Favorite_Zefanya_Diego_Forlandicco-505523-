<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('LIST BUKU') }}
        </h2>
    </x-slot>
    
    <h1 class="text-3xl font-semibold text-center mb-6 bg-gray-200 py-2">DAFTAR BUKU</h1>
    <div class="mt-4 mb-4 p-4 bg-white shadow-md flex items-center justify-between">
        <form action="{{ route('buku.search') }}" method="GET" class="flex items-center">
            @csrf
            <input type="text" name="kata" class="border rounded-l py-2 px-3 w-full" placeholder="Cari judul atau penulis...">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white rounded-r px-4 py-2">Cari</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Foto</th>
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
                    @if($b->filepath)
                        <div class="relative h-24 w-24">
                            <img
                                class="h-full w-full object-cover object-center"
                                src="{{ asset($b->filepath) }}"
                                alt=""
                                style="padding-right: 20px;"
                            />
                        </div>
                    @endif
                    </td>
                    <td>{{ $b->judul }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</x-app-layout>
