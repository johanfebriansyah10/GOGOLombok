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
                <?php echo e(__('Detail Perhitungan SAW')); ?>

            </h2>
            <a href="<?php echo e(route('saw.results.index')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                ← Kembali
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Wisata Card -->
            <div class="mb-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Image -->
                        <?php if($wisata->image_url): ?>
                            <div class="md:col-span-1">
                                <img src="<?php echo e($wisata->image_url); ?>" alt="<?php echo e($wisata->name); ?>" class="w-full h-64 object-cover rounded-lg">
                            </div>
                        <?php endif; ?>

                        <!-- Info -->
                        <div class="md:col-span-2">
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2"><?php echo e($wisata->name); ?></h3>

                            <div class="mb-4">
                                <p class="text-gray-700 dark:text-gray-300"><?php echo e($wisata->description); ?></p>
                            </div>

                            <!-- Score Card -->
                            <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-gray-700 dark:to-gray-600 p-4 rounded-lg">
                                <p class="text-gray-600 dark:text-gray-300 text-sm font-semibold mb-2">SKOR SAW (Vi)</p>
                                <p class="text-5xl font-bold text-green-600"><?php echo e(number_format($scoreDetail['score'], 4)); ?></p>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
                                    <?php echo e(number_format($scoreDetail['score'] * 100, 2)); ?>% - Ranking #<?php echo e($scoreDetail['rank']); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calculation Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                        Rincian Perhitungan: Vi = Σ (rij × wj)
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Kriteria</th>
                                    <th class="px-4 py-3 text-center font-semibold">Nilai Normalisasi (rij)</th>
                                    <th class="px-4 py-3 text-center font-semibold">Bobot (wj)</th>
                                    <th class="px-4 py-3 text-center font-semibold">rij × wj</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $totalWeighted = 0; ?>
                                <?php $__currentLoopData = $scoreDetail['score_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3 font-semibold">
                                            <?php echo e($detail['criteria_code']); ?> - <?php echo e($detail['criteria_name']); ?>

                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="bg-blue-100 dark:bg-blue-900 text-blue-900 dark:text-blue-100 px-2 py-1 rounded">
                                                <?php echo e(number_format($detail['normalized'], 4)); ?>

                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="font-semibold"><?php echo e(number_format($detail['weight'], 4)); ?></span>
                                        </td>
                                        <td class="px-4 py-3 text-center font-bold text-green-600">
                                            <?php echo e(number_format($detail['weighted'], 6)); ?>

                                        </td>
                                    </tr>
                                    <?php $totalWeighted += $detail['weighted']; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr class="bg-gray-100 dark:bg-gray-700 font-bold">
                                    <td colspan="3" class="px-4 py-3 text-right">Total (Vi) =</td>
                                    <td class="px-4 py-3 text-center text-green-600">
                                        <?php echo e(number_format($totalWeighted, 4)); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Ranking Comparison -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Perbandingan Ranking</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Rank</th>
                                    <th class="px-4 py-3 text-left font-semibold">Nama Wisata</th>
                                    <th class="px-4 py-3 text-right font-semibold">Skor Vi</th>
                                    <th class="px-4 py-3 font-semibold">Grafik</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $ranking; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="border-b border-gray-200 dark:border-gray-700 <?php echo e($item['wisata_id'] == $wisata->id ? 'bg-green-50 dark:bg-gray-700' : 'hover:bg-gray-50 dark:hover:bg-gray-700'); ?>">
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center justify-center w-6 h-6 <?php echo e($item['wisata_id'] == $wisata->id ? 'bg-green-500' : 'bg-gray-300'); ?> text-white text-xs rounded-full font-bold">
                                                <?php echo e($loop->iteration); ?>

                                            </span>
                                        </td>
                                        <td class="px-4 py-3 font-semibold <?php echo e($item['wisata_id'] == $wisata->id ? 'text-green-600' : ''); ?>">
                                            <?php echo e($item['wisata_name']); ?>

                                        </td>
                                        <td class="px-4 py-3 text-right font-bold">
                                            <?php echo e(number_format($item['score'], 4)); ?>

                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-500 h-2 rounded-full" style="width: <?php echo e($item['score'] * 100); ?>%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
<?php /**PATH C:\laragon\www\PZN\gorogon\my-skripsi\resources\views/saw/results/detail.blade.php ENDPATH**/ ?>