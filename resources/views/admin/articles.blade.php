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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>