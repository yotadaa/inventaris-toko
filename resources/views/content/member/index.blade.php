@if (Auth::check())
    @if (Auth::user()->role != 'super')
        <script>
            window.location.href = '/'
        </script>
    @endif
@else
    <script>
        window.location.href = '/session'
    </script>
@endif

@extends('layout.index')
@section('title')
    Member - PlinPlan
@endsection

@section('misc')
    @include('no-reload.head')
@endsection
@section('body')

    @include('no-reload.body-up')
    <script>
        // document.querySelector('#components-nav').classList.remove('collapse');
        // document.querySelector('#components-nav').classList.add('show');
        document.querySelector('#member').classList.remove('collapsed');
        var cats = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];
    </script>
    <section class="section">

        <div class="card">
            <div class="card-body overflow-auto">
                <div class="card-title">
                    <nav class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Member</li>
                        </ol>
                    </nav>
                    Daftar Member
                    <div class="text-muted small" style="font-size:;">
                    </div>
                </div>
                <section class="section">
                    <div class="d-block d-md-flex" style='gap: 10px'>
                        <div class='d-flex' style="gap: 10px; margin-bottom: 10px;">
                            <a href='{{ route('tambah-member') }}'
                                style="display: flex; align-items: center; gap: 5px;"class="btn btn-primary">
                                <strong><i class="bi bi-box-arrow-in-down"></i></strong>
                                Tambah Member
                            </a>
                        </div>
                </section>
                <div class="border-bottom"></div>
                <section class="section overflow-auto" style='overflow-x: scroll'>

                    @if ($members->count() == 0)
                        <div class="text-center mt-3">
                            Belum ada daftar member di tokomu
                        </div>
                    @else
                        <table id='items-container' class="table datatable table-borderless table-striped table-hover"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ $member->role }}</td>
                                        <td>
                                            <div class="d-block d-md-flex " style="gap: 5px; justify-content: center;">
                                                <button class="btn shadow btn-secondary" style="scale: 0.9"><i
                                                        class="bi bi-info-circle"></i></button>
                                                <button class="btn shadow btn-warning" style="scale: 0.9"><i
                                                        class="bi bi-pencil-square"></i></button>
                                                <button class="btn shadow btn-danger"
                                                    ondblclick="deleteMember('{{ $member->email }}', '{{ $member->root }}')"
                                                    style="scale: 0.9"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </section>
            </div>
        </div>
    </section>
    <script>
        function deleteMember(email, root) {
            $.ajax({
                url: '/member/delete',
                method: 'POST',
                data: {
                    email: email,
                    root: root
                },
                success: (res) => {
                    if (res.success) {
                        window.location.reload();
                    }
                },
                error: (err) => {

                    console.error(err)
                }
            })
        }
    </script>
@endsection
