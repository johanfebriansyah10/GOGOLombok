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
                <?php echo e(__('Halaman Kategori Wisata Admin')); ?>

            </h2>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                + Tambah Kategori
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
                    <?php if($categories->isEmpty()): ?>
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                            Belum ada kategori. <a href="<?php echo e(route('admin.categories.create')); ?>" class="text-blue-600 hover:text-blue-800">Buat kategori baru</a>
                        </p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold">No</th>
                                        <th class="px-4 py-3 font-semibold">Nama Kategori</th>
                                        <th class="px-4 py-3 font-semibold">Deskripsi</th>
                                        <th class="px-4 py-3 font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3"><?php echo e($key + 1); ?></td>
                                            <td class="px-4 py-3 font-semibold"><?php echo e($category->name); ?></td>
                                            <td class="px-4 py-3">
                                                <?php echo e($category->description ? Str::limit($category->description, 50) : '-'); ?>

                                            </td>
                                            <td class="px-4 py-3 space-x-2">
                                                <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                    Edit
                                                </a>
                                                <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" style="display:inline;" data-confirm-delete="Kategori '<?php echo e($category->name); ?>' akan dihapus secara permanen" data-confirm-title="Hapus Kategori?">
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
<?php /**PATH C:\laragon\www\PZN\gorogon\my-skripsi\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>