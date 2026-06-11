<div class="alert-warning">
    <span class="text-xl">{{ $icon ?? '⚠️' }}</span>
    <div>
        <p class="font-semibold">{{ $title }}</p>
        <p class="text-sm">{{ $message }}</p>
        @if($subtext)
            <p class="text-xs mt-2 text-yellow-600">{{ $subtext }}</p>
        @endif
    </div>
</div>
