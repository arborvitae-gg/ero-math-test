<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Questions') }}</h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($questions as $question)
            <div class="p-4 border rounded shadow">
                <h3 class="font-bold">
                    {{ $question->question_type === 'text' ? $question->question_content : 'Image Question' }}</h3>
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
</x-app-layout>
