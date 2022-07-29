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
                    <h1>Créer un nouvel article</h1>
                    <form action="{{route('dashboard.article.store')}}" method="POST">
                        @csrf

                        <div>
                            <label for="title">Titre de l'article :</label>
                            <input type="text" id="title" name="title" maxlength="255">
                        </div>

                        <div>
                            <label for="content">Contenu de l'article :</label>
                            <textarea id="content" name="content" maxlength="2000"></textarea>
                        </div>

                        <div>
                            <button class="font-bold" type="submit">Publier votre article</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>