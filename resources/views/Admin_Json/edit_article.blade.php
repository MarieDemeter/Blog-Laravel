<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div id="feed">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h2>Formulaire de modification de l'article {{$article->title}} en DB :</h2>

                    <form>
                        <div>
                            <label for="title">Titre de l'article :</label>
                            <input type="text" name="title" id="title" value="{{$article->title}}">
                        </div>
                        <div>
                            <label for="content">Contenu de l'article :</label>
                            <textarea id="content" name="content">{{$article->content}}</textarea>
                        </div>
                        <input type="submit" id="submitUpdate" value="Envoyer">
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script type='text/javascript'>

        buttonUpdate = document.getElementById("submitUpdate");
        buttonUpdate.addEventListener("click", function(e) {
            e.preventDefault();
            updateArticle();
        });


        function updateArticle() {

            let title = document.getElementById("title");
            let content = document.getElementById('content');

            let data = {
                title: title.value,
                content: content.value,
                _token: '{{ csrf_token() }}',
            };

            fetch("/api/dashboard/article/{{$article->id}}", {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(data),
                })
                .then(
                    response => response.json()
                ).then(
                    // setTimeout('redirect()', 1000)
                ).catch(
                    error
                )
        }

        function redirect() {
            document.location.href = "http://blog-laravel.local/json/dashboard/articles"
        }

        function error(error) {
            console.log(error);
            let div = document.createElement("div");
            document.getElementById("feed").append(div);
            div.innerHTML = "Une erreur s'est produite";
        }
    </script>
</x-app-layout>