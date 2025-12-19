@extends('layout.app')

@section('content')
<div class="pc-container">
  <div class="pc-content">

    <div class="row mb-3">
      <div class="col">
        <h3 class="mb-1">Tambah User Staf Helpdesk</h3>
        <p class="text-muted mb-0">Buat akun staf baru yang akan menangani tiket helpdesk.</p>
      </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="card">
      <div class="card-body">
        <form action="{{ route('admin.staff.store') }}" method="POST">
          @include('admin.staff.form')
        </form>
      </div>
    </div>

  </div>
</div>
@endsection


