<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Questions') }}</h2>
    </x-slot>

    <div x-data="{ categoryId: null }">
        <!-- Category Filters -->
        <div class="mb-4">
            <label class="mr-2 font-semibold">Filter by Category:</label>
            <label><input type="radio" name="category" value="all" x-model="categoryId"> All</label>
            @foreach ($categories as $category)
                <label class="ml-4">
                    <input type="radio" name="category" :value="{{ $category->id }}" x-model="categoryId">
                    {{ $category->name }}
                </label>
            @endforeach
        </div>

        <!-- Questions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($questions as $question)
                <div class="p-4 border rounded shadow"
                    x-show="categoryId === null || categoryId === 'all' || categoryId == {{ $question->category_id }}">
                    <h3 class="font-bold">
                        {{ $question->question_type === 'text' ? $question->question_content : 'Image Question' }}
                    </h3>
                    <ul class="mt-2">
                        @foreach ($question->choices as $choice)
                            <li>
                                @if ($choice->choice_type === 'text')
                                    {{ $choice->choice_content }}
                                @else
                                    <img src="{{ asset('storage/' . $choice->choice_content) }}" alt="Choice"
                                        class="w-16 h-16">
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
