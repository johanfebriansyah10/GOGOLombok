@props(['breadcrumbs' => []])

<nav class="mb-6" aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-2 text-sm">
        <!-- Home -->
        <li>
            <a href="{{ route('dashboard') }}" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 transition font-medium">
                🏠 Beranda
            </a>
        </li>

        <!-- Dynamic breadcrumbs -->
        @foreach ($breadcrumbs as $breadcrumb)
            <li class="text-gray-400 dark:text-gray-600">
                <span>/</span>
            </li>
            <li>
                @if (isset($breadcrumb['url']))
                    <a href="{{ $breadcrumb['url'] }}" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 transition font-medium">
                        {{ $breadcrumb['label'] }}
                    </a>
                @else
                    <span class="text-gray-600 dark:text-gray-400 font-medium">
                        {{ $breadcrumb['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
