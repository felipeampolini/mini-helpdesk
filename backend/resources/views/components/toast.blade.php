@props(['position' => 'top-right', 'duration' => 8000])

<div
    x-data="{ showToast: false, toastMessage: '', toastType: '', duration: {{ $duration }} }"
    x-on:notify.window="
        let data = Array.isArray($event.detail) ? $event.detail[0] : $event.detail;
        toastMessage = data.message;
        toastType = data.type || 'success';
        showToast = true;
        setTimeout(() => showToast = false, duration)
    "
    x-show="showToast"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    class="fixed z-[100] px-4 py-2 rounded shadow"
    :class="{
        'bg-green-500 text-white': toastType === 'success',
        'bg-amber-500 text-white': toastType === 'warning',
        'bg-red-500 text-white': toastType === 'danger'
    }"
    style="{{ match($position) {
        'bottom-right' => 'bottom:1rem; right:1rem;',
        'bottom-left' => 'bottom:1rem; left:1rem;',
        'top-right' => 'top:1rem; right:1rem;',
        'top-left' => 'top:1rem; left:1rem;',
        default => 'bottom:1rem; right:1rem;'
    } }}"
>
    <div class="flex items-center">
        <span x-html="toastMessage"></span>
        <button @click="showToast = false" class="ml-4 font-bold hover:opacity-70">&times;</button>
    </div>
</div>
