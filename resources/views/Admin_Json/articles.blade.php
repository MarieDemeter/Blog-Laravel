<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div id="feed"></div>

    <script type='text/javascript'>
        fetch("http://blog-laravel.local/api/articles/")
            .then(
                response => response.json()
            ).then(
                printArticles
            ).catch(
                error
            )

        function printArticles(articles) {
            let feed = document.getElementById('feed');
            let html = '';

            for (article of articles['data']) {
                let article_content = article.content.substring(0, 500);

                html += `<div>
                    <a href="http://blog-laravel.local/json/dashboard/article/${article.id}">
                        <h2 class="text-2xl">${article.title}</h2>
                    </a>
                    <p>${article_content}</p>
                    <p class="text-center">Il y a ${article.comments_count} commentaire(s) sur cet article.</p>
                    <p class="text-right">${article.created_at}</p>
                    <br>
                </div>`;

                feed.innerHTML = html;
            }
        }

        function error(error) {
            console.log(error);
            let div = document.createElement("div");
            document.getElementById("feed").append(div);
            div.innerHTML = "Une erreur s'est produite";
        }
    </script>
</x-app-layout>