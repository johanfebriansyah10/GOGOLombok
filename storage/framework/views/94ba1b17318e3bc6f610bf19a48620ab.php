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
                <?php echo e(__('Kelola Data User')); ?>

            </h2>
            <a href="<?php echo e(route('admin.users.create')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah User
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <?php if(session('success')): ?>
                        <div class="alert-success hidden"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert-error hidden"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-sm text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-700">ID</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">Nama</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">Email</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">Role</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-md text-gray-900 dark:text-gray-100"><?php echo e($user->id); ?></td>
                                        <td class="px-4 py-3 whitespace-nowrap text-md text-gray-900 dark:text-gray-100"><?php echo e($user->name); ?></td>
                                        <td class="px-4 py-3 whitespace-nowrap text-md text-gray-900 dark:text-gray-100"><?php echo e($user->email); ?></td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'); ?>">
                                                <?php echo e(ucfirst($user->role)); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-md font-medium text-center">
                                            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                                            <?php if($user->getKey() !== auth()->id()): ?>
                                                <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" class="inline" data-confirm-delete="User <?php echo e($user->name); ?> akan dihapus secara permanen" data-confirm-title="Hapus User?">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Hapus</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <?php echo e($users->links()); ?>

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
<?php /**PATH C:\laragon\www\PZN\gorogon\my-skripsi\resources\views/admin/users/index.blade.php ENDPATH**/ ?>