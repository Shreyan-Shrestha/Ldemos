@if(session('success'))
    <div class="alert alert-dismissible d-flex align-items-center gap-2 border-0 mb-4"
        style="background:#f0fdf4; color:#166534; border-radius:10px; font-size:0.875rem;">
        <i class="bi bi-check-circle-fill" style="font-size:1rem;"></i>
        {{ session('success') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
            style="font-size:0.7rem; filter:invert(27%) sepia(51%) saturate(400%) hue-rotate(95deg);"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-dismissible d-flex align-items-center gap-2 border-0 mb-4"
        style="background:#fef2f2; color:#991b1b; border-radius:10px; font-size:0.875rem;">
        <i class="bi bi-exclamation-circle-fill" style="font-size:1rem;"></i>
        {{ session('error') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
            style="font-size:0.7rem; filter:invert(19%) sepia(90%) saturate(600%) hue-rotate(340deg);"></button>
    </div>
    @endif