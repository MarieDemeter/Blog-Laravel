<x-guest-layout>

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
            @endforeach
        </div>
    </div>
</x-guest-layout>