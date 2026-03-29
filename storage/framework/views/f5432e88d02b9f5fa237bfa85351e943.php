<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['breadcrumbs' => []]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['breadcrumbs' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<nav class="mb-6" aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-2 text-sm">
        <!-- Home -->
        <li>
            <a href="<?php echo e(route('dashboard')); ?>" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 transition font-medium">
                🏠 Beranda
            </a>
        </li>

        <!-- Dynamic breadcrumbs -->
        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="text-gray-400 dark:text-gray-600">
                <span>/</span>
            </li>
            <li>
                <?php if(isset($breadcrumb['url'])): ?>
                    <a href="<?php echo e($breadcrumb['url']); ?>" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 transition font-medium">
                        <?php echo e($breadcrumb['label']); ?>

                    </a>
                <?php else: ?>
                    <span class="text-gray-600 dark:text-gray-400 font-medium">
                        <?php echo e($breadcrumb['label']); ?>

                    </span>
                <?php endif; ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
</nav>
<?php /**PATH C:\laragon\www\PZN\gorogon\my-skripsi\resources\views/components/breadcrumbs.blade.php ENDPATH**/ ?>