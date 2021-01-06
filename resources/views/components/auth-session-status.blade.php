@props(['status'])

@if ($status)
    {{-- <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        {{ $status }}
    </div> --}}
    <p {{ $attributes->merge(['class' => 'flex items-center mb-4 bg-green-100 border border-green-200 px-5 py-4 rounded-lg text-green-700']) }}>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-shrink-0 w-6 h-6">
            <circle cx="12" cy="12" r="10" class="fill-current text-green-300"/>
            <path class="fill-current text-green-500" d="M10 14.59l6.3-6.3a1 1 0 0 1 1.4 1.42l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 0 1 1.4-1.42l2.3 2.3z"/>
        </svg>

        <span class="ml-3">{{ $status }}</span>
    </p>
@endif
