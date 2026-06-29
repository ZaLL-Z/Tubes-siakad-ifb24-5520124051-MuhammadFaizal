@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-start gap-3" role="alert">
        <i class="bi bi-check-circle-fill fs-5"></i>
        <div class="flex-grow-1">{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start gap-3" role="alert">
        <i class="bi bi-exclamation-octagon-fill fs-5"></i>
        <div class="flex-grow-1">{{ session('error') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger d-flex align-items-start gap-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
        <div>
            <strong>Periksa kembali data yang dimasukkan:</strong>
            <ul class="mb-0 mt-2 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
