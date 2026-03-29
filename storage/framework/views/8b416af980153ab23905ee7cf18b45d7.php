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
                <?php echo e(__('Manajemen Bobot Kriteria')); ?>

            </h2>
            <a href="<?php echo e(route('admin.weights.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                + Tambah Bobot
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <?php if($weights->isEmpty()): ?>
                        <p class="text-gray-500 text-center py-8">
                            Belum ada bobot. <a href="<?php echo e(route('admin.weights.create')); ?>" class="text-blue-600 hover:text-blue-800">Tambah bobot baru</a>
                        </p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold">No</th>
                                        <th class="px-4 py-3 font-semibold">Kode Kriteria</th>
                                        <th class="px-4 py-3 font-semibold">Nama Kriteria</th>
                                        <th class="px-4 py-3 font-semibold">Tipe</th>
                                        <th class="px-4 py-3 font-semibold">Bobot</th>
                                        <th class="px-4 py-3 font-semibold">Persentase</th>
                                        <th class="px-4 py-3 font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $weights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $weight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3"><?php echo e($weights->firstItem() + $key); ?></td>
                                            <td class="px-4 py-3 font-semibold"><?php echo e($weight->criteria->code); ?></td>
                                            <td class="px-4 py-3 font-semibold"><?php echo e($weight->criteria->name); ?></td>
                                            <td class="px-4 py-3">
                                                <?php if($weight->criteria->type === 'benefit'): ?>
                                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Benefit</span>
                                                <?php else: ?>
                                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">Cost</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-4 py-3 font-semibold text-blue-600">
                                                <?php echo e(number_format($weight->weight, 4)); ?>

                                            </td>
                                            <td class="px-4 py-3">
                                                <?php echo e(number_format($weight->weight * 100, 2)); ?>%
                                            </td>
                                            <td class="px-4 py-3 space-x-2">
                                                <a href="<?php echo e(route('admin.weights.edit', $weight)); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                    Edit
                                                </a>
                                                <form action="<?php echo e(route('admin.weights.destroy', $weight)); ?>" method="POST" style="display:inline;" data-confirm-delete="Bobot untuk kriteria '<?php echo e($weight->criteria->name); ?>' akan dihapus secara permanen" data-confirm-title="Hapus Bobot?">
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

                        <!-- Pagination -->
                        <div class="mt-6">
                            <?php echo e($weights->links()); ?>

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
<?php /**PATH C:\laragon\www\PZN\gorogon\my-skripsi\resources\views/admin/weights/index.blade.php ENDPATH**/ ?>