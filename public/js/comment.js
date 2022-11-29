// Get the comment form button
var commentFormButton = document.getElementById('comment-button');

// When the user click on the button, create new comment form
if (commentFormButton != null) {
    commentFormButton.addEventListener('click', () => {
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        let htmlView = `
        <div class="comment-form">
            <form action="{{ route('api/comment', ['event' => $event]) }}" method="POST">
                <input type="hidden" name="_token" value="'` + csrf + `'">
                <textarea name="content" id="comment-content" cols="30" rows="10" placeholder="Escreva aqui o seu comentário..."></textarea>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
        `;
        
        var commentForm = document.createElement('form');
        commentForm.className = 'comment-form';
        commentForm.action = '/comment';
        commentForm.method = 'POST';

        var commentInput = document.createElement('input');
        commentInput.className = 'comment-input';
        commentInput.type = 'text';
        commentInput.name = 'comment';
        commentInput.placeholder = 'Escreva um comentário...';

        var commentSubmit = document.createElement('input');
        commentSubmit.className = 'comment-submit';
        commentSubmit.type = 'submit';
        commentSubmit.value = 'Comentar';

        commentForm.appendChild(commentInput);
        commentForm.appendChild(commentSubmit);

        var divForm = document.createElement('div');
        divForm.innerHTML = htmlView;

        var comments = document.getElementById('comments');
        comments.insertBefore(divForm, comments.firstChild);
    })
}