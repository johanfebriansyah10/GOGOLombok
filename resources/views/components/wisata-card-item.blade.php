<div class="row-items-container">
    @if ($wisata && $wisata->image)
        <img src="{{ $wisata->image_url }}" alt="{{ $wisataName }}" class="image-thumbnail">
    @else
        <div class="image-placeholder">
            <span class="text-gray-600">📷</span>
        </div>
    @endif
    <div>
        <p class="font-medium text-gray-900">{{ $wisataName }}</p>
        @if ($wisata)
            <p class="text-metadata">{{ $wisata->location }}</p>
        @endif
    </div>
</div>
