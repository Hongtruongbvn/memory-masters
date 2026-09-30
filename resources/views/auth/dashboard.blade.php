@extends('layouts.app')

@section('title', 'Dashboard - MemoryMaster')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <section class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">
                Welcome back, {{ session('user')['name'] ?? 'User' }}!
            </h2>
            <p class="text-xl text-gray-600 mb-8">
                Continue your memory mastery journey with our legendary techniques.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('home') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                    ← Back to Home
                </a>
                <a href="{{ route('notes.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    + Create New Note
                </a>
            </div>
        </section>

        <section class="bg-white rounded-lg shadow-sm p-6 mb-8 border border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Your Notes</h3>
                <a href="{{ route('notes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-semibold">
                    + New Note
                </a>
            </div>

            @if($notes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($notes as $note)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-2">
                                    @if($note->type === 'vocab')
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-book text-green-600 text-sm"></i>
                                        </div>
                                    @elseif($note->type === 'formula')
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-square-root-alt text-purple-600 text-sm"></i>
                                        </div>
                                    @else
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-sticky-note text-blue-600 text-sm"></i>
                                        </div>
                                    @endif
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full 
                                        {{ $note->type === 'vocab' ? 'bg-green-100 text-green-800' : 
                                           ($note->type === 'formula' ? 'bg-purple-100 text-purple-800' : 
                                           'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst($note->type) }}
                                    </span>
                                </div>
                                
                                @if($note->study_method && $note->next_review_at)
                                    @if($note->next_review_at->gt(now()))
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full" 
                                              title="Next review: {{ $note->next_review_at->format('M d, Y') }}">
                                            Review: {{ $note->next_review_at->format('M d') }}
                                        </span>
                                    @else
                                        <span class="text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full">
                                            Ready for Review
                                        </span>
                                    @endif
                                @elseif($note->is_completed)
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Completed</span>
                                @else
                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">In Progress</span>
                                @endif
                            </div>
                            
                            <h4 class="font-semibold text-gray-800 mb-2">{{ $note->title }}</h4>
                            @if($note->description)
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $note->description }}</p>
                            @endif
                            
                            @if($note->study_method)
                                @php
                                    $studyMethods = app('App\Http\Controllers\StudyController')->getStudyMethods();
                                    $methodConfig = $studyMethods[$note->study_method] ?? $studyMethods['SM2'];
                                @endphp
                                <div class="flex items-center space-x-2 mb-3">
                                    <div class="w-4 h-4 bg-{{ $methodConfig['color'] }}-100 rounded flex items-center justify-center">
                                        <i class="{{ $methodConfig['icon'] }} text-{{ $methodConfig['color'] }}-600 text-xs"></i>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $methodConfig['name'] }}</span>
                                </div>
                            @endif
                            
                            @if($note->type !== 'normal')
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                    <span>{{ $note->pages->count() }}/{{ $note->page_limit }} pages</span>
                                    <span>{{ $note->created_at->format('M d, Y') }}</span>
                                </div>
                            @else
                                <div class="text-sm text-gray-500 mb-3">
                                    <span>{{ $note->created_at->format('M d, Y') }}</span>
                                </div>
                            @endif
                            
                            <div class="flex space-x-2">
                                <a href="{{ $note->type === 'normal' ? route('normal-notes.show', $note->id) : route('notes.show', $note->id) }}" 
                                   class="flex-1 bg-gray-100 text-gray-700 text-center py-2 rounded hover:bg-gray-200 transition-colors text-sm">
                                    View
                                </a>
                                @if(!$note->is_completed && $note->type !== 'normal')
                                    <a href="{{ route('pages.create', $note->id) }}" 
                                       class="flex-1 bg-blue-100 text-blue-700 text-center py-2 rounded hover:bg-blue-200 transition-colors text-sm">
                                        Add Page
                                    </a>
                                @endif
                                @if($note->type !== 'normal')
                                    @if($note->study_method && $note->next_review_at && $note->next_review_at->gt(now()))
                                        <a href="{{ route('study.show', $note->id) }}" 
                                           class="flex-1 bg-orange-100 text-orange-700 text-center py-2 rounded hover:bg-orange-200 transition-colors text-sm">
                                            Review
                                        </a>
                                    @else
                                        <a href="{{ route('study.show', $note->id) }}" 
                                           class="flex-1 bg-green-100 text-green-700 text-center py-2 rounded hover:bg-green-200 transition-colors text-sm">
                                            Study
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sticky-note text-gray-400 text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-600 mb-2">No notes yet</h4>
                    <p class="text-gray-500 mb-6">Create your first note to start learning</p>
                    <a href="{{ route('notes.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        Create Your First Note
                    </a>
                </div>
            @endif
        </section>
    </div>
@endsection