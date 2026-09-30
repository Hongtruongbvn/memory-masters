<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'MemoryMaster'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .method-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
        .feature-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .break-overlay {
            background: rgba(0, 0, 0, 0.8);
            z-index: 9999;
        }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-2">
                        <img src="<?php echo e(asset('images/logo.png')); ?>" 
                             alt="MemoryMaster Logo" 
                             class="h-8 w-auto md:h-10"> 
                        <span class="text-xl font-bold text-gray-800">MemoryMaster</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="<?php echo e(route('home')); ?>#methods" class="text-gray-600 hover:text-blue-600 font-medium">Methods</a>
                    <a href="<?php echo e(route('home')); ?>#features" class="text-gray-600 hover:text-blue-600 font-medium">Features</a>
                </div>

                <div class="flex items-center space-x-4">
                    <?php if(session('user')): ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="text-gray-600 hover:text-blue-600 font-medium">Dashboard</a>
                        
                        <span class="text-gray-600">Welcome, <?php echo e(session('user')['name']); ?></span>
                        <?php if(session('user')['is_vip'] ?? false): ?>
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full">VIP</span>
                        <?php endif; ?>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Logout</button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-gray-600 hover:text-blue-600 font-medium">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium">
                            Get Started
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <div id="breakOverlay" class="break-overlay fixed inset-0 hidden items-center justify-center text-white">
        <div class="text-center">
            <div class="text-6xl mb-4">
                <i class="fas fa-coffee"></i>
            </div>
            <h2 class="text-4xl font-bold mb-2">Break Time</h2>
            <p class="text-2xl mb-4">Take a rest, you deserve it!</p>
            <div id="breakTimer" class="text-5xl font-mono font-bold mb-6">05:00</div>
            <p class="text-lg opacity-75">Session will resume automatically</p>
        </div>
    </div>

    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <img src="<?php echo e(asset('images/logo.png')); ?>" 
                             alt="MemoryMaster Logo" 
                             class="h-8 w-auto">
                        <span class="text-xl font-bold">MemoryMaster</span>
                    </div>
                    <p class="text-gray-400">
                        Master your memory with legendary techniques used by memory champions worldwide.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-bold mb-4">Methods</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="<?php echo e(route('home')); ?>#methods" class="hover:text-white">Method of Loci</a></li>
                        <li><a href="<?php echo e(route('home')); ?>#methods" class="hover:text-white">Spaced Repetition</a></li>
                        <li><a href="<?php echo e(route('home')); ?>#methods" class="hover:text-white">Mnemonic Devices</a></li>
                        <li><a href="<?php echo e(route('home')); ?>#methods" class="hover:text-white">Active Recall</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold mb-4">Resources</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Blog</a></li>
                        <li><a href="#" class="hover:text-white">Tutorials</a></li>
                        <li><a href="#" class="hover:text-white">Research</a></li>
                        <li><a href="#" class="hover:text-white">Support</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold mb-4">Connect</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 MemoryMaster. All rights reserved. (Pham Hong Truong)</p>
            </div>
        </div>
    </footer>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH C:\study\NIC\DGL-123(intoduction PHP)\php_project\php_project_\resources\views/layouts/app.blade.php ENDPATH**/ ?>