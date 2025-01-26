<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('News') }}
        </h2>
        @if(Auth::user()->admin)
        <a href="{{ route('news.create') }}" class="text-blue-500 hover:underline">
            Create a news
        </a>
        @endif
    </x-slot>

    @foreach($news as $newsItem)

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col gap-5">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $newsItem->title }}</h2>
                    <p>{{ $newsItem->content}}</p>
                    <p class="text-xs italic">Last updated: {{ $newsItem->updated_at->addHour()->format('M d, Y H:i') }} by {{ $newsItem->user_name }}</p>
                    @if(Auth::user()->admin || Auth::user()->id == $newsItem->user_id)
                    <div class="flex flex-row gap-3 mt-5">
                        <form action="{{ route('news.destroy', $newsItem->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Delete</x-danger-button>
                        </form>
                        @if(Auth::user()->id == $newsItem->user_id)
                        <form action="{{ route('news.edit', $newsItem->id) }}" >
                            @csrf
                            <x-button>Edit</x-button>
                        </form>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

    @endforeach
</x-app-layout>
