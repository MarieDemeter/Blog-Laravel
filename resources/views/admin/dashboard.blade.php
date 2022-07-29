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
                    <a href="{{route('dashboard.articles')}}">
                        <h2 class="text-2xl"> Voir tout les articles, les modifier ou supprimer</h2>
                    </a>
                    <a href="{{route('dashboard.article.create')}}">
                        <h2 class="text-2xl"> Créer un nouvel article</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>