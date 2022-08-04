<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div id="feed"></div>

    <script type='text/javascript'>
        const queryString = window.location.href;
        const urlParamPage = queryString.split("json/dashboard/article/");

        fetch("http://blog-laravel.local/api/articles/".concat(urlParamPage[1]))
            .then(
                response => response.json()
            ).then(
                printArticle
            ).catch(
                error
            )

        function printArticle(article) {
            let feed = document.getElementById('feed');
            let html = '';

            html += `<div>
                        <h1 class="text-2xl">${article.title}</h1>
                        <p>${article.content}</p>
                        <p class="font-bold">${article.user.name}</p>
                        <p class="text-right">${article.created_at}</p>
                        <div class="text-center">
                            <p>Il y a ${article.comments.length} commentaire(s) sur cet article.</p>
                        </div>

                        <div>
                            <a href="http://blog-laravel.local/json/dashboard/article/${article.id}/edit">
                                <h2 class="text-2xl"> Modifier l'article</h2>
                            </a>

                            <form>
                                <input class="text-2xl" type="submit" id="submitDelete" value="Supprimer l'article">
                            </form>
                        </div>
                    </div>`;


            feed.innerHTML = html;

            buttonDelete = document.getElementById("submitDelete");
            buttonDelete.addEventListener("click", function(e) {
                e.preventDefault();
                DeleteArticle(article);
            });
        }

        function DeleteArticle(article) {
            fetch("/api/dashboard/articles/".concat(article.id), {
                    method: "DELETE",
                })
                .then(
              //      setTimeout('redirect()', 1000)
                ).catch(
                    error
                );
        }

        function redirect() {
            document.location.href="http://blog-laravel.local/json/dashboard/articles"
        }

        function error(error) {
            console.log(error);
            let div = document.createElement("div");
            document.getElementById("feed").append(div);
            div.innerHTML = "Une erreur s'est produite";
        }
    </script>
</x-app-layout>