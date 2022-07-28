<x-guest-layout>
    <div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-dropdown-link>
        </form>

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
        <form action="{{route('comment.store')}}" method="POST">
            @csrf

            <input type="hidden" name="article_id" value="{{ $article->id }}">
            @guest
            <div>
                <label for="pseudo">Votre pseudo :</label>
                <input type="text" id="pseudo" name="pseudo" maxlength="255">
            </div>

            <div>
                <label for="email">Votre email :</label>
                <input type="email" id="email" name="email" maxlength="255">
            </div>
            @endguest
            <div>
                <label for="content">Votre commentaire (max 2000 caractères) :</label>
                <textarea id="content" name="content" maxlength="2000"></textarea>
            </div>

            <div>
                <button class="font-bold" type="submit">Publier votre commentaire</button>
            </div>
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
</x-guest-layout>