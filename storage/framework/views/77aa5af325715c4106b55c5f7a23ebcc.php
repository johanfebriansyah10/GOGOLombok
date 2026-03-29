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
                <?php echo e(__('Halaman Wisata Admin')); ?>

            </h2>
            <a href="<?php echo e(route('admin.wisatas.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                + Tambah Wisata
            </a>
        </div>
     <?php $__env->endSlot(); ?>

<div class="py-12">
    <div class="max-w-[95rem] mx-auto sm:px-6 lg:px-8">
        <?php if($message = Session::get('success')): ?>
            <div class="alert-success hidden"><?php echo e($message); ?></div>
        <?php endif; ?>

        <?php if($message = Session::get('error')): ?>
            <div class="alert-error hidden"><?php echo e($message); ?></div>
        <?php endif; ?>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <?php if($wisatas->isEmpty()): ?>
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                            Belum ada wisata. <a href="<?php echo e(route('admin.wisatas.create')); ?>" class="text-blue-600 hover:text-blue-800">Tambah wisata baru</a>
                        </p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <tr>
                                        <th class="px-4 py-34 font-semibold text-[16px] text-center">No</th>
                                        <th class="px-4 py-4 font-semibold text-[16px] text-center">Foto</th>
                                        <th class="px-4 py-4 font-semibold text-[16px] text-center">Nama</th>
                                        <th class="px-4 py-4 font-semibold text-[16px] text-center">Kategori</th>
                                        <th class="px-4 py-4 font-semibold text-[16px] text-center">Lokasi</th>
                                        <th class="px-4 py-4 font-semibold text-[16px] text-center">💰 Harga</th>
                                        <th class="px-4 py-4 font-semibold text-[16px] text-center">📍 Jarak (km)</th>
                                        <th class="px-4 py-4 font-semibold text-[16px] text-center">🏢 Fasilitas</th>
                                        <th class="px-4 py-4 font-semibold text-[16px] text-center">⭐ Rating</th>
                                        <th class="px-4 py-4 font-semibold text-[16px] text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $wisatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $wisata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3 text-center"><?php echo e($key + 1); ?></td>
                                            <td class="px-4 py-3 flex items-center justify-center">
                                                <?php if($wisata->image_url): ?>
                                                    <img src="<?php echo e($wisata->image_url); ?>" alt="<?php echo e($wisata->name); ?>" class="w-12 h-12 object-cover rounded">
                                                <?php else: ?>
                                                    <span class="text-gray-400">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-4 py-3 font-semibold text-center"><?php echo e($wisata->name); ?></td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-2 py-1 rounded text-xs">
                                                    <?php echo e($wisata->category->name); ?>

                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center"><?php echo e($wisata->location); ?></td>
                                            <td class="px-4 py-3 text-center font-semibold">Rp <?php echo e(number_format($wisata->ticket_price, 0, ',', '.')); ?></td>
                                            <td class="px-4 py-3 text-center"><?php echo e(number_format($wisata->distance, 1)); ?> km</td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold <?php echo e($wisata->facilities_count >= 10 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : ($wisata->facilities_count >= 5 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200')); ?>">
                                                    <?php echo e($wisata->facilities_count); ?>

                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="text-yellow-500 font-semibold">
                                                    ⭐ <?php echo e(number_format($wisata->actual_rating, 1)); ?>/5
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 space-x-2 text-center">
                                                <a href="<?php echo e(route('admin.wisatas.edit', $wisata)); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                    Edit
                                                </a>
                                                <form action="<?php echo e(route('admin.wisatas.destroy', $wisata)); ?>" method="POST" style="display:inline;" data-confirm-delete="Wisata '<?php echo e($wisata->name); ?>' akan dihapus secara permanen" data-confirm-title="Hapus Wisata?">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
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
<?php /**PATH C:\laragon\www\PZN\gorogon\my-skripsi\resources\views/admin/wisatas/index.blade.php ENDPATH**/ ?>