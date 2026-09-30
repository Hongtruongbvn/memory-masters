@extends('layouts.app')

@section('title', 'Study - ' . $note->title . ' - MemoryMaster')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-4">
                @if($note->type === 'vocab')
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-green-600"></i>
                    </div>
                @elseif($note->type === 'formula')
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-square-root-alt text-purple-600"></i>
                    </div>
                @else
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-sticky-note text-blue-600"></i>
                    </div>
                @endif
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        @if($note->study_method && $nextReviewDate && $nextReviewDate->gt(now()))
                            Review: {{ $note->title }}
                        @else
                            Study: {{ $note->title }}
                        @endif
                    </h1>
                    <p class="text-gray-600">{{ $note->pages()->count() }} pages ready</p>
                    
                    @if($note->study_method)
                        @php
                            $methodConfig = \App\Helpers\StudyHelper::getMethodConfig($note->study_method);
                        @endphp
                        <div class="flex items-center space-x-2 mt-2">
                            <div class="w-6 h-6 bg-{{ $methodConfig['color'] }}-100 rounded flex items-center justify-center">
                                <i class="{{ $methodConfig['icon'] }} text-{{ $methodConfig['color'] }}-600 text-xs"></i>
                            </div>
                            <span class="text-sm text-gray-600">{{ $methodConfig['name'] }}</span>
                        </div>
                    @endif
                </div>
            </div>

            @if($note->study_method && $nextReviewDate && $nextReviewDate->gt(now()))
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-calendar-alt text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-800">Next Review Scheduled</h4>
                            <p class="text-blue-600 text-sm">
                                Your next review is scheduled for 
                                <strong>{{ $nextReviewDate->format('M d, Y') }}</strong>
                                ({{ $nextReviewDate->diffForHumans() }})
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($note->study_method)
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check-circle text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-green-800">Ready for Review</h4>
                            <p class="text-green-600 text-sm">It's time to review this note!</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if(!$note->study_method || ($nextReviewDate && $nextReviewDate->lte(now())) || !$nextReviewDate)
            <form method="POST" action="{{ route('study.start', $note->id) }}" class="space-y-6" 
                  id="study-form">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    @foreach($studyMethods as $key => $method)
                    <label class="relative cursor-pointer">
                        <input type="radio" name="study_method" value="{{ $key }}" 
                               class="hidden peer" 
                               {{ ($note->study_method === $key) ? 'checked' : ($key === 'SM2' ? 'checked' : '') }}>
                        <div class="border-2 border-gray-200 rounded-lg p-6 transition-all duration-300 
                                    hover:border-{{ $method['color'] }}-500 peer-checked:border-{{ $method['color'] }}-500 
                                    peer-checked:bg-{{ $method['color'] }}-50 h-full">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-10 h-10 bg-{{ $method['color'] }}-100 rounded-lg flex items-center justify-center">
                                    <i class="{{ $method['icon'] }} text-{{ $method['color'] }}-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $method['name'] }}</h3>
                                    <p class="text-sm text-gray-600">{{ $method['description'] }}</p>
                                </div>
                            </div>
                            <div class="text-xs text-{{ $method['color'] }}-600 mt-2">
                                <i class="fas fa-clock mr-1"></i>
                                Study: {{ $method['default_study_time'] }}min • Break: {{ $method['default_break_time'] }}min
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-200 pt-6">
                    <div>
                        <label for="study_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Study Time (minutes)
                        </label>
                        <input type="number" name="study_time" id="study_time" 
                               min="5" max="120" value="25"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>

                    <div>
                        <label for="break_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Break Time (minutes)
                        </label>
                        <input type="number" name="break_time" id="break_time" 
                               min="1" max="30" value="5"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                </div>

                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <a href="{{ route('notes.show', $note->id) }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        ← Back to Note
                    </a>
                    
                    <button type="submit"
                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold">
                        @if($note->study_method)
                            Start Review
                        @else
                            Start Studying
                        @endif
                    </button>
                </div>
            </form>
        @else
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Next Review Scheduled</h3>
                <p class="text-gray-600 mb-6">
                    Your next review is scheduled for <br>
                    <strong class="text-blue-600">{{ $nextReviewDate->format('l, F j, Y') }}</strong>
                </p>
                
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('notes.show', $note->id) }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Back to Note
                    </a>
                    
                    @if($nextReviewDate->lte(now()))
                        <form method="POST" action="{{ route('study.start-review', $note->id) }}">
                            @csrf
                            <button type="submit"
                                    class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold">
                                Start Review Now
                            </button>
                        </form>
                    @else
                        <button class="px-6 py-3 bg-gray-400 text-white rounded-lg cursor-not-allowed font-semibold"
                                disabled
                                title="Available on {{ $nextReviewDate->format('M d, Y') }}">
                            Start Review
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const studyMethodInputs = document.querySelectorAll('input[name="study_method"]');
    
    studyMethodInputs.forEach(input => {
        input.addEventListener('change', function() {
            const methodKey = this.value;
            const methods = @json($studyMethods);
            const method = methods[methodKey];
            
            if (method) {
                document.getElementById('study_time').value = method.default_study_time;
                document.getElementById('break_time').value = method.default_break_time;
            }
        });
    });
});
</script>
@endsection