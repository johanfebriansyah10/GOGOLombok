<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <?php echo e(__('Katalog Wisata')); ?>

            </h2>
            <div class="flex gap-2">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari wisata..."
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                />
                <select id="categoryFilter" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['breadcrumbs' => [
                ['label' => 'Wisata', 'url' => null]
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Wisata', 'url' => null]
            ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal360d002b1b676b6f84d43220f22129e2)): ?>
<?php $attributes = $__attributesOriginal360d002b1b676b6f84d43220f22129e2; ?>
<?php unset($__attributesOriginal360d002b1b676b6f84d43220f22129e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal360d002b1b676b6f84d43220f22129e2)): ?>
<?php $component = $__componentOriginal360d002b1b676b6f84d43220f22129e2; ?>
<?php unset($__componentOriginal360d002b1b676b6f84d43220f22129e2); ?>
<?php endif; ?>

            

            <!-- Stats Cards -->
            

            <!-- Wisata Grid -->
            <div id="wisataContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $wisatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wisata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('wisata.show', $wisata->id)); ?>" class="group transform transition-all duration-500 hover:z-10" style="animation: fadeInUp 0.5s ease-out; animation-fill-mode: both;" data-category="<?php echo e($wisata->category_id ?? ''); ?>">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl hover:shadow-2xl transition-all duration-500 h-full flex flex-col transform group-hover:scale-105 group-hover:-translate-y-2">
                            <!-- Image Container with Overlay -->
                            <div class="relative overflow-hidden bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 h-64 flex-shrink-0">
                                <?php if($wisata->image_url): ?>
                                    <img
                                        src="<?php echo e($wisata->image_url); ?>"
                                        alt="<?php echo e($wisata->name); ?>"
                                        class="w-full h-full object-cover group-hover:scale-125 transition-transform duration-700 ease-out"
                                    />
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-700">
                                        <div class="text-center">
                                            <p class="text-gray-700 dark:text-gray-300 text-sm">Tidak ada foto</p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Gradient Overlay (Hover Effect) -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                <!-- Rating Badge -->
                                <div class="absolute top-3 right-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-yellow-900 px-4 py-2 rounded-full text-sm font-bold shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                    <?php echo e(number_format($wisata->actual_rating ?? 0, 1)); ?>/5.0
                                </div>

                                <!-- Category Badge -->
                                <?php if($wisata->category): ?>
                                    <div class="absolute top-3 left-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg uppercase tracking-wider">
                                        <?php echo e($wisata->category->name); ?>

                                    </div>
                                <?php endif; ?>

                                <!-- View Count Badge (Bottom Right, on hover) -->
                                <div class="absolute bottom-3 right-3 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm text-gray-900 dark:text-white px-3 py-1 rounded-full text-xs font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Detail
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 flex flex-col flex-grow">
                                <!-- Name -->
                                <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2 line-clamp-2 group-hover:text-green-600 dark:group-hover:text-green-400 transition duration-300">
                                    <?php echo e($wisata->name); ?>

                                </h3>

                                <!-- Location -->
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    <p class="line-clamp-2"><?php echo e($wisata->location); ?></p>
                                </div>

                                <!-- Info Grid (Enhanced) -->
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <!-- Distance -->
                                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 p-3 rounded-lg transform group-hover:scale-110 transition-transform duration-300">
                                        <p class="text-xs text-gray-600 dark:text-gray-300 font-semibold uppercase tracking-wider">Jarak</p>
                                        <p class="text-gray-900 dark:text-gray-100 font-bold mt-1"><?php echo e(number_format($wisata->distance, 1)); ?> <span class="text-xs">km</span></p>
                                    </div>

                                    <!-- Price -->
                                    <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 p-3 rounded-lg transform group-hover:scale-110 transition-transform duration-300">
                                        <p class="text-xs text-gray-600 dark:text-gray-300 font-semibold uppercase tracking-wider">Tiket</p>
                                        <p class="text-gray-900 dark:text-gray-100 font-bold mt-1">
                                            <span class="text-xs">Rp</span> <?php echo e(number_format($wisata->ticket_price / 1000, 0)); ?> <span class="text-xs">rb</span>
                                        </p>
                                    </div>

                                    <!-- Facilities -->
                                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 p-3 rounded-lg transform group-hover:scale-110 transition-transform duration-300">
                                        <p class="text-xs text-gray-600 dark:text-gray-300 font-semibold uppercase tracking-wider">Fasilitas</p>
                                        <p class="text-gray-900 dark:text-gray-100 font-bold mt-1"><?php echo e($wisata->facilities_count ?? 0); ?></p>
                                    </div>

                                    <!-- Overall Score -->
                                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 p-3 rounded-lg transform group-hover:scale-110 transition-transform duration-300">
                                        <p class="text-xs text-gray-600 dark:text-gray-300 font-semibold uppercase tracking-wider">Skor</p>
                                        <p class="text-gray-900 dark:text-gray-100 font-bold mt-1"><?php echo e(number_format($wisata->actual_rating ?? 0, 1)); ?>/5</p>
                                    </div>
                                </div>

                                <!-- Description Preview with Animation -->
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-4 flex-grow">
                                    <?php echo e($wisata->description); ?>

                                </p>

                                <!-- CTA Button with Enhancement -->
                                <div class="flex gap-2 mt-auto">
                                    <button class="flex-1 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white font-bold py-2.5 px-4 rounded-lg transition-all duration-300 transform group-hover:shadow-lg text-sm uppercase tracking-wider">
                                        👁️ Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <!-- Empty State -->
                    <div class="col-span-full flex items-center justify-center py-24">
                        <div class="text-center">
                            <div class="text-7xl mb-4">🔍</div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Tidak ada wisata ditemukan</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Coba ubah filter atau kategori Anda</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Add keyframe animation dynamically
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);

        // Search dan Filter functionality
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const wisataCards = document.querySelectorAll('#wisataContainer a');

        function filterWisatas() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value;

            wisataCards.forEach((card, index) => {
                const name = card.querySelector('h3').textContent.toLowerCase();
                const category = card.dataset.category || '';

                const matchesSearch = name.includes(searchTerm);
                const matchesCategory = !selectedCategory || category === selectedCategory;

                const shouldShow = matchesSearch && matchesCategory;
                card.style.display = shouldShow ? 'block' : 'none';

                // Re-trigger animation on filter
                if (shouldShow) {
                    card.style.animation = 'none';
                    setTimeout(() => {
                        card.style.animation = `fadeInUp 0.5s ease-out ${index * 0.05}s forwards`;
                    }, 10);
                }
            });
        }

        searchInput?.addEventListener('keyup', filterWisatas);
        categoryFilter?.addEventListener('change', filterWisatas);
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\PZN\gorogon\my-skripsi\resources\views/user/wisata/catalog.blade.php ENDPATH**/ ?>