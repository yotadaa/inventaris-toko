@extends('layout.index')
@section('title')
    About | PlinPlan
@endsection
@section('body')
    <script>
        document.querySelector('#about').classList.remove('collapsed');
        var cats = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];
    </script>
    <section class="section">
        <div class="card">
            <div class="card-body overflow-auto">
                <div class="card-title">
                    <nav class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item active">About</li>
                        </ol>
                    </nav>
                    Tambah Member
                    <div class="text-muted small" style="font-size:;">
                    </div>
                </div>
                <div class="container">
                    Selamat datang di PlinPlan! <br> <br>
                    PlinPlan Shop Management adalah aplikasi management toko berbasis web yang dikembangkan oleh sebuah tim.
                    <br><br>
                    PlinPlan dipimpin oleh Mukhtada. Tim kami terdiri dari individu yang berbakat dan berdedikasi, termasuk
                    Devi dan Shakila, yang senantiasa siap membantu dalam setiap langkah Anda di PlinPlan. <br><br>
                    Kami berkomitmen untuk memberikan solusi terbaik dalam management toko agar bisnis Anda dapat tumbuh dan
                    berkembang. Kami berusaha untuk memberikan pengalaman yang tak tertandingi. <br><br>
                    Terima kasih telah memilih PlinPlan. Kami berharap dapat terus melayani Anda dengan baik. Semoga dengan
                    aplikasi ini kamu dapat mengolah tokomu dengan lebih mudah!<br><br>
                    Selamat menggunakan PlinPlan!
                </div>
            </div>
        </div>
    </section>
@endsection
