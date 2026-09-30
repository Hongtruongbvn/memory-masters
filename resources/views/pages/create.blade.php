@extends('layouts.app')

@section('title', 'Add Page - MemoryMaster')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Add New Page</h1>
                    <p class="text-gray-600">Add content to your note: "{{ $note->title }}"</p>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if($note->type === 'vocab') bg-green-100 text-green-800
                            @else bg-purple-100 text-purple-800 @endif">
                            <i class="fas 
                                @if($note->type === 'vocab') fa-book
                                @else fa-square-root-alt @endif mr-2"></i>
                            {{ ucfirst($note->type) }} Note
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500 mb-1">Progress</div>
                    <div class="flex items-center space-x-2">
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" 
                                 style="width: {{ min(($note->pages()->count() / $note->page_limit) * 100, 100) }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-700">
                            {{ $note->pages()->count() }}/{{ $note->page_limit }}
                        </span>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <form method="POST" action="{{ route('pages.store', $note->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">
                            @if($note->type === 'vocab') Term
                            @else Formula @endif
                        </h3>
                    </div>
                    
                    <div>
                        <label for="front_text" class="block text-sm font-medium text-gray-700 mb-2">
                            @if($note->type === 'vocab') Term *
                            @else Formula Description @endif
                        </label>

                        @if($note->type === 'vocab')
                        <input type="text" name="front_text" id="front_text" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="Enter the term or word"
                               value="{{ old('front_text') }}">
                        @else
                        <textarea name="front_text" id="front_text" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                  placeholder="Describe the formula (optional)">{{ old('front_text') }}</textarea>
                        @endif
                    </div>

                    @if($note->type === 'formula')
                    <div>
                        <label for="front_latex" class="block text-sm font-medium text-gray-700 mb-2">
                            LaTeX Formula (Optional)
                        </label>
                        <textarea name="front_latex" id="front_latex" rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors font-mono text-sm"
                                  placeholder="Enter LaTeX formula (e.g., E = mc^2)">{{ old('front_latex') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">For mathematical formulas and equations</p>
                    </div>
                    @endif

                    <div>
                        <label for="front_image" class="block text-sm font-medium text-gray-700 mb-2">
                            @if($note->type === 'formula') Formula Image
                            @else Term Image @endif (Optional)
                        </label>
                        
                        <div class="custom-file-input">
                            <input type="file" name="front_image" id="front_image" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                   class="file-input hidden">
                            <label for="front_image" class="file-input-label cursor-pointer">
                                <i class="fas fa-upload mr-2"></i>
                                <span class="file-input-text">Choose file</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Upload an image (max: 2MB)</p>
                        <div id="front-file-name" class="text-sm text-green-600 mt-1 hidden"></div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">
                            @if($note->type === 'vocab') Definition
                            @else Explanation @endif
                        </h3>
                    </div>
                    
                    <div>
                        <label for="back_text" class="block text-sm font-medium text-gray-700 mb-2">
                            @if($note->type === 'vocab') Definition *
                            @else Formula Explanation @endif
                        </label>
                        <textarea name="back_text" id="back_text" rows="4" @if($note->type === 'vocab') required @endif
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                  placeholder="@if($note->type === 'vocab') Enter the definition @else Explain the formula (optional) @endif">{{ old('back_text') }}</textarea>
                    </div>

                    @if($note->type === 'formula')
                    <div>
                        <label for="back_latex" class="block text-sm font-medium text-gray-700 mb-2">
                            LaTeX Formula (Optional)
                        </label>
                        <textarea name="back_latex" id="back_latex" rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors font-mono text-sm"
                                  placeholder="Enter LaTeX formula">{{ old('back_latex') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">For mathematical formulas and equations</p>
                    </div>
                    @endif

                    <div>
                        <label for="back_image" class="block text-sm font-medium text-gray-700 mb-2">
                            @if($note->type === 'formula') Explanation Image
                            @else Definition Image @endif (Optional)
                        </label>
                        
                        <div class="custom-file-input">
                            <input type="file" name="back_image" id="back_image" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                   class="file-input hidden">
                            <label for="back_image" class="file-input-label cursor-pointer">
                                <i class="fas fa-upload mr-2"></i>
                                <span class="file-input-text">Choose file</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Upload an image (max: 2MB)</p>
                        <div id="back-file-name" class="text-sm text-green-600 mt-1 hidden"></div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <div class="flex space-x-4">
                    <a href="{{ route('notes.show', $note->id) }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        ← Back to Note
                    </a>
                </div>
                
                <div class="flex space-x-4">
                    <button type="submit" name="add_another" value="true"
                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold">
                        Save & Add Another
                    </button>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        Save & Finish
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Preview</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 min-h-[200px]">
                <h4 class="font-semibold text-gray-700 mb-3">
                    @if($note->type === 'vocab') Term
                    @else Formula @endif
                </h4>
                <div id="front-preview" class="text-gray-600">
                    Content will appear here...
                </div>
                <div id="front-image-preview" class="mt-3"></div>
            </div>

            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 min-h-[200px]">
                <h4 class="font-semibold text-gray-700 mb-3">
                    @if($note->type === 'vocab') Definition
                    @else Explanation @endif
                </h4>
                <div id="back-preview" class="text-gray-600">
                    Content will appear here...
                </div>
                <div id="back-image-preview" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<style>
.custom-file-input {
    position: relative;
    display: inline-block;
    width: 100%;
}

.file-input-label {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 16px;
    background-color: #f9fafb;
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #6b7280;
    font-weight: 500;
}

.file-input-label:hover {
    background-color: #f3f4f6;
    border-color: #9ca3af;
    color: #374151;
}

.file-input-label:active {
    background-color: #e5e7eb;
}

.file-input-text {
    margin-left: 8px;
}

.file-name {
    margin-top: 8px;
    font-size: 14px;
    color: #059669;
}
#front-preview, #back-preview,
#front_text, #back_text,
#front_latex, #back_latex {
    max-width: 100%;
    overflow-wrap: break-word;
    word-wrap: break-word;
    word-break: break-word;
    white-space: pre-wrap;
}

textarea {
    resize: vertical;
    min-height: 80px;
}

#front-preview, #back-preview {
    max-height: 300px;
    overflow-y: auto;
    padding: 8px;
    border: 1px solid #e5e7eb;
    border-radius: 4px;
    background-color: #f9fafb;
}

.preview-image {
    max-width: 100%;
    max-height: 200px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const frontTextEl = document.getElementById('front_text');
    const backTextEl = document.getElementById('back_text');
    const frontLatex = document.getElementById('front_latex');
    const backLatex = document.getElementById('back_latex');
    const frontImage = document.getElementById('front_image');
    const backImage = document.getElementById('back_image');
    const frontPreview = document.getElementById('front-preview');
    const backPreview = document.getElementById('back-preview');
    const frontImagePreview = document.getElementById('front-image-preview');
    const backImagePreview = document.getElementById('back-image-preview');
    const frontFileName = document.getElementById('front-file-name');
    const backFileName = document.getElementById('back-file-name');

    function updatePreview() {
        let frontContent = '';
        if (frontTextEl && frontTextEl.value) {
            if ('{{ $note->type }}' === 'vocab') {
                frontContent = `<div class="font-bold text-xl break-words">${frontTextEl.value}</div>`;
            } else {
                frontContent = `<div class="break-words whitespace-pre-wrap">${frontTextEl.value}</div>`;
            }
        } else {
            frontContent = '<div class="text-gray-400">Content will appear here...</div>';
        }

        if (frontLatex && frontLatex.value) {
            frontContent += '<div class="mt-3 bg-gray-100 p-3 rounded font-mono text-sm break-words whitespace-pre-wrap">' + 
                           '<div class="font-semibold text-xs text-gray-500 mb-1">LaTeX:</div>' + 
                           frontLatex.value + '</div>';
        }

        frontPreview.innerHTML = frontContent;

        let backContent = '';
        if (backTextEl && backTextEl.value) {
            backContent = `<div class="break-words whitespace-pre-wrap">${backTextEl.value}</div>`;
        } else {
            backContent = '<div class="text-gray-400">Content will appear here...</div>';
        }
        
        if (backLatex && backLatex.value) {
            backContent += '<div class="mt-3 bg-gray-100 p-3 rounded font-mono text-sm break-words whitespace-pre-wrap">' + 
                          '<div class="font-semibold text-xs text-gray-500 mb-1">LaTeX:</div>' + 
                          backLatex.value + '</div>';
        }

        backPreview.innerHTML = backContent;
    }

    function handleImagePreview(input, previewElement, fileNameElement) {
        if (input && input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            
            if (fileNameElement) {
                fileNameElement.textContent = `Selected: ${file.name}`;
                fileNameElement.classList.remove('hidden');
            }
            
            reader.onload = function(e) {
                if (previewElement) {
                    previewElement.innerHTML = `<img src="${e.target.result}" class="preview-image max-w-full h-auto" alt="Preview">`;
                }
            }
            reader.readAsDataURL(file);
        } else {
            if (fileNameElement) fileNameElement.classList.add('hidden');
            if (previewElement) previewElement.innerHTML = '';
        }
    }

    function handleFileInputChange(input, fileNameElement) {
        if (input && input.files && input.files[0]) {
            const file = input.files[0];
            if (fileNameElement) {
                fileNameElement.textContent = `Selected: ${file.name}`;
                fileNameElement.classList.remove('hidden');
            }
        } else {
            if (fileNameElement) fileNameElement.classList.add('hidden');
        }
    }

    if (frontTextEl) frontTextEl.addEventListener('input', updatePreview);
    if (backTextEl) backTextEl.addEventListener('input', updatePreview);
    if (frontLatex) frontLatex.addEventListener('input', updatePreview);
    if (backLatex) backLatex.addEventListener('input', updatePreview);

    if (frontImage) {
        frontImage.addEventListener('change', function() {
            handleFileInputChange(this, frontFileName);
            handleImagePreview(this, frontImagePreview, frontFileName);
        });
    }

    if (backImage) {
        backImage.addEventListener('change', function() {
            handleFileInputChange(this, backFileName);
            handleImagePreview(this, backImagePreview, backFileName);
        });
    }

    updatePreview();
});
</script>
@endsection