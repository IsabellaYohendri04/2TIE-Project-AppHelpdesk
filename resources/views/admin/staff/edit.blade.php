@extends('layout.app')

@section('content')
<div class="pc-container">
  <div class="pc-content">

    <div class="row mb-3">
      <div class="col">
        <h3 class="mb-1">Edit User Staf Helpdesk</h3>
        <p class="text-muted mb-0">Perbarui data akun staf yang menangani tiket helpdesk.</p>
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
        <form action="{{ route('admin.staff.update', $staff) }}" method="POST">
          @method('PUT')
          @include('admin.staff.form', ['staff' => $staff])
        </form>
      </div>
    </div>

  </div>
</div>
@endsection


