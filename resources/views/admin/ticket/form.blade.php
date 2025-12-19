@csrf

<div class="row">
  <div class="col-md-6 mb-3">
    <label class="form-label">NIM Mahasiswa</label>
    <input type="text" name="nim" class="form-control" value="{{ old('nim', isset($ticket) ? $ticket->nim : '') }}" placeholder="Contoh: 123456789">
  </div>
  <div class="col-md-6 mb-3">
    <label class="form-label">Nama Mahasiswa</label>
    <input type="text" name="nama_mahasiswa" class="form-control" value="{{ old('nama_mahasiswa', isset($ticket) ? $ticket->nama_mahasiswa : '') }}" placeholder="Nama lengkap">
  </div>
</div>

<div class="mb-3">
  <label class="form-label">Judul Permasalahan</label>
  <input type="text" name="judul" class="form-control" value="{{ old('judul', isset($ticket) ? $ticket->judul : '') }}" required placeholder="Contoh: Lupa Password SIAK">
</div>

<div class="row">
  <div class="col-md-6 mb-3">
    <label class="form-label">Kategori</label>
    <select name="kategori" class="form-select" required>
      @php $currentKategori = old('kategori', isset($ticket) ? $ticket->kategori : ''); @endphp
      <option value="" disabled {{ $currentKategori === '' ? 'selected' : '' }}>-- Pilih Kategori --</option>
      @foreach($kategoriList as $key => $label)
        <option value="{{ $key }}" {{ $currentKategori === $key ? 'selected' : '' }}>
          {{ $label }}
        </option>
      @endforeach
    </select>
  </div>
  <div class="col-md-6 mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
      @php $currentStatus = old('status', isset($ticket) ? $ticket->status : \App\Models\Ticket::STATUS_BARU); @endphp
      @foreach($statusList as $key => $label)
        <option value="{{ $key }}" {{ $currentStatus === $key ? 'selected' : '' }}>
          {{ $label }}
        </option>
      @endforeach
    </select>
  </div>
</div>

<div class="mb-3">
  <label class="form-label">Deskripsi / Detail Permasalahan</label>
  <textarea name="deskripsi" class="form-control" rows="4" placeholder="Ceritakan kronologi singkat masalah yang terjadi...">{{ old('deskripsi', isset($ticket) ? $ticket->deskripsi : '') }}</textarea>
</div>

<div class="mb-3">
  <label class="form-label">Staf Helpdesk Penanggung Jawab</label>
  <select name="assigned_to" class="form-select">
    <option value="">-- Belum ditugaskan --</option>
    @foreach($staffList as $staff)
      <option value="{{ $staff->id }}" {{ old('assigned_to', isset($ticket) ? $ticket->assigned_to : null) == $staff->id ? 'selected' : '' }}>
        {{ $staff->name }} ({{ $staff->email }})
      </option>
    @endforeach
  </select>
</div>

<div class="d-flex justify-content-between mt-3">
  <a href="{{ route('admin.ticket.index') }}" class="btn btn-light">
    <i class="ti ti-arrow-left me-1"></i> Kembali
  </a>
  <button type="submit" class="btn btn-primary">
    <i class="ti ti-device-floppy me-1"></i> Simpan
  </button>
</div>


