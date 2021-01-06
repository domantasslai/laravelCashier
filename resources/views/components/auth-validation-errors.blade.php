@props(['errors'])

@if ($errors->any())
    {{-- <div {{ $attributes }}>
        <div class="font-medium text-red-600">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div> --}}

    <p class="flex items-center mb-4 bg-red-100 border border-red-200 px-5 py-2 rounded-lg text-red-500">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-shrink-0 w-6 h-6">
            <path class="fill-current text-red-300" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z"/>
            <path class="fill-current text-red-500" d="M12 18a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm1-5.9c-.13 1.2-1.88 1.2-2 0l-.5-5a1 1 0 0 1 1-1.1h1a1 1 0 0 1 1 1.1l-.5 5z"/>
        </svg>
        {{ __('Whoops! Something went wrong.') }}
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        {{-- <span class="ml-3">@{{ errorMessage }}</span> --}}
    </p>
@endif
