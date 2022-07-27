<x-guest-layout>
    <main>
        @foreach($articles as $article)
        <div>
            <h2 class="text-xl"> {{$article->title}} </h2>
            @php 
                $article = Str::limit($article->content, $limit = 500, $end = '(...)');
                $nbWordsArticle = Str::wordCount($article);
            @endphp
            <p> {{Str::words($article, $nbWordsArticle - 1, ' [...]')}} </p>
            </br>
        </div>
        @endforeach
        {{$articles->render()}}
    </main>
</x-guest-layout>