@props(['icon', 'title', 'description'])

<div class="feature-card">
    <div class="feature-card-icon-box">
        <i class="fa-solid {{ $icon }} feature-card-icon"></i>
    </div>
    <h3 class="feature-card-title">{{ $title }}</h3>
    <p class="feature-card-text">{{ $description }}</p>
</div>
