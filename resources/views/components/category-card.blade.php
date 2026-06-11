@props(['image', 'category', 'icon', 'description'])

<a href="" class="category-card">
    <img src="{{ $image }}" alt="{{ $category }}" class="category-card-img">
    <div class="category-card-overlay"></div>
    <div class="category-card-badge">
        <span class="category-card-badge-text">{{ $category }}</span>
    </div>

    <div class="category-card-content">
        <h3 class="category-card-title">
            <i class="fa-solid {{ $icon }}" style="color: rgb(99, 230, 190);"></i> {{ $category }}
        </h3>
        <p class="category-card-description">{{ $description }}</p>
    </div>
</a>
