<x-guest-layout>
    <div id='feed'></div>
    <div id='pagination'></div>
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
            for (article of articles['data']) {
                let div = document.createElement("div");
                let title = document.createElement("a");
                title.setAttribute('href', 'http://blog-laravel.local/json/article/'.concat(article.id));
                let h1 = document.createElement("h1");
                h1.className = 'text-2xl';
                let content = document.createElement("p");
                let nb_of_comments = document.createElement("p");
                nb_of_comments.className = 'text-center';
                let time_ago = document.createElement("p");
                time_ago.className = "text-right";

                h1.innerHTML = article.title;
                title.append(h1);
                let article_content = article.content.substring(0, 500);
                content.innerHTML = article_content;
                nb_of_comments.innerHTML = "Il y a ".concat(' ', article.comments_count).concat(' ', "commentaire(s) sur cet article.");
                time_ago.innerHTML = article.created_at;


                div.append(title, content, nb_of_comments, time_ago);
                document.getElementById("feed").append(div);
            }

            // PAGINATION

            let div = document.createElement("div");

            for (let i = 0; i < articles['links'].length; i++) {
                let number = document.createElement('a');
                number.className = 'p-5';

                if (articles['links'][i]['url'] != null) {
                    let string = articles['links'][i]['url'].split("?");
                    console.log = string;
                    number.setAttribute('href', "http://blog-laravel.local/json?".concat(string[1]));
                }
                number.innerHTML = i;

                div.append(number);
                document.getElementById("pagination").append(div);
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