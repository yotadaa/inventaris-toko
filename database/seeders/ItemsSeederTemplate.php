<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Items;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $daftarItem = [
            [
                'foto' => '/assets/img/foto_produk', // tambah ekstensinya jga (.png, .jpg, etc..)
                'nama' => 'nama_produk',
                'desk' => 'Deskripsi singkat',
                'kategori' => 3, //0. Makanan, 1. Minuman, 2. Rokok, 3. Lainnya (Kebersihan, Bumbu Masakan, DLL selain 3 kategori sebelumnya)
                'stok' => 24, // stok terserah aja
                'harga_awal' => 400, // untuk harga tolong cari harga sebenarnya ya
                'harga_jual' => 500, // nanti terserah mau dijual berapa
                'email' => 'tes@gmail.com', // emailnya ke sni aja
                'kode' => 0, // untuk kode pake nomor urut aja
            ],
            [
                // tambah item berikutnya di sini, sama seperti struktur sebelumnya
                // hapus aja yang di atas kalo keganggu
                'foto' => '',
                'nama' => '',
                'desk' => '',
                'kategori' => 0,
                'stok' => 0,
                'harga_awal' => 0,
                'harga_jual' => 0,
                'email' => 'tes@gmail.com',
                'kode' => 0
            ],
            [

            ],
        ];
        foreach ($daftarItem as $item) {
            DB::table('items')->insert([
                // kaya gini contohnya
                'foto' => $item['foto'],
                'nama' => $item['nama'],
                'desk' => $item['desk'],
                'kategori' => $item['kategori'],
                'stok' => $item['stok'],
                'harga_awal' => $item['harga_awal'],
                'harga_jual' => $item['harga_jual'],
                'email' => 'tes@gmail.com',
                'kode' => $item['kode'],
            ]);
        }
    }
}
