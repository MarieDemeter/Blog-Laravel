<x-guest-layout>
    <main>
        @foreach($articles as $article)
        <div>
            <h2 class="text-xl"> {{$article->title}} </h2>
            @php 
                $nbOfComments = $article->comments()->count();
                $article = Str::limit($article->content, $limit = 500, $end = '(...)');
                $nbWordsArticle = Str::wordCount($article);
            @endphp
            <p> {{Str::words($article, $nbWordsArticle - 1, ' [...]')}} </p>
            <p class="text-center">Il y a {{$nbOfComments}} sur cet article.</p>
            </br>
        </div>
        @endforeach
        {{$articles->render()}}
    </main>
</x-guest-layout>