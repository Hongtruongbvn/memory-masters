<?php $__env->startSection('title', $note->title . ' - MemoryMaster'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-sticky-note text-blue-600"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800"><?php echo e($note->title); ?></h1>
                </div>
                
                <?php if($note->description): ?>
                    <p class="text-gray-600"><?php echo e($note->description); ?></p>
                <?php endif; ?>
                
                <div class="flex items-center space-x-4 mt-3 text-sm text-gray-500">
                    <span class="flex items-center">
                        <i class="fas fa-calendar mr-1"></i>
                        Created <?php echo e($note->created_at->format('M d, Y')); ?>

                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-sticky-note mr-1"></i>
                        Normal Note
                    </span>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <form method="POST" action="<?php echo e(route('normal-notes.destroy', $note->id)); ?>" 
                      onsubmit="return confirm('Are you sure you want to delete this note?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Delete Note
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Note Content -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Note Content</h2>
            <button onclick="enableEditing()" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Edit Content
            </button>
        </div>

        <form method="POST" action="<?php echo e(route('normal-notes.update-content', $note->id)); ?>" id="content-form" class="hidden">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Note Content
                </label>
                <textarea name="content" id="content" rows="15"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                          placeholder="Write your note content here..."><?php echo e(old('content', $note->pages->first()->back_text ?? '')); ?></textarea>
                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex justify-end space-x-4">
                <button type="button" onclick="cancelEditing()" 
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                    Save Changes
                </button>
            </div>
        </form>

        <div id="content-display">
            <?php if($note->pages->count() > 0 && $note->pages->first()->back_text): ?>
                <div class="prose max-w-none">
                    <?php echo nl2br(e($note->pages->first()->back_text)); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sticky-note text-gray-400 text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-600 mb-2">No content yet</h4>
                    <p class="text-gray-500 mb-6">Start by adding content to your note</p>
                    <button onclick="enableEditing()" 
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        Add Content
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between items-center mt-6">
        <a href="<?php echo e(route('dashboard')); ?>" 
           class="text-blue-600 hover:text-blue-800 transition-colors font-semibold">
            ← Back to Dashboard
        </a>
    </div>
</div>

<script>
function enableEditing() {
    document.getElementById('content-form').classList.remove('hidden');
    document.getElementById('content-display').classList.add('hidden');
}

function cancelEditing() {
    document.getElementById('content-form').classList.add('hidden');
    document.getElementById('content-display').classList.remove('hidden');
}
</script>

<style>
.prose {
    line-height: 1.75;
}

.prose p {
    margin-bottom: 1rem;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\study\NIC\DGL-123(intoduction PHP)\php_project\php_project_\resources\views/normal-notes/show.blade.php ENDPATH**/ ?>