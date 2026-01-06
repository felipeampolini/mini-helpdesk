<div {{ $attributes->merge([
    'class' => 'rounded-lg p-4 shadow flex flex-row items-stretch gap-4'
]) }}>
    <div class="flex flex-col flex-1 justify-center ml-4">
        <div class="text-sm text-gray-500">
            {{ $title }}
        </div>

        <div class="mt-2 text-3xl font-semibold">
            {{ $value }}
        </div>
    </div>

    @if($slot)
        <div class="flex flex-col justify-center gap-2">
            {{ $slot }}
        </div>
    @endif
</div>