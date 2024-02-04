@extends('layout.index')
@section('title')
    About | PlinPlan
@endsection
@section('body')
    <script>
        document.querySelector('#components-nav').classList.remove('collapse');
        document.querySelector('#components-nav').classList.add('show');
        document.querySelector('#about').classList.remove('collapsed');
        var cats = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];
    </script>
    <section class="section">
        Tulis di sini
    </section>
@endsection
