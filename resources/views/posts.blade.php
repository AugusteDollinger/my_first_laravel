<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>

        <a href="{{ route('posts.create') }}" class="text-blue-500 hover:underline">
            Create a new post
        </a>
    </x-slot>

    @foreach($posts as $post)
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col gap-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $post->title }}</h2>
                <p>{{ $post->content }}</p>
                <p class="text-xs italic">Last updated: {{ $post->updated_at->format('M d, Y H:i') }} by {{ $post->user_name }}</p>
                @if(Auth::user()->admin == true)
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-danger-button>Delete</x-danger-button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</x-app-layout>
