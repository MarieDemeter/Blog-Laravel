<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div>

        <h1 class='text-2xl'>{{$article->title}}</h1>
        <p>{{$article->content}}</p>
        <p class='font-bold'>{{$article->user->name}}</p>
        <p class="text-right">{{$article->created_at->diffForHumans()}}</p>
        <div class="text-center">
            <p>Il y a {{$article->comments_count}} commentaire(s) sur cet article.</p>
            @foreach($article->comments as $comment)
            <p>{{$comment->content}}</p>
            <p> De :
                @if($comment->user_id != null)
                {{$comment->user->name}}
                @else
                {{$comment->pseudo}}
                @endif
            </p>
            <div>
                <a href="{{ route('dashboard.comment.edit', $comment->id) }}">
                    <h2 class="text-2xl"> Modifier le commentaire</h2>
                </a>

                <form action="{{route('dashboard.comment.destroy', $comment->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input class="text-2xl" type="submit" value="Supprimer le commentaire">
                </form>

            </div>
            @endforeach
        </div>

        <div>
            <a href="{{ route('dashboard.article.edit', $article->id) }}">
                <h2 class="text-2xl"> Modifier l'article</h2>
            </a>

            <form action="{{route('dashboard.article.destroy', $article->id)}}" method="POST">
                @method('DELETE')
                @csrf
                <input class="text-2xl" type="submit" value="Supprimer l'article">
            </form>

        </div>

    </div>
</x-app-layout>