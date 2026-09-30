<?php $__env->startSection('title', $note->title . ' - MemoryMaster'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <?php if($note->type === 'vocab'): ?>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book text-green-600"></i>
                        </div>
                    <?php elseif($note->type === 'formula'): ?>
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-square-root-alt text-purple-600"></i>
                        </div>
                    <?php else: ?>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-sticky-note text-blue-600"></i>
                        </div>
                    <?php endif; ?>
                    <h1 class="text-3xl font-bold text-gray-800"><?php echo e($note->title); ?></h1>
                </div>
                
                <?php if($note->description): ?>
                    <p class="text-gray-600"><?php echo e($note->description); ?></p>
                <?php endif; ?>
                
                <div class="flex items-center space-x-4 mt-3 text-sm text-gray-500">
                    <span class="flex items-center">
                        <i class="fas fa-layer-group mr-1"></i>
                        <?php echo e($pages->count()); ?>/<?php echo e($note->page_limit); ?> pages
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-calendar mr-1"></i>
                        Created <?php echo e($note->created_at->format('M d, Y')); ?>

                    </span>
                    <?php if($note->subject): ?>
                        <span class="flex items-center">
                            <i class="fas fa-tag mr-1"></i>
                            <?php echo e(ucfirst($note->subject)); ?>

                        </span>
                    <?php endif; ?>
                    <span class="flex items-center">
                        <i class="fas fa-<?php echo e($note->type === 'vocab' ? 'book' : ($note->type === 'formula' ? 'square-root-alt' : 'sticky-note')); ?> mr-1"></i>
                        <?php echo e(ucfirst($note->type)); ?> Note
                    </span>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <?php if(!$note->is_completed): ?>
                    <a href="<?php echo e(route('pages.create', $note->id)); ?>" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        + Add Page
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700">Progress</span>
                <span class="text-sm text-gray-500"><?php echo e($pages->count()); ?>/<?php echo e($note->page_limit); ?> pages</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" 
                     style="width: <?php echo e(min(($pages->count() / $note->page_limit) * 100, 100)); ?>%"></div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200 px-6 py-4">
            <h2 class="text-xl font-semibold text-gray-800">Pages (<?php echo e($pages->count()); ?>)</h2>
        </div>

        <?php if($pages->count() > 0): ?>
            <div class="divide-y divide-gray-200">
                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-3">
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-sm font-medium">
                                        #<?php echo e($page->position); ?>

                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="font-semibold text-gray-700 mb-2 text-sm">
                                            <?php if($note->type === 'vocab'): ?> Term
                                            <?php elseif($note->type === 'formula'): ?> Formula
                                            <?php else: ?> Title <?php endif; ?>
                                        </h4>
                                        <div class="text-gray-800">
                                            <?php if($page->front_text): ?>
                                                <?php if($note->type === 'vocab'): ?>
                                                    <div class="font-semibold text-lg text-gray-900 mb-2"><?php echo e($page->front_text); ?></div>
                                                <?php elseif($note->type === 'normal'): ?>
                                                    <div class="font-semibold text-lg text-gray-900 mb-2"><?php echo e($page->front_text); ?></div>
                                                <?php else: ?>
                                                    <p class="mb-2"><?php echo e($page->front_text); ?></p>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if($page->front_latex): ?>
                                                <div class="bg-gray-100 p-3 rounded font-mono text-sm mb-2">
                                                    <div class="font-semibold text-xs text-gray-500 mb-1">LaTeX:</div>
                                                    <?php echo e($page->front_latex); ?>

                                                </div>
                                            <?php endif; ?>
                                            <?php if($page->front_image): ?>
                                                <div class="mt-2">
                                                    <div class="font-semibold text-xs text-gray-500 mb-1">Image:</div>
                                                    <img src="<?php echo e(Storage::url($page->front_image)); ?>" 
                                                         alt="Front image" 
                                                         class="max-w-full h-auto rounded-lg border border-gray-300 max-h-48 object-contain">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold text-gray-700 mb-2 text-sm">
                                            <?php if($note->type === 'vocab'): ?> Definition
                                            <?php elseif($note->type === 'formula'): ?> Explanation
                                            <?php else: ?> Content <?php endif; ?>
                                        </h4>
                                        <div class="text-gray-800">
                                            <?php if($page->back_text): ?>
                                                <?php if($note->type === 'normal'): ?>
                                                    <div class="prose max-w-none">
                                                        <?php echo nl2br(e($page->back_text)); ?>

                                                    </div>
                                                <?php else: ?>
                                                    <p class="mb-2"><?php echo e($page->back_text); ?></p>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if($page->back_latex): ?>
                                                <div class="bg-gray-100 p-3 rounded font-mono text-sm mb-2">
                                                    <div class="font-semibold text-xs text-gray-500 mb-1">LaTeX:</div>
                                                    <?php echo e($page->back_latex); ?>

                                                </div>
                                            <?php endif; ?>
                                            <?php if($page->back_image): ?>
                                                <div class="mt-2">
                                                    <div class="font-semibold text-xs text-gray-500 mb-1">Image:</div>
                                                    <img src="<?php echo e(Storage::url($page->back_image)); ?>" 
                                                         alt="Back image" 
                                                         class="max-w-full h-auto rounded-lg border border-gray-300 max-h-48 object-contain">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex space-x-2 ml-4">
                                <a href="<?php echo e(route('pages.edit', $page->id)); ?>" 
                                   class="text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="<?php echo e(route('pages.destroy', $page->id)); ?>" 
                                      class="inline" onsubmit="return confirm('Are you sure you want to delete this page?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-sticky-note text-gray-400 text-2xl"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-600 mb-2">No pages yet</h4>
                <p class="text-gray-500 mb-6">Start by adding your first page to this note</p>
                <a href="<?php echo e(route('pages.create', $note->id)); ?>" 
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Add First Page
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="flex justify-between items-center mt-6">
        <a href="<?php echo e(route('dashboard')); ?>" 
           class="text-blue-600 hover:text-blue-800 transition-colors font-semibold">
            ← Back to Dashboard
        </a>
        
       
    </div>
</div>

<style>
.object-contain {
    object-fit: contain;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\study\NIC\DGL-123(intoduction PHP)\php_project\php_project_\resources\views/notes/show.blade.php ENDPATH**/ ?>