@props(['type' => 'success', 'message', 'dismissible' => true])

@php
    $alertClasses = [
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info'
    ];
    
    $iconClasses = [
        'success' => 'bi-check-circle-fill',
        'error' => 'bi-exclamation-triangle-fill',
        'warning' => 'bi-exclamation-triangle-fill',
        'info' => 'bi-info-circle-fill'
    ];
    
    $alertClass = $alertClasses[$type] ?? 'alert-info';
    $iconClass = $iconClasses[$type] ?? 'bi-info-circle-fill';
@endphp

<div class="alert {{ $alertClass }} alert-dismissible fade show shadow-sm border-0" role="alert" 
     x-data="{ show: true }" 
     x-show="show" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-95"
     x-transition:enter-end="opacity-100 transform scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-95">
    
    <div class="d-flex align-items-center">
        <i class="{{ $iconClass }} me-2 fs-5"></i>
        <span class="fw-medium">{{ $message }}</span>
    </div>
    
    @if($dismissible)
        <button type="button" 
                class="btn-close" 
                data-bs-dismiss="alert" 
                aria-label="Close"
                @click="show = false">
        </button>
    @endif
</div>

<style>
.alert {
    border-radius: 0.75rem;
    border-left: 4px solid;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
    line-height: 1.5;
}

.alert-success {
    background-color: #d1f2eb;
    border-left-color: #10b981;
    color: #065f46;
}

.alert-danger {
    background-color: #fde8e8;
    border-left-color: #ef4444;
    color: #7f1d1d;
}

.alert-warning {
    background-color: #fef3c7;
    border-left-color: #f59e0b;
    color: #92400e;
}

.alert-info {
    background-color: #dbeafe;
    border-left-color: #3b82f6;
    color: #1e40af;
}

.alert .btn-close {
    padding: 0.5rem;
    margin: -0.5rem -0.5rem -0.5rem auto;
    background-size: 1.25em;
    opacity: 0.7;
}

.alert .btn-close:hover {
    opacity: 1;
}

.alert i {
    flex-shrink: 0;
}

.alert .fw-medium {
    font-weight: 500;
}
</style>

