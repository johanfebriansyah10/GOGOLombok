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
                <?php echo e(__('Detail User: ') . $user->name); ?>

            </h2>
            <div>
                <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit
                </a>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi User</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100"><?php echo e($user->id); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100"><?php echo e($user->name); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100"><?php echo e($user->email); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</dt>
                                    <dd class="text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'); ?>">
                                            <?php echo e(ucfirst($user->role)); ?>

                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Terverifikasi</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        <?php echo e($user->email_verified_at ? 'Ya (' . $user->email_verified_at->format('d/m/Y H:i') . ')' : 'Tidak'); ?>

                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat Pada</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100"><?php echo e($user->created_at ? $user->created_at->format('d/m/Y H:i') : '-'); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Diupdate Pada</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100"><?php echo e($user->updated_at ? $user->updated_at->format('d/m/Y H:i') : '-'); ?></dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Aktivitas</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                User ini terdaftar sebagai <?php echo e($user->role); ?> dalam sistem rekomendasi wisata SAW.
                            </p>
                            <?php if($user->role === 'admin'): ?>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                    Sebagai admin, user ini memiliki akses penuh ke semua fitur manajemen sistem.
                                </p>
                            <?php else: ?>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                    Sebagai user biasa, user ini dapat mengakses katalog wisata dan rekomendasi SAW.
                                </p>
                            <?php endif; ?>
                        </div>
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
<?php /**PATH C:\laragon\www\PZN\gorogon\my-skripsi\resources\views/admin/users/show.blade.php ENDPATH**/ ?>