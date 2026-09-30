@extends('layouts.app')

@section('title', 'Review Sessions - MemoryMaster')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Review Sessions</h1>
        
        @if($reviewSessions->count() > 0)
            <div class="space-y-4">
                @foreach($reviewSessions as $session)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">{{ $session->note->title }}</h3>
                                <p class="text-sm text-gray-600">
                                    {{ $session->due_count }} cards due for review
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Last studied: {{ $session->updated_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="px-3 py-1 bg-orange-100 text-orange-800 text-sm font-medium rounded-full">
                                    {{ $session->due_count }} due
                                </span>
                                <form action="{{ route('study.start-review', $session) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold text-sm">
                                        Start Review
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">All caught up!</h3>
                <p class="text-gray-600">No cards due for review. Great job! 🎉</p>
                <a href="{{ route('dashboard') }}" 
                   class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Back to Dashboard
                </a>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Ongoing Sessions</h2>
        
        @php
            $ongoingSessions = \App\Models\StudySession::where('user_id', AuthHelper::id())
                ->whereNull('ended_at')
                ->with('note')
                ->get();
        @endphp
        
        @if($ongoingSessions->count() > 0)
            <div class="space-y-3">
                @foreach($ongoingSessions as $session)
                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                        <div>
                            <h4 class="font-medium text-gray-800">{{ $session->note->title }}</h4>
                            <p class="text-sm text-gray-600">Started {{ $session->started_at->diffForHumans() }}</p>
                        </div>
                        <a href="{{ route('study.session', $session) }}" 
                           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-semibold">
                            Continue
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600 text-center py-4">No ongoing sessions</p>
        @endif
    </div>
</div>
@endsection