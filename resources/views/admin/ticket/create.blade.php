@extends('layout.app')

@section('content')
<div class="pc-container">
  <div class="pc-content">

    <div class="row mb-3">
      <div class="col">
        <h3 class="mb-1">Buat Tiket Helpdesk Baru</h3>
        <p class="text-muted mb-0">Digunakan Admin untuk mencatat laporan gangguan yang disampaikan mahasiswa.</p>
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
        <form action="{{ route('admin.ticket.store') }}" method="POST">
          @include('admin.ticket.form')
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const loader = document.querySelector('.loader-bg');
    if (loader) {
      loader.style.display = 'none';
    }
  });
</script>
@endpush

