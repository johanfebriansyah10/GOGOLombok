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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Section - Enhanced -->
            <section class="overflow-hidden shadow-xl sm:rounded-2xl mb-12 border-2 border-gray-200">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8 lg:p-12">
                    <!-- Left: Text -->
                    <div class="flex flex-col justify-center">
                        <h1 class="text-2xl lg:text-5xl font-black mb-4 leading-tight">
                            Selamat Datang, <?php echo e(Auth::user()->name); ?>

                        </h1>
                        <p class="text-lg mb-6 leading-relaxed">
                            Jelajahi keindahan Lombok melalui Website Kami.
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <span class="inline-flex items-center px-4 py-2 rounded-full bg-green-500/20 backdrop-blur text-sm font-semibold border border-white/30">
                                Rekomendasi sesuai Kebutuhan
                            </span>
                            <span class="inline-flex items-center px-4 py-2 rounded-full bg-green-500/20 backdrop-blur text-sm font-semibold border border-white/30">
                                Jelajahi Wisata Terbaik di Lombok
                            </span>
                        </div>
                    </div>

                    <!-- Right: Logo with Animation -->
                    <div class="flex items-center justify-end">
                        <div class="relative">
                            <div class="absolute inset-0 rounded-2xl blur-2xl"></div>
                            <div class="relative rounded-full flex items-center justify-center shadow-2xl transform hover:scale-105 transition-transform duration-300 h-auto w-auto">
                                <img src="<?php echo e(asset('images/GOLombok.svg')); ?>" alt="GO Lombok" class="w-52 h-52" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Recommended Wisata Carousel -->
            <?php if($wisatas->count() > 0): ?>
            <section class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Rekomendasi Pilihan</h2>
                    <a href="<?php echo e(route('wisata.catalog')); ?>" class="text-emerald-600 hover:text-emerald-700 font-semibold text-sm">Lihat Semua →</a>
                </div>
                <div class="relative">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php $__currentLoopData = $wisatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wisata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 h-80">
                            <!-- Background Image -->
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/80">
                                <?php if($wisata->image): ?>
                                    <img src="<?php echo e(asset('storage/' . $wisata->image)); ?>" alt="<?php echo e($wisata->name); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"/>
                                <?php else: ?>
                                    <div class="w-full h-full bg-gradient-to-br from-emerald-400 to-teal-600"></div>
                                <?php endif; ?>
                            </div>

                            <!-- Content Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-end p-6">
                                <div>
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h3 class="text-2xl font-bold text-white"><?php echo e($wisata->name); ?></h3>
                                            <p class="text-emerald-200 text-sm flex items-center mt-1">
                                                <?php echo e($wisata->location ?? 'Lombok'); ?>

                                            </p>
                                        </div>
                                        <span class="bg-yellow-400 text-gray-900 px-3 py-1 rounded-full font-bold text-sm">⭐ <?php echo e(number_format($wisata->rating, 1)); ?></span>
                                    </div>
                                    <p class="text-gray-200 text-sm line-clamp-2 mb-4"><?php echo e($wisata->description); ?></p>
                                    <div class="flex items-center justify-between pt-3 border-t border-white/20">
                                        <span class="text-white font-semibold">💰 Rp<?php echo e(number_format($wisata->ticket_price, 0, ',', '.')); ?></span>
                                        <a href="<?php echo e(route('wisata.show', $wisata->id)); ?>" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-colors">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

        </div>
    </div>
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
<?php /**PATH C:\laragon\www\PZN\gorogon\my-skripsi\resources\views/user/dashboard.blade.php ENDPATH**/ ?>