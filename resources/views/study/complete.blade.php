@extends('layouts.app')

@section('title', 'Session Complete - MemoryMaster')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check text-green-600 text-2xl"></i>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Study Session Complete!</h1>
        <p class="text-gray-600 mb-8">Great job! You've completed your study session.</p>

        <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="text-2xl font-bold text-blue-600">{{ $totalReviews }}</div>
                <div class="text-sm text-gray-600">Cards Reviewed</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="text-2xl font-bold text-green-600">{{ round($averageQuality, 1) }}/5.0</div>
                <div class="text-sm text-gray-600">Average Rating</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-6">
                @php
                    $safeTotalTime = max(1, $session->total_seconds); 
                    $hours = floor($safeTotalTime / 3600);
                    $minutes = floor(($safeTotalTime % 3600) / 60);
                    $seconds = $safeTotalTime % 60;
                @endphp
                <div class="text-2xl font-bold text-purple-600">
                    @if($hours > 0)
                        {{ $hours }}h {{ $minutes }}m {{ $seconds }}s
                    @else
                        {{ $minutes }}m {{ $seconds }}s
                    @endif
                </div>
                <div class="text-sm text-gray-600">Total Time</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="text-2xl font-bold text-orange-600">{{ $session->note->title }}</div>
                <div class="text-sm text-gray-600">Note</div>
            </div>
        </div>

        <div class="flex justify-center space-x-4">
            <a href="{{ route('notes.show', $session->note_id) }}" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Back to Note
            </a>
            <a href="{{ route('study.show', $session->note_id) }}" 
               class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold">
                Study Again
            </a>
        </div>
    </div>
</div>
@endsection
