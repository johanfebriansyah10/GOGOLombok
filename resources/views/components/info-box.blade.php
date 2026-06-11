@props(['icon', 'title', 'subtitle', 'description'])

<div class="info-box">
    <div class="info-box-header">
        <div class="info-box-icon">
            <i class="fa-solid {{ $icon }} info-box-icon-inner"></i>
        </div>
        <div>
            <h4 class="info-box-title">{{ $title }}</h4>
            <p class="info-box-subtitle">{{ $subtitle }}</p>
        </div>
    </div>
    <p class="info-box-text">{{ $description }}</p>
</div>
