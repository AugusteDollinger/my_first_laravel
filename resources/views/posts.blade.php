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
                <p class="text-xs italic">Last updated: {{ $post->updated_at->addHour()->format('M d, Y H:i') }} by {{ $post->user_name }}</p>
                <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->title }}" onclick="showimage('{{ asset('storage/images/' . $post->image) }}')" class="w-full h-64 object-cover rounded-3xl">
                @if(Auth::user()->admin == true || Auth::user()->id == $post->user_id)
                    <div class="flex flex-row gap-3 mt-5">
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Delete</x-danger-button>
                        </form>
                        @if(Auth::user()->id == $post->user_id)
                        <form action="{{ route('posts.edit', $post->id) }}">
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
    <script>
        function showimage(path) {
            let bg = document.createElement('div');
            bg.style.width = '100%';
            bg.style.height = '100%';
            bg.style.position = 'fixed';
            bg.style.top = '0';
            bg.style.left = '0';
            bg.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            bg.setAttribute('onclick', 'this.remove()');

            let img = document.createElement('img');
            img.src = path;
            img.style.width = '30%';
            img.style.height = 'auto';
            img.style.position = 'fixed';
            img.style.top = '50%';
            img.style.left = '50%';
            img.style.transform = 'translate(-50%, -50%)';

            bg.appendChild(img);
            document.body.appendChild(bg);
        }
    </script>
</x-app-layout>
