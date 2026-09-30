<?php $__env->startSection('title', 'Dashboard - MemoryMaster'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <section class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">
                Welcome back, <?php echo e(session('user')['name'] ?? 'User'); ?>!
            </h2>
            <p class="text-xl text-gray-600 mb-8">
                Continue your memory mastery journey with our legendary techniques.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="<?php echo e(route('home')); ?>" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                    ← Back to Home
                </a>
                <a href="<?php echo e(route('notes.create')); ?>" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    + Create New Note
                </a>
            </div>
        </section>

        <section class="bg-white rounded-lg shadow-sm p-6 mb-8 border border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Your Notes</h3>
                <a href="<?php echo e(route('notes.create')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-semibold">
                    + New Note
                </a>
            </div>

            <?php if($notes->count() > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-2">
                                    <?php if($note->type === 'vocab'): ?>
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-book text-green-600 text-sm"></i>
                                        </div>
                                    <?php elseif($note->type === 'formula'): ?>
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-square-root-alt text-purple-600 text-sm"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-sticky-note text-blue-600 text-sm"></i>
                                        </div>
                                    <?php endif; ?>
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full 
                                        <?php echo e($note->type === 'vocab' ? 'bg-green-100 text-green-800' : 
                                           ($note->type === 'formula' ? 'bg-purple-100 text-purple-800' : 
                                           'bg-blue-100 text-blue-800')); ?>">
                                        <?php echo e(ucfirst($note->type)); ?>

                                    </span>
                                </div>
                                
                                <?php if($note->study_method && $note->next_review_at): ?>
                                    <?php if($note->next_review_at->gt(now())): ?>
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full" 
                                              title="Next review: <?php echo e($note->next_review_at->format('M d, Y')); ?>">
                                            Review: <?php echo e($note->next_review_at->format('M d')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full">
                                            Ready for Review
                                        </span>
                                    <?php endif; ?>
                                <?php elseif($note->is_completed): ?>
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Completed</span>
                                <?php else: ?>
                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">In Progress</span>
                                <?php endif; ?>
                            </div>
                            
                            <h4 class="font-semibold text-gray-800 mb-2"><?php echo e($note->title); ?></h4>
                            <?php if($note->description): ?>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?php echo e($note->description); ?></p>
                            <?php endif; ?>
                            
                            <?php if($note->study_method): ?>
                                <?php
                                    $studyMethods = app('App\Http\Controllers\StudyController')->getStudyMethods();
                                    $methodConfig = $studyMethods[$note->study_method] ?? $studyMethods['SM2'];
                                ?>
                                <div class="flex items-center space-x-2 mb-3">
                                    <div class="w-4 h-4 bg-<?php echo e($methodConfig['color']); ?>-100 rounded flex items-center justify-center">
                                        <i class="<?php echo e($methodConfig['icon']); ?> text-<?php echo e($methodConfig['color']); ?>-600 text-xs"></i>
                                    </div>
                                    <span class="text-xs text-gray-500"><?php echo e($methodConfig['name']); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($note->type !== 'normal'): ?>
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                    <span><?php echo e($note->pages->count()); ?>/<?php echo e($note->page_limit); ?> pages</span>
                                    <span><?php echo e($note->created_at->format('M d, Y')); ?></span>
                                </div>
                            <?php else: ?>
                                <div class="text-sm text-gray-500 mb-3">
                                    <span><?php echo e($note->created_at->format('M d, Y')); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex space-x-2">
                                <a href="<?php echo e($note->type === 'normal' ? route('normal-notes.show', $note->id) : route('notes.show', $note->id)); ?>" 
                                   class="flex-1 bg-gray-100 text-gray-700 text-center py-2 rounded hover:bg-gray-200 transition-colors text-sm">
                                    View
                                </a>
                                <?php if(!$note->is_completed && $note->type !== 'normal'): ?>
                                    <a href="<?php echo e(route('pages.create', $note->id)); ?>" 
                                       class="flex-1 bg-blue-100 text-blue-700 text-center py-2 rounded hover:bg-blue-200 transition-colors text-sm">
                                        Add Page
                                    </a>
                                <?php endif; ?>
                                <?php if($note->type !== 'normal'): ?>
                                    <?php if($note->study_method && $note->next_review_at && $note->next_review_at->gt(now())): ?>
                                        <a href="<?php echo e(route('study.show', $note->id)); ?>" 
                                           class="flex-1 bg-orange-100 text-orange-700 text-center py-2 rounded hover:bg-orange-200 transition-colors text-sm">
                                            Review
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('study.show', $note->id)); ?>" 
                                           class="flex-1 bg-green-100 text-green-700 text-center py-2 rounded hover:bg-green-200 transition-colors text-sm">
                                            Study
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sticky-note text-gray-400 text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-600 mb-2">No notes yet</h4>
                    <p class="text-gray-500 mb-6">Create your first note to start learning</p>
                    <a href="<?php echo e(route('notes.create')); ?>" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        Create Your First Note
                    </a>
                </div>
            <?php endif; ?>
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\study\NIC\DGL-123(intoduction PHP)\php_project\php_project_\resources\views/auth/dashboard.blade.php ENDPATH**/ ?>