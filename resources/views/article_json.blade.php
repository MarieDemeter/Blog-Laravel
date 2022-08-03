<x-guest-layout>
    <div id='feed'></div>
    <script type='text/javascript'>
        const queryString = window.location.href;
        const urlParamPage = queryString.split("json/article/");

        fetch("http://blog-laravel.local/api/articles/".concat(urlParamPage[1]))
            .then(
                response => response.json()
            ).then(
                printArticle
            ).catch(
                error
            )

        function printArticle(article) {

            let div = document.createElement("div");
            let title = document.createElement("h1");
            title.className = 'text-2xl';
            let content = document.createElement("p");
            let author = document.createElement('p');
            author.className = 'font-bold';
            let commentsDiv = document.createElement("div");
            let nb_of_comments = document.createElement("p");
            commentsDiv.className = 'text-center';
            let timeAgo = document.createElement("p");
            timeAgo.className = "text-right";

            title.innerHTML = article.title;
            content.innerHTML = article.content;
            author.innerHTML = article.user.name;
            nb_of_comments.innerHTML = "Il y a ".concat(' ', article.comments.length).concat(' ', "commentaire(s) sur cet article.");
            timeAgo.innerHTML = article.created_at;

            commentsDiv.append(nb_of_comments);

            for (comment of article.comments) {
                let commentDiv = document.createElement("div");
                let commentContent = document.createElement("p");
                let commentAuthor = document.createElement("p");

                commentContent.innerHTML = comment.content;

                if (comment.user != null) {
                    commentAuthor.innerHTML = "De :".concat(' ', comment.user.name);

                } else {
                    commentAuthor.innerHTML = "De :".concat(' ', comment.pseudo);
                }
                commentDiv.append(commentContent, commentAuthor);
                commentsDiv.append(commentDiv);
            }

            //FORMULAIRE

            let form = document.createElement("form");
            //            form.setAttribute('method','POST');

            let divPseudo = document.createElement("div");
            let labelPseudo = document.createElement("label");
            labelPseudo.setAttribute('for', 'pseudo');
            labelPseudo.innerHTML = "Votre pseudo : ";
            let inputPseudo = document.createElement("input");
            inputPseudo.setAttribute('type', 'text');
            inputPseudo.setAttribute('id', 'pseudo');
            inputPseudo.setAttribute('name', 'pseudo');
            divPseudo.append(labelPseudo, inputPseudo);

            let divEmail = document.createElement("div");
            let labelEmail = document.createElement("label");
            labelEmail.setAttribute('for', 'email');
            labelEmail.innerHTML = "Votre email : ";
            let inputEmail = document.createElement("input");
            inputEmail.setAttribute('type', 'email');
            inputEmail.setAttribute('id', 'email');
            inputEmail.setAttribute('name', 'email');
            divEmail.append(labelEmail, inputEmail);


            let divContent = document.createElement("div");
            let labelContent = document.createElement("label");
            labelContent.setAttribute('for', 'content');
            labelContent.innerHTML = "Votre commentaire (max 2000 caractères) : ";
            let inputContent = document.createElement("textarea");
            inputContent.setAttribute('id', 'content');
            inputContent.setAttribute('name', 'content');
            divContent.append(labelContent, inputContent);


            let divButton = document.createElement("div");
            let submitButton = document.createElement("button");
            submitButton.className = "font-bold";
            submitButton.innerHTML = "Publier votre commentaire";
            submitButton.setAttribute('type', 'submit');
            submitButton.setAttribute('id', 'submit');
            divButton.append(submitButton);

            submitButton.addEventListener("click", function(e) {
                e.preventDefault();
                sendFormData(article.id);
            })

            form.append(divPseudo, divEmail, divContent, divButton);

            div.append(title, content, author, timeAgo, commentsDiv, form);
            document.getElementById("feed").append(div);
        }

        function sendFormData(articleId) {
            let pseudo = document.getElementById("pseudo");
            let email = document.getElementById("email");
            let content = document.getElementById('content');

            let data = {
                article_id: articleId,
                pseudo: pseudo.value,
                email: email.value,
                content: content.value,
                _token: '{{ csrf_token() }}',
            };

            fetch("http://blog-laravel.local/api/comments/", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(data),
                })
                .then(
                    response => response.json()
                ).then(
                    location.reload()
                ).catch(
                    error
                );
        }

        function error(error) {
            console.log(error);
            let div = document.createElement("div");
            document.getElementById("feed").append(div);
            div.innerHTML = "Une erreur s'est produite";
        }
    </script>



</x-guest-layout>