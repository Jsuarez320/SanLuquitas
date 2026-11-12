@if (session('exito'))
    <div role="status" class="mb-6 flex gap-3 rounded-2xl bg-green-50 p-4 text-green-900 ring-1 ring-green-200">
        <x-icon name="check-circle" class="h-6 w-6 shrink-0" />
        <p>{{ session('exito') }}</p>
    </div>
@endif
@if (session('error'))
    <div role="alert" class="mb-6 rounded-2xl bg-red-50 p-4 text-red-900 ring-1 ring-red-200">{{ session('error') }}</div>
@endif
