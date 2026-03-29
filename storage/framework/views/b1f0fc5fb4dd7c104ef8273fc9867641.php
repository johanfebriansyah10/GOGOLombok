<nav x-data="{ open: false }" class="shadow-md border-b bg-gradient-to-br from-[#34C759] to-[#00C8B3] sticky top-0 z-50 sm:py-2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-2 font-bold text-gray-800 text-lg hover:opacity-80 transition">
                    <?php if (isset($component)) { $__componentOriginal75b752863df373cba2c293ca1c3db04e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal75b752863df373cba2c293ca1c3db04e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo1','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo1'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal75b752863df373cba2c293ca1c3db04e)): ?>
<?php $attributes = $__attributesOriginal75b752863df373cba2c293ca1c3db04e; ?>
<?php unset($__attributesOriginal75b752863df373cba2c293ca1c3db04e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal75b752863df373cba2c293ca1c3db04e)): ?>
<?php $component = $__componentOriginal75b752863df373cba2c293ca1c3db04e; ?>
<?php unset($__componentOriginal75b752863df373cba2c293ca1c3db04e); ?>
<?php endif; ?>
                </a>
            </div>

            <!-- Desktop Navigation (Centered) -->
            <div class="hidden md:flex items-center gap-4">
                <?php if(Auth::user()->role === 'admin'): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('admin.dashboard') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent'); ?> transition">
                        Dashboard
                    </a>
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('admin.categories.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent'); ?> transition">
                        Kategori
                    </a>
                    <a href="<?php echo e(route('admin.wisatas.index')); ?>" class="px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('admin.wisatas.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent'); ?> transition">
                        Wisata
                    </a>
                    <a href="<?php echo e(route('admin.criterias.index')); ?>" class="px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('admin.criterias.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent'); ?> transition">
                        Kriteria
                    </a>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('admin.users.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent'); ?> transition">
                        Users
                    </a>
                    
                <?php else: ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('dashboard') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent'); ?> transition">
                        Home
                    </a>
                    <a href="<?php echo e(route('wisata.catalog')); ?>" class="px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('wisata.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent'); ?> transition">
                        Wisata
                    </a>
                    <a href="<?php echo e(route('saw.recommendations.index')); ?>" class="px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('saw.recommendations.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent'); ?> transition">
                        Rekomendasi
                    </a>
                    <a href="<?php echo e(route('saw.results.index')); ?>" class="px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('saw.results.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent'); ?> transition">
                        Ranking
                    </a>
                    
                <?php endif; ?>
            </div>

            <!-- Right Side: User Menu & Hamburger -->
            <div class="flex items-center gap-4">
                <!-- Desktop User Dropdown -->
                <div class="hidden md:block">
                    <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['align' => 'right','width' => '48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right','width' => '48']); ?>
                         <?php $__env->slot('trigger', null, []); ?> 
                            <button class="flex items-center gap-2 px-4 py-2 text-md font-medium text-gray-100 hover:text-gray-300 transition">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-green-500 font-bold text-md">
                                    <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                                </div>
                                <span class="hidden sm:inline"><?php echo e(Auth::user()->name); ?></span>
                                <svg class="font-bold h-4 w-4 text-gray-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                         <?php $__env->endSlot(); ?>

                         <?php $__env->slot('content', null, []); ?> 
                            <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('profile.edit')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('profile.edit'))]); ?>
                                <?php echo e(__('Profile Settings')); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('dashboard')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard'))]); ?>
                                <?php echo e(__('Dashboard')); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('logout'),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']); ?>
                                    <?php echo e(__('Log Out')); ?>

                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                            </form>
                         <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
                </div>

                <!-- Mobile Hamburger Menu -->
                <button @click="open = !open" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" :class="{'hidden': open, 'block': !open}" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" :class="{'block': open, 'hidden': !open}" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="open" class="md:hidden border-t border-gray-200 bg-white">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <?php if(Auth::user()->role === 'admin'): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('admin.dashboard') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?> transition">
                        Dashboard
                    </a>
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="block px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('admin.categories.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?> transition">
                        Kategori
                    </a>
                    <a href="<?php echo e(route('admin.wisatas.index')); ?>" class="block px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('admin.wisatas.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?> transition">
                        Wisata
                    </a>
                    <a href="<?php echo e(route('admin.criterias.index')); ?>" class="block px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('admin.criterias.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?> transition">
                        Kriteria
                    </a>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="block px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('admin.users.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?> transition">
                        Users
                    </a>
                    <a href="<?php echo e(route('admin.evaluations.index')); ?>" class="block px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('admin.evaluations.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?> transition">
                        Evaluasi
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="block px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('dashboard') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?> transition">
                        Home
                    </a>
                    <a href="<?php echo e(route('wisata.catalog')); ?>" class="block px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('wisata.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?> transition">
                        Katalog
                    </a>
                    <a href="<?php echo e(route('saw.recommendations.index')); ?>" class="block px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('saw.recommendations.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?> transition">
                        Rekomendasi
                    </a>
                    <a href="<?php echo e(route('saw.results.index')); ?>" class="block px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('saw.results.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?> transition">
                        Ranking
                    </a>
                    <a href="<?php echo e(route('saw.results.analysis')); ?>" class="block px-3 py-2 rounded-md text-md font-medium <?php echo e(request()->routeIs('saw.results.analysis') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?> transition">
                        Analisis
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile User Menu -->
            <div class="border-t border-gray-200 pt-3 pb-3">
                <div class="px-4 mb-3">
                    <div class="font-medium text-gray-600"><?php echo e(Auth::user()->name); ?></div>
                    <div class="text-sm text-gray-600"><?php echo e(Auth::user()->email); ?></div>
                </div>
                <div class="px-2 space-y-1">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 transition">
                        <?php echo e(__('Profile Settings')); ?>

                    </a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 transition">
                            <?php echo e(__('Log Out')); ?>

                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\laragon\www\PZN\gorogon\my-skripsi\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>