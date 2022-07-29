<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h2>Formulaire de modification du commentaire en DB :</h2>

                    <form action="{{route('dashboard.comment.update', $comment->id)}}" method="POST">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $comment->article_id }}">

                        <div>
                            <label for="content">Contenu du commentaire :</label>
                            <textarea name="content">{{$comment->content}}</textarea>
                        </div>

                        <input type="submit" value="Envoyer">
                    </form>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>