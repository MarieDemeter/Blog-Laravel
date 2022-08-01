<x-guest-layout>
    <div id='feed'></div>
    <script type='text/javascript'>

        fetch("http://blog-laravel.local/api/article/1")
            .then(
                response => response.json()
            ).then(
                printArticles
            ).catch(
                error
            )

        function printArticles(articles) {
            for (article of articles['data']) {
                let div = document.createElement("div");
                let title = document.createElement("h1");
                title.className = 'texr-2xl';
                let content = document.createElement("p");


                title.innerHTML = article.title;
                content.innerHTML = article.content;

                div.append(title, content);
                document.getElementById("feed").append(div);

            }
        };

        function error(error) {
            console.log(error);
            let div = document.createElement("div");
            document.getElementById("feed").append(div);
            div.innerHTML = "Une erreur s'est produite";
        }
    </script>



</x-guest-layout>