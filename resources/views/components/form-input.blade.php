<div>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <div class="form-input-group">
        @if($prefix)
            <span class="form-currency-prefix">{{ $prefix }}</span>
        @endif
        @if($type === 'select')
            <select
                id="{{ $name }}"
                name="{{ $name }}"
                class="form-input @if($prefix) form-input-pl @endif"
            >
                {{ $slot }}
            </select>
        @elseif($type === 'textarea')
            <textarea
                id="{{ $name }}"
                name="{{ $name }}"
                class="form-input @if($prefix) form-input-pl @endif"
                placeholder="{{ $placeholder ?? '' }}"
                {{ $attributes->except(['class']) }}
            >{{ $value ?? '' }}</textarea>
        @else
            <input
                type="{{ $type }}"
                id="{{ $name }}"
                name="{{ $name }}"
                class="form-input @if($prefix) form-input-pl @endif"
                placeholder="{{ $placeholder ?? '' }}"
                value="{{ $value ?? '' }}"
                {{ $attributes->except(['class']) }}
            />
        @endif
        @if($suffix)
            <span class="form-input-suffix">{{ $suffix }}</span>
        @endif
    </div>
    @if($helper)
        <p class="form-helper">{{ $helper }}</p>
    @endif
</div>
