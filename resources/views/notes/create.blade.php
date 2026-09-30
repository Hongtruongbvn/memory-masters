@extends('layouts.app')

@section('title', 'Create New Note - MemoryMaster')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Create New Note</h1>
            <p class="text-gray-600">Choose the type of note you want to create and start your learning journey.</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('notes.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <label class="relative cursor-pointer">
                    <input type="radio" name="type" value="normal" class="hidden peer" {{ old('type', 'normal') === 'normal' ? 'checked' : '' }}>
                    <div class="border-2 border-gray-200 rounded-lg p-6 transition-all duration-300 hover:border-blue-500 peer-checked:border-blue-500 peer-checked:bg-blue-50 h-full">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-sticky-note text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Normal Note</h3>
                        <p class="text-sm text-gray-600">General purpose notes for any subject</p>
                        <div class="mt-3 text-xs text-blue-600">
                            <i class="fas fa-check-circle mr-1"></i>
                            Up to 100 pages
                        </div>
                    </div>
                </label>

                <label class="relative cursor-pointer">
                    <input type="radio" name="type" value="vocab" class="hidden peer" {{ old('type') === 'vocab' ? 'checked' : '' }}>
                    <div class="border-2 border-gray-200 rounded-lg p-6 transition-all duration-300 hover:border-green-500 peer-checked:border-green-500 peer-checked:bg-green-50 h-full">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-book text-green-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Vocabulary</h3>
                        <p class="text-sm text-gray-600">Learn new words and their meanings</p>
                        <div class="mt-3 text-xs text-green-600">
                            <i class="fas fa-check-circle mr-1"></i>
                            Up to 50 pages
                        </div>
                    </div>
                </label>

                <label class="relative cursor-pointer">
                    <input type="radio" name="type" value="formula" class="hidden peer" {{ old('type') === 'formula' ? 'checked' : '' }}>
                    <div class="border-2 border-gray-200 rounded-lg p-6 transition-all duration-300 hover:border-purple-500 peer-checked:border-purple-500 peer-checked:bg-purple-50 h-full">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-square-root-alt text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Formulas</h3>
                        <p class="text-sm text-gray-600">Math and science formulas with explanations</p>
                        <div class="mt-3 text-xs text-purple-600">
                            <i class="fas fa-check-circle mr-1"></i>
                            Up to 50 pages
                        </div>
                    </div>
                </label>
            </div>

            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Note Title *    
                    </label>
                    <input type="text" name="title" id="title" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="Enter a descriptive title for your note"
                           value="{{ old('title') }}">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="subject-field" class="hidden">
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                        Subject *
                    </label>
                    <select name="subject" id="subject"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                        <option value="">Select a subject</option>
                        <option value="math" {{ old('subject') === 'math' ? 'selected' : '' }}>Mathematics</option>
                        <option value="physics" {{ old('subject') === 'physics' ? 'selected' : '' }}>Physics</option>
                        <option value="chemistry" {{ old('subject') === 'chemistry' ? 'selected' : '' }}>Chemistry</option>
                        <option value="biology" {{ old('subject') === 'biology' ? 'selected' : '' }}>Biology</option>
                        <option value="english" {{ old('subject') === 'english' ? 'selected' : '' }}>English</option>
                        <option value="other" {{ old('subject') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('subject')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description (Optional)
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                              placeholder="Describe what this note will contain">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('dashboard') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                    Create Note & Add Pages
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeInputs = document.querySelectorAll('input[name="type"]');
    const subjectField = document.getElementById('subject-field');

    function toggleSubjectField() {
        const selectedType = document.querySelector('input[name="type"]:checked').value;
        console.log('Selected type:', selectedType);
        
        if (selectedType === 'formula') {
            subjectField.classList.remove('hidden');
            document.getElementById('subject').required = true;
        } else {
            subjectField.classList.add('hidden');
            document.getElementById('subject').required = false;
        }
    }

    typeInputs.forEach(input => {
        input.addEventListener('change', toggleSubjectField);
    });

    toggleSubjectField();
});
</script>
@endsection