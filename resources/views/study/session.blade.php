
@extends('layouts.app')

@section('title', 'Studying - MemoryMaster')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-8 h-8 bg-{{ $methodConfig['color'] }}-100 rounded-lg flex items-center justify-center">
                    <i class="{{ $methodConfig['icon'] }} text-{{ $methodConfig['color'] }}-600 text-sm"></i>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-800">{{ $methodConfig['name'] }}</h2>
                    <p class="text-sm text-gray-600">{{ $note->title }}</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">Progress</div>
                <div class="text-lg font-bold text-{{ $methodConfig['color'] }}-600">
                    {{ $currentItem->queue_position }}/{{ $session->queueItems()->count() }}
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-6">
        <div class="max-w-2xl mx-auto text-center">
            <div id="front-content" class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">
                    @if($note->type === 'vocab') Term
                    @elseif($note->type === 'formula') Formula
                    @else Question @endif
                </h3>
                
                <div class="text-gray-800 text-xl mb-6">
                    @if($page->front_text)
                        @if($note->type === 'vocab')
                            <div class="font-bold text-2xl text-gray-900 mb-4">{{ $page->front_text }}</div>
                        @else
                            <p class="text-lg">{{ $page->front_text }}</p>
                        @endif
                    @endif
                    
                    @if($page->front_latex)
                        <div class="bg-gray-100 p-4 rounded font-mono text-sm my-4">
                            <div class="font-semibold text-xs text-gray-500 mb-2">LaTeX:</div>
                            {{ $page->front_latex }}
                        </div>
                    @endif
                    
                    @if($page->image_front)
                        <div class="my-4">
                            <img src="{{ Storage::url($page->image_front) }}" 
                                 alt="Front image" 
                                 class="max-w-full h-auto rounded-lg border border-gray-300 max-h-64 mx-auto study-image">
                        </div>
                    @endif
                </div>
            </div>

            <div id="back-content" class="hidden mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">
                    @if($note->type === 'vocab') Definition
                    @elseif($note->type === 'formula') Explanation
                    @else Answer @endif
                </h3>
                
                <div class="text-gray-800 text-lg mb-6">
                    @if($page->back_text)
                        <p class="mb-4">{{ $page->back_text }}</p>
                    @endif
                    
                    @if($page->back_latex)
                        <div class="bg-gray-100 p-4 rounded font-mono text-sm my-4">
                            <div class="font-semibold text-xs text-gray-500 mb-2">LaTeX:</div>
                            {{ $page->back_latex }}
                        </div>
                    @endif
                    
                    @if($page->image_back)
                        <div class="my-4">
                            <img src="{{ Storage::url($page->image_back) }}" 
                                 alt="Back image" 
                                 class="max-w-full h-auto rounded-lg border border-gray-300 max-h-64 mx-auto study-image">
                        </div>
                    @endif
                </div>
            </div>

            <div id="show-answer-control" class="mb-6">
                <button onclick="showAnswer()" 
                        class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                    Show Answer
                </button>
            </div>

            <div id="rating-controls" class="hidden">
                <h4 class="text-lg font-semibold text-gray-700 mb-4">How well did you know this?</h4>
                <div class="flex justify-center space-x-4 mb-6">
                    @foreach([0, 1, 2, 3, 4, 5] as $rating)
                        <button onclick="rateAnswer({{ $rating }})" 
                                class="w-12 h-12 rounded-full border-2 border-gray-300 hover:border-{{ $methodConfig['color'] }}-500 
                                       hover:bg-{{ $methodConfig['color'] }}-50 flex items-center justify-center 
                                       transition-colors rating-btn"
                                data-rating="{{ $rating }}">
                            {{ $rating }}
                        </button>
                    @endforeach
                </div>
                <div class="text-sm text-gray-600">
                    <span class="text-red-500">0-2: Again</span> • 
                    <span class="text-green-500">3-5: Good</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-5 gap-4 text-center">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="text-2xl font-bold text-{{ $methodConfig['color'] }}-600">{{ $currentItem->queue_position }}</div>
            <div class="text-sm text-gray-600">Current</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="text-2xl font-bold text-gray-800">{{ $session->queueItems()->count() }}</div>
            <div class="text-sm text-gray-600">Total</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="text-2xl font-bold text-green-600" id="live-minutes">{{ $totalMinutes }}</div>
            <div class="text-sm text-gray-600">Total Minutes</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="text-2xl font-bold text-blue-600" id="live-seconds">{{ $totalSeconds }}</div>
            <div class="text-sm text-gray-600">Total Seconds</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="text-2xl font-bold text-orange-600" id="study-timer">{{ $remainingStudyTime }}:00</div>
            <div class="text-sm text-gray-600">Study Time Left</div>
        </div>
    </div>
</div>

<style>
.hidden {
    display: none !important;
}

.rating-btn {
    transition: all 0.2s ease-in-out;
    font-weight: bold;
}

.rating-btn:hover {
    transform: scale(1.1);
}

.study-image {
    max-width: 100%;
    max-height: 300px;
    object-fit: contain;
}

.bg-blue-100 { background-color: #dbeafe; }
.border-blue-500 { border-color: #3b82f6; }
.bg-green-100 { background-color: #dcfce7; }
.border-green-500 { border-color: #22c55e; }
.bg-red-100 { background-color: #fee2e2; }
.border-red-500 { border-color: #ef4444; }
.bg-purple-100 { background-color: #f3e8ff; }
.border-purple-500 { border-color: #a855f7; }
.bg-orange-100 { background-color: #ffedd5; }
.border-orange-500 { border-color: #f97316; }
.text-blue-600 { color: #2563eb; }
.text-green-600 { color: #16a34a; }
.text-red-600 { color: #dc2626; }
.text-purple-600 { color: #9333ea; }
.text-orange-600 { color: #ea580c; }
</style>

<script>
let startTime = Date.now();
let answerShown = false;
let timerInterval;
let studyTimerInterval;

let totalSessionSeconds = {{ $totalMinutes * 60 + $totalSeconds }};
let studyTimeMinutes = {{ $studyTime }};
let studyTimeSeconds = studyTimeMinutes * 60;

function updateLiveTimer() {
    totalSessionSeconds++;
    
    const totalMinutes = Math.floor(totalSessionSeconds / 60);
    const totalSeconds = totalSessionSeconds % 60;
    
    document.getElementById('live-minutes').textContent = totalMinutes;
    document.getElementById('live-seconds').textContent = totalSeconds.toString().padStart(2, '0');
}

function updateStudyTimer() {
    studyTimeSeconds--;
    
    if (studyTimeSeconds <= 0) {
        saveCurrentTime();
        window.location.href = '{{ route("study.break", $session) }}';
        return;
    }
    
    const minutes = Math.floor(studyTimeSeconds / 60);
    const seconds = studyTimeSeconds % 60;
    document.getElementById('study-timer').textContent = minutes + ':' + seconds.toString().padStart(2, '0');
}

function saveCurrentTime() {
    fetch('{{ route("study.save-time", $session) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            total_seconds: totalSessionSeconds
        })
    });
}

timerInterval = setInterval(updateLiveTimer, 1000);
studyTimerInterval = setInterval(updateStudyTimer, 1000);

function showAnswer() {
    document.getElementById('front-content').classList.add('hidden');
    document.getElementById('back-content').classList.remove('hidden');
    document.getElementById('show-answer-control').classList.add('hidden');
    document.getElementById('rating-controls').classList.remove('hidden');
    answerShown = true;
    startTime = Date.now(); 
}

function rateAnswer(rating) {
    const responseTime = Math.floor((Date.now() - startTime) / 1000); 
    
    clearInterval(timerInterval);
    clearInterval(studyTimerInterval);
    
    saveCurrentTime();
    
    fetch('{{ route("study.review", $session) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            page_id: {{ $page->id }},
            quality: rating,
            response_time: responseTime,
            total_seconds: totalSessionSeconds 
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            if (data.completed) {
                window.location.href = data.redirect_url;
            } else {
                window.location.reload();
            }
        } else {
            throw new Error('Server returned error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error submitting review. Please try again.');
        timerInterval = setInterval(updateLiveTimer, 1000);
        studyTimerInterval = setInterval(updateStudyTimer, 1000);
    });
}

document.addEventListener('keydown', function(event) {
    if (event.code === 'Space' && !answerShown) {
        event.preventDefault();
        showAnswer();
    } else if (answerShown && event.code >= 'Digit0' && event.code <= 'Digit5') {
        event.preventDefault();
        const rating = parseInt(event.code.replace('Digit', ''));
        rateAnswer(rating);
    }
});

window.addEventListener('beforeunload', function() {
    saveCurrentTime(); 
    clearInterval(timerInterval);
    clearInterval(studyTimerInterval);
});

updateLiveTimer();
</script>
@endsection