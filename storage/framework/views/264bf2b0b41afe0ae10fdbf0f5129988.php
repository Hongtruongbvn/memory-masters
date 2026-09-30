<?php $__env->startSection('title', 'Break Time - MemoryMaster'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
        <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-coffee text-orange-600 text-2xl"></i>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Break Time!</h1>
        <p class="text-gray-600 mb-6">Take a breather. Your break will be over in:</p>
        
        <div class="text-5xl font-bold text-orange-600 mb-8" id="break-timer"><?php echo e($breakTime); ?>:00</div>
        
        <p class="text-sm text-gray-500 mb-8">
            Relax, stretch, or grab some water. You'll continue automatically when the break is over.
        </p>

        <div class="flex justify-center space-x-4">
            <a href="<?php echo e(route('study.complete', $session)); ?>" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                End Session
            </a>
            <button onclick="skipBreak()" 
                    class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold">
                Skip Break
            </button>
        </div>
    </div>
</div>

<script>
let breakTime = <?php echo e($breakTime); ?>;
let secondsRemaining = breakTime * 60;
const timerElement = document.getElementById('break-timer');

function updateTimer() {
    const minutes = Math.floor(secondsRemaining / 60);
    const seconds = secondsRemaining % 60;
    timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    
    if (secondsRemaining <= 0) {
        window.location.href = '<?php echo e(route("study.resume-from-break", $session)); ?>';
    } else {
        secondsRemaining--;
        setTimeout(updateTimer, 1000);
    }
}

function skipBreak() {
    window.location.href = '<?php echo e(route("study.resume-from-break", $session)); ?>';
}

updateTimer();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\study\NIC\DGL-123(intoduction PHP)\php_project\php_project_\resources\views/study/break.blade.php ENDPATH**/ ?>