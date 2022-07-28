<x-guest-layout>
    @foreach($articles as $article)
    <div>
        <a href="{{route('article', $article->id)}}">
            <h2 class="text-2xl"> {{$article->title}} </h2>
        </a>
        @php
        $articlePrint = Str::limit($article->content, $limit = 500, $end = '(...)');
        $nbWordsArticle = Str::wordCount($article);
        @endphp
        <p> {{Str::words($articlePrint, $nbWordsArticle - 1, ' [...]')}} </p>
        <p class="text-center">Il y a {{$article->comments_count}} commentaire(s) sur cet article.</p>
        <p class="text-right">{{$article->created_at->diffForHumans()}}</p>
        </br>
    </div>
    @endforeach
    {{$articles->links()}}
</x-guest-layout>