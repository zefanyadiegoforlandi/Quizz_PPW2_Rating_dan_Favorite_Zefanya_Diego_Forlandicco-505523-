<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use App\Models\Gallery;
use Intervention\Image\Facades\Image;

class BukuController extends Controller
{
    public function index()
    {
        $batas = 5;
        $jumlah_buku = Buku::count();
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($data_buku->currentPage() - 1);
        foreach ($data_buku as $buku) {
            $jumlah_rating = $buku->rating_1 + $buku->rating_2 + $buku->rating_3 + $buku->rating_4 + $buku->rating_5;
            $avg_rating = ($jumlah_rating > 0) ? ($buku->rating_1 + $buku->rating_2 * 2 + $buku->rating_3 * 3 + $buku->rating_4 * 4 + $buku->rating_5 * 5) / $jumlah_rating : 0;
            $buku->avg_rating = number_format($avg_rating, 2);
        }
        $total_harga = Buku::sum('harga');
        return view('/dashboard', compact('data_buku', 'no', 'total_harga', 'jumlah_buku', 'avg_rating'));
    }

        public function rating_update(Request $request, string $id)
        {
            // Ambil nilai rating dari input
            $selectedRating = $request->input('rating', 0);
        
            // Temukan objek buku berdasarkan ID
            $buku = Buku::find($id);
        
            // Validasi input rating
            $request->validate([
                'rating' => 'numeric|min:1|max:5',
            ]);
          
            // Pastikan objek buku ditemukan sebelum mencoba memperbarui rating
            if (!$buku) {
                return redirect('/buku')->with('pesan', 'Buku tidak ditemukan');
            }
        
            // Perbarui kolom-kolom rating berdasarkan rating yang dipilih
            $buku->update([
                'rating_1' => ($selectedRating == 1) ? $buku->rating_1 + 1 : $buku->rating_1,
                'rating_2' => ($selectedRating == 2) ? $buku->rating_2 + 1 : $buku->rating_2,
                'rating_3' => ($selectedRating == 3) ? $buku->rating_3 + 1 : $buku->rating_3,
                'rating_4' => ($selectedRating == 4) ? $buku->rating_4 + 1 : $buku->rating_4,
                'rating_5' => ($selectedRating == 5) ? $buku->rating_5 + 1 : $buku->rating_5,
            ]);
        
            // Buat array data rating untuk digunakan setelah perbaruan
            $bukuData = [
                'rating_1' => $buku->rating_1,
                'rating_2' => $buku->rating_2,
                'rating_3' => $buku->rating_3,
                'rating_4' => $buku->rating_4,
                'rating_5' => $buku->rating_5
            ];
        
            // Redirect ke halaman buku dengan pesan sukses
            return redirect('/buku')->with('pesan', 'Rating Berhasil di Simpan');
        }
        public function rating($id) {
            $buku = Buku::find($id);
            return view('buku.rating', compact('buku'));
        }
        
    

        public function list_buku(){
            $batas = 5;
            $data_buku = Buku::orderBy('id','desc')->paginate($batas);
            $no = $batas * ($data_buku->currentPage()-1);
            return view('/buku/list_buku', compact('data_buku'));
        }

        public function detail_buku(){
            $batas = 5;
            $data_buku = Buku::orderBy('id','desc')->paginate($batas);
            $no = $batas * ($data_buku->currentPage()-1);
            return view('/buku/detail_buku', compact('data_buku'));
        }



        public function create(){
            $buku = new Buku; 
            return view('buku.create', compact('buku'));
        }
        public function store(Request $request) {
            $request->validate([
                'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
        
            // Simpan data buku
            $bukuData = [
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'harga' => $request->harga,
                'tgl_terbit' => $request->tgl_terbit,
                'rating_1'=> $rating1,
                'rating_2'=>$rating_2,
                'rating_3'=> $rating_3,
                'rating_4' => $rating_4,
                'rating_5' => $rating_5
            ];

        
            // Jika terdapat file thumbnail, proses dan simpan thumbnail
            if ($request->hasFile('thumbnail')) {
                $thumbnailFile = $request->file('thumbnail');
                $thumbnailFileName = time() . '_' . $thumbnailFile->getClientOriginalName();
                $thumbnailFilePath = $thumbnailFile->storeAs('uploads', $thumbnailFileName, 'public');
        
                Image::make(storage_path() . '/app/public/uploads/' . $thumbnailFileName)
                    ->fit(240, 320)
                    ->save();
        
                $bukuData['filename'] = $thumbnailFileName;
                $bukuData['filepath'] = '/storage/' . $thumbnailFilePath;
            }
        
            $buku = Buku::create($bukuData);
        
            // Proses dan simpan galeri
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $key => $file) {
                    $galleryFileName = time() . '_' . $file->getClientOriginalName();
                    $galleryFilePath = $file->storeAs('uploads', $galleryFileName, 'public');
        
                    Gallery::create([
                        'nama_galeri' => $galleryFileName,
                        'path' => '/storage/' . $galleryFilePath,
                        'foto' => $galleryFileName,
                        'buku_id' => $buku->id
                    ]);
                }
            }
        
            return redirect('/buku')->with('pesan', 'Buku baru berhasil ditambahkan');
        }
        
        //destroy
        public function destroy($id){
            $buku = Buku::find($id);
            $buku->delete();
            return redirect('/buku');
        }
        public function edit($id) {
            $buku = Buku::find($id);
            return view('buku.edit', compact('buku'));
        }

        public function update(Request $request, string $id ) {
            $selectedRating = $request->input('rating', 0);

            $buku = Buku::find($id);
            $request->validate([
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rating' => 'numeric|min:1|max:5', // Satu kolom untuk nilai peringkat


            ]);
        
            if ($request->hasFile('thumbnail')) {
                $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
                $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');
        
                Image::make(storage_path().'/app/public/uploads/'.$fileName)
                    ->fit(240,320)
                    ->save();   
        
                $buku->update([
                    'judul'     => $request->judul,
                    'penulis'   => $request->penulis,
                    'harga'     => $request->harga,
                    'tgl_terbit'=> $request->tgl_terbit,
                    'filename'  => $fileName,
                    'filepath'  => '/storage/' . $filePath,
                    // Menambahkan nilai +1 untuk setiap kolom rating
                    'rating_1'   => ($selectedRating == 1) ? $buku->rating_1 + 1 : $buku->rating_1,
                    'rating_2'   => ($selectedRating == 2) ? $buku->rating_2 + 1 : $buku->rating_2,
                    'rating_3'   => ($selectedRating == 3) ? $buku->rating_3 + 1 : $buku->rating_3,
                    'rating_4'   => ($selectedRating == 4) ? $buku->rating_4 + 1 : $buku->rating_4,
                    'rating_5'   => ($selectedRating == 5) ? $buku->rating_5 + 1 : $buku->rating_5,
                ]);
            } else {

                // Jika tidak ada thumbnail diunggah, tetap lakukan update data buku tanpa mengubah thumbnail.
                $buku->update([
                    'judul'     => $request->judul,
                    'penulis'   => $request->penulis,
                    'harga'     => $request->harga,
                    'tgl_terbit' => $request->tgl_terbit,
                    // Menambahkan nilai +1 untuk setiap kolom rating
                    'rating_1'   => ($selectedRating == 1) ? $buku->rating_1 + 1 : $buku->rating_1,
                    'rating_2'   => ($selectedRating == 2) ? $buku->rating_2 + 1 : $buku->rating_2,
                    'rating_3'   => ($selectedRating == 3) ? $buku->rating_3 + 1 : $buku->rating_3,
                    'rating_4'   => ($selectedRating == 4) ? $buku->rating_4 + 1 : $buku->rating_4,
                    'rating_5'   => ($selectedRating == 5) ? $buku->rating_5 + 1 : $buku->rating_5,

                ]);
            }
        
            if ($request->file('gallery')) {
                foreach($request->file('gallery') as $key => $file) {
                    $fileName = time().'_'.$file->getClientOriginalName();
                    $filePath = $file->storeAs('uploads', $fileName, 'public');
        
                    $gallery = Gallery::create([
                        'nama_galeri'   => $fileName,
                        'path'          => '/storage/' . $filePath,
                        'foto'          => $fileName,
                        'buku_id'       => $id
                    ]);
                }
            }
                    
        
            return redirect('/buku')->with('pesan', 'Perubahan Data Buku Berhasil di Simpan');
        }


        public function _construct(){
            $this->middleware('admin');
        }

        public function search(Request $request) {
            $batas = 5;
            $cari = $request->kata; 
            $data_buku = Buku::where('judul', 'like', '%' . $cari . '%')
                ->orWhere('penulis', 'like', '%' . $cari . '%')
                ->paginate($batas);
            $no = $batas * ($data_buku->currentPage() - 1);
            $total_harga = DB::table('buku')->sum('harga');
            $jumlah_buku = $data_buku->count();
        
            return view('buku.search', compact('data_buku', 'total_harga', 'no', 'jumlah_buku', 'cari'));
        }
        
        public function photos(){
            return $this->hasMany('App\Buku', 'id_buku', 'id');
        }

        public function galbuku($title)
        {
            $bukus = Buku::where('buku_seo', $title)->first();
            $galeries = $bukus->galleries()->orderBy('id', 'desc')->paginate(5);
            return view ('buku.detail_buku', compact('bukus', 'galeries'));
        }


        public function add_favourite(Buku $buku)
        {
            $user = Auth::user();

            if (!$user->favourites) {
                $user->favourites = [];
            }

            if (!in_array($buku->id, $user->favourites)) {
                $user->favourites[] = $buku->id;
                $user->save();
            }

            return redirect()->back()->with('success', 'Buku ditambahkan ke daftar favorit.');
        }

        public function my_favourite()
        {
            $user = Auth::user();
            $favouriteBooks = Buku::whereIn('id', $user->favourites ?? [])->get(['judul', 'pengarang']);

            return view('buku.myfavourite', compact('favouriteBooks'));
        }

    }