<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Questions') }}</h2>
    </x-slot>

    @php $defaultCategory = $categories->first(); @endphp

    <div x-data="{ categoryId: '{{ $defaultCategory->id }}' }">
        <!-- Filter by Category -->
        <div>
            <label>Filter by Category:</label>
            @foreach ($categories as $category)
                <label>
                    <input type="radio" name="category" :value="'{{ $category->id }}'" x-model="categoryId">
                    {{ $category->name }}
                </label>
            @endforeach
        </div>

        <!-- Toggle Button -->
        <div x-data="{ showCreate: false }">
            <button @click="showCreate = !showCreate">
                + Add Question
            </button>

            <!-- Add Question Form -->
            <div x-show="showCreate">
                @include('admin.partials.question-form', [
                    'action' => route('admin.questions.store'),
                    'method' => 'POST',
                ])
            </div>

        </div>


        <!-- Questions Grid -->
        <div>
            @foreach ($questions as $index => $question)
                <div x-show="categoryId == '{{ $question->category_id }}' ">
                    <h3>
                        {{ $question->question_type === 'text' ? $question->question_content : '[Image Question]' }}
                    </h3>

                    <ul>
                        @foreach ($question->choices as $idx => $choice)
                            <li class="{{ $choice->is_correct }}">
                                @if ($choice->choice_type === 'text')
                                    {{ $choice->choice_content }}
                                @else
                                    <img src="{{ asset('storage/' . $choice->choice_content) }}" alt="Choice">
                                @endif
                                @if ($choice->is_correct)
                                    <span>✔</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <div>
                        <div x-data="{ editing: false }">
                            <button @click="editing = !editing">Edit</button>

                            <div x-show="editing">
                                @include('admin.partials.question-form', [
                                    'question' => $question,
                                    'action' => route('admin.questions.update', $question),
                                    'method' => 'PATCH',
                                ])
                            </div>
                        </div>

                        <form action="{{ route('admin.questions.destroy', $question) }}" method="POST"
                            onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
