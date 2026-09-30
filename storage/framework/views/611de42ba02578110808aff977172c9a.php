<?php $__env->startSection('title', 'Edit Page - MemoryMaster'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Page</h1>
            <p class="text-gray-600">Update the content of this page in "<?php echo e($page->note->title); ?>"</p>
            <div class="mt-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    <?php if($page->note->type === 'normal'): ?> bg-blue-100 text-blue-800
                    <?php elseif($page->note->type === 'vocab'): ?> bg-green-100 text-green-800
                    <?php else: ?> bg-purple-100 text-purple-800 <?php endif; ?>">
                    <i class="fas 
                        <?php if($page->note->type === 'normal'): ?> fa-sticky-note
                        <?php elseif($page->note->type === 'vocab'): ?> fa-book
                        <?php else: ?> fa-square-root-alt <?php endif; ?> mr-2"></i>
                    <?php echo e(ucfirst($page->note->type)); ?> Note
                </span>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('pages.update', $page->id)); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Front Side</h3>
                        <span class="text-sm text-gray-500">
                            <?php if($page->note->type === 'vocab'): ?> Term 
                            <?php elseif($page->note->type === 'formula'): ?> Formula 
                            <?php else: ?> Title <?php endif; ?>
                        </span>
                    </div>
                    
                    <div>
                        <label for="front_text" class="block text-sm font-medium text-gray-700 mb-2">
                            <?php if($page->note->type === 'vocab'): ?> Term *
                            <?php elseif($page->note->type === 'formula'): ?> Formula Description
                            <?php else: ?> Title * <?php endif; ?>
                        </label>
                        <?php if($page->note->type === 'vocab'): ?>
                        <input type="text" name="front_text" id="front_text" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="Enter the term or word"
                               value="<?php echo e(old('front_text', $page->front_text)); ?>">
                        <?php else: ?>
                        <textarea name="front_text" id="front_text" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                  placeholder="<?php if($page->note->type === 'formula'): ?> Describe the formula <?php else: ?> Enter the title <?php endif; ?>"
                                  <?php if($page->note->type !== 'formula'): ?> required <?php endif; ?>><?php echo e(old('front_text', $page->front_text)); ?></textarea>
                        <?php endif; ?>
                    </div>

                    <?php if($page->note->type === 'formula'): ?>
                    <div>
                        <label for="front_latex" class="block text-sm font-medium text-gray-700 mb-2">
                            LaTeX Formula (Optional)
                        </label>
                        <textarea name="front_latex" id="front_latex" rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors font-mono text-sm"
                                  placeholder="Enter LaTeX formula (e.g., E = mc^2)"><?php echo e(old('front_latex', $page->front_latex)); ?></textarea>
                    </div>
                    <?php endif; ?>

                    <div>
                        <label for="front_image" class="block text-sm font-medium text-gray-700 mb-2">
                            <?php if($page->note->type === 'formula'): ?> Formula Image
                            <?php else: ?> Front Image <?php endif; ?>
                        </label>
                        <input type="file" name="front_image" id="front_image" 
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        
                        <?php if($page->image_front): ?>
                        <div class="mt-3">
                            <p class="text-sm text-gray-600 mb-2">Current image:</p>
                            <div class="flex items-center space-x-4">
                                <img src="<?php echo e(Storage::url($page->image_front)); ?>" 
                                     alt="Current front image" 
                                     class="max-w-xs h-auto rounded-lg border border-gray-300 preview-image">
                                <div>
                                    <label class="flex items-center text-sm text-gray-600">
                                        <input type="checkbox" name="remove_front_image" value="1" class="mr-2">
                                        Remove current image
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div id="front-image-preview" class="mt-2"></div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Back Side</h3>
                        <span class="text-sm text-gray-500">
                            <?php if($page->note->type === 'vocab'): ?> Definition
                            <?php elseif($page->note->type === 'formula'): ?> Explanation
                            <?php else: ?> Content <?php endif; ?>
                        </span>
                    </div>
                    
                    <div>
                        <label for="back_text" class="block text-sm font-medium text-gray-700 mb-2">
                            <?php if($page->note->type === 'vocab'): ?> Definition *
                            <?php elseif($page->note->type === 'formula'): ?> Formula Explanation
                            <?php else: ?> Content * <?php endif; ?>
                        </label>
                        <textarea name="back_text" id="back_text" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                  placeholder="<?php if($page->note->type === 'vocab'): ?> Enter the definition <?php elseif($page->note->type === 'formula'): ?> Explain the formula <?php else: ?> Enter the content <?php endif; ?>"
                                  <?php if($page->note->type !== 'formula'): ?> required <?php endif; ?>><?php echo e(old('back_text', $page->back_text)); ?></textarea>
                    </div>

                    <?php if($page->note->type === 'formula'): ?>
                    <div>
                        <label for="back_latex" class="block text-sm font-medium text-gray-700 mb-2">
                            LaTeX Formula (Optional)        
                        </label>
                        <textarea name="back_latex" id="back_latex" rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors font-mono text-sm"
                                  placeholder="Enter LaTeX formula"><?php echo e(old('back_latex', $page->back_latex)); ?></textarea>
                    </div>
                    <?php endif; ?>

                    <div>
                        <label for="back_image" class="block text-sm font-medium text-gray-700 mb-2">
                            <?php if($page->note->type === 'formula'): ?> Explanation Image
                            <?php else: ?> Back Image <?php endif; ?>
                        </label>
                        <input type="file" name="back_image" id="back_image" 
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        
                        <?php if($page->image_back): ?>
                        <div class="mt-3">
                            <p class="text-sm text-gray-600 mb-2">Current image:</p>
                            <div class="flex items-center space-x-4">
                                <img src="<?php echo e(Storage::url($page->image_back)); ?>" 
                                     alt="Current back image" 
                                     class="max-w-xs h-auto rounded-lg border border-gray-300 preview-image">
                                <div>
                                    <label class="flex items-center text-sm text-gray-600">
                                        <input type="checkbox" name="remove_back_image" value="1" class="mr-2">
                                        Remove current image
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div id="back-image-preview" class="mt-2"></div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-6">
                <a href="<?php echo e(route('notes.show', $page->note_id)); ?>" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    ← Back to Note
                </a>
                
                <div class="flex space-x-4">
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        Update Page
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.preview-image {
    max-width: 100%;
    max-height: 200px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const frontImage = document.getElementById('front_image');
    const backImage = document.getElementById('back_image');
    const frontImagePreview = document.getElementById('front-image-preview');
    const backImagePreview = document.getElementById('back-image-preview');

    function handleImagePreview(input, previewElement) {
        if (input && input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (previewElement) {
                    previewElement.innerHTML = `
                        <div class="mt-2">
                            <p class="text-sm text-green-600 mb-1">New image preview:</p>
                            <img src="${e.target.result}" class="preview-image" alt="Preview">
                        </div>
                    `;
                }
            }
            reader.readAsDataURL(file);
        } else {
            if (previewElement) previewElement.innerHTML = '';
        }
    }

    if (frontImage) {
        frontImage.addEventListener('change', function() {
            handleImagePreview(this, frontImagePreview);
        });
    }

    if (backImage) {
        backImage.addEventListener('change', function() {
            handleImagePreview(this, backImagePreview);
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\study\NIC\DGL-123(intoduction PHP)\php_project\php_project_\resources\views/pages/edit.blade.php ENDPATH**/ ?>