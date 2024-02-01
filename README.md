## Project Study Club

Repository ini berisi file project Study Club Sistem Informasi Unja
Batch 3

## Anggota Kelompok
- **[M. Hazron Redian (Mentor)](https://github.com/Hazron).**
- **[Mukhtada Billah Nasution](https://github.com/yotadaa).**
- **[Devi Listiani Safitri](https://github.com/devilistiani).**
- **[Shakila Rama Wulandari](https://github.com/Shakila10).**


## Shop Manajemen
- **Mengolah Item**
- **Menambah Item**
- **Mengubah Item**
- **Menghapus Item**
- **Mencatat transaksi Item**
- **Login dan Registrasi**


## Todo

**Kelola**
- [x] Edit item
- [x] Menu Catat Transaksi
- [ ] Catat Perbelanjaan
- [ ] Riwayata Perbelanjaan
- [x] Riwayat Transaksi

**Analisis </h4>**
- [x] chart transaksi

**Member**
- [ ] Tambah
- [ ] Ubah
- [ ] Hapus

Fitur hapus/ubah transaksi dan perbelanjaan postponed.

## Progress

- **Users**
- [x] Membuat tabel
- [x] Register, Login, dan Logout
- [x] Mengubah dan menghapus foto profil

<dl>
    <dt><h3>Authentication</h3></dt>
    <dd>
        <dl>
            <dt>Login</dt>
            <dd>
                <ul>
                    <li>Cek apakah email sudah terdaftar</li>
                    <li>Validasi password</li>
                </ul>
            </dd>
            <dt>Register</dt>
            <dd>
                <ul>
                    <li>Cek apakah email sudah terdaftar</li>
                    <li>Konfirmasi password</li>
                </ul>
            </dd>
            <dt>Lupa Password</dt>
            <dd>
                <ul>
                    <li>Validasi password</li>
                    <li>Cek apakah password masih sama</li>
                    <li>Konfirmasi password</li>
                </ul>
            </dd>
        </dl>
    </dd>
    <dt><h3>Member dan Role</h3></dt>
    <dd>
        <dl>
            <dt><li>Super [x]</li></dt>
            <dd>Super user adalah user yang bisa mengedit item di database, termasuk hal hal yang bisa dilakukan normal user</dd>
            <dt><li>Normal [x]</li></dt>
            <dd>Normal user adalah user yang hanya dapat mencatat transaksi, seperti membuat kluster transaksi dan menambahkan detail pada transaksi tersebut</dd>
        </dl>
    </dd>
    <dt><h3>Item</h3></dt>
    <dd>
        <dl>
            <dt><li>Attribut</li></dt>
            <dd>
                <ul>
                    <li>Gambar</li>
                    <li>Nama</li>
                    <li>Deskripsi</li>
                    <li>Kategori [Rokok, Makanan, Minuman, Lainnya]</li>
                    <li>Stok</li>
                    <li>Harga Awal</li>
                    <li>Harga Jual</li>
                </ul>
            </dd>
            <dt>Progress</dt>
            <dd>
                <ul>
                    <li>Layout tampilkan item</li>
                    <li>Menampilkan seluruh items</li>
                    <li>Modal untuk detail item</li>
                    <li>Tambah Item</li>
                    <li>Hapus Item</li>
                    <li>Detail Item</li>
                </ul>
            </dd>
        </dl>
    </dd>
    <dt><h3>Transaksi &check;</h3></dt>
    <dd>
        Table yang mencatat seluruh transaksi yang terjadi.
        <ul>
            <li>Lakukan transaksi satuan (1 item per transaksi)</li>
            <li>Buat kluster transaksi (banyak item per transaksi)</li>
        </ul>
        Karekteristik:
        <ul>
            <li>Transaksi (Penjualan dan Belanja) tidak bisa dihapus dan diubah</li>
        </ul>
    </dd>
</dl>

## Guide
```
php --ini
lihat pada bagian Loaded Configuration File, di situ terdapat letak file php.ini
buka file tersebut
cari ;extension=gd
hapus ;
save
```

```
cd project-folder
```

```
git clone https://github.com/yotadaa/plin-plan.git
```

```
composer install
```

```
php artisan migrate
```

```
php artisan serve
```

## Login github to your system
```
git config --global user.name "YourGitHubUsername"
```

```
git config --global user.email "your.email@example.com"
```
