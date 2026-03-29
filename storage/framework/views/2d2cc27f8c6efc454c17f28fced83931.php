<footer class="bg-gray-800 text-white py-[27px] mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center mb-4 md:mb-0">
                <img src="<?php echo e(asset('images/GOLombok.png')); ?>" alt="Logo" class="h-8 w-8 mr-3">
                <h3 class="text-lg font-semibold">GO Lombok</h3>
            </div>

            <!-- Info Admin -->
            <div class="text-center md:text-right">
                <p class="text-gray-300 text-sm">
                    Logged in as: <strong><?php echo e(Auth::user()->name); ?></strong> (<?php echo e(Auth::user()->role); ?>)
                </p>
                <p class="text-gray-400 text-xs">
                    &copy; <?php echo e(date('Y')); ?> GOLombok.
                </p>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH C:\laragon\www\PZN\gorogon\my-skripsi\resources\views/components/footer-admin.blade.php ENDPATH**/ ?>