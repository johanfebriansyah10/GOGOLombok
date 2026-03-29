<footer class="bg-gray-800 text-white py-8 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Logo dan Deskripsi -->
            <div>
                <div class="flex items-center mb-4">
                    <img src="<?php echo e(asset('images/GOLombok.png')); ?>" alt="Logo" class="h-10 w-10 mr-3">
                    <h3 class="text-lg font-semibold">GO Lombok</h3>
                </div>
                <p class="text-gray-300 text-sm">
                    Sistem rekomendasi wisata di Lombok menggunakan metode SAW (Simple Additive Weighting).
                </p>
            </div>

            <!-- Link Navigasi -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Navigasi</h4>
                <ul class="space-y-2">
                    <li><a href="<?php echo e(route('dashboard')); ?>" class="text-gray-300 hover:text-white transition">Dashboard</a></li>
                    <li><a href="<?php echo e(route('wisata.catalog')); ?>" class="text-gray-300 hover:text-white transition">Wisata</a></li>
                    <li><a href="<?php echo e(route('saw.recommendations.index')); ?>" class="text-gray-300 hover:text-white transition">Rekomendasi</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                <p class="text-gray-300 text-sm">
                    Email: info@golombok.com<br>
                    Telepon: +62 123 456 789
                </p>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-700 mt-8 pt-8 text-center">
            <p class="text-gray-300 text-sm">
                &copy; <?php echo e(date('Y')); ?> GO Lombok. All rights reserved.
            </p>
        </div>
    </div>
</footer>
<?php /**PATH C:\laragon\www\PZN\gorogon\my-skripsi\resources\views/components/footer-user.blade.php ENDPATH**/ ?>