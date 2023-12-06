<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Rating
        </h2>
    </x-slot>
    @if(count($errors) > 0)
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    @endif 
    <div class="container mx-auto mt-10 max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Rating Buku</h2>
        <form action="{{ route('buku.rating_update', $buku->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
            <label for="rating" class="block text-gray-700 font-bold">Pilih Nilai (1-5)</label>
            <select name="rating" id="rating" class="border border-gray-300 rounded px-3 py-2 w-full">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
           <div class="flex justify-between"> <!-- Menggunakan flex untuk meletakkan tombol "Simpan" dan "Batal" sejajar -->
               <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
               <a href="/dashboard" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Batal</a>
           </div>
            
        </form>
    </div>
   
    

</x-app-layout>    

