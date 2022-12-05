// Get the comment form button
var answerFormButtons = document.getElementsByClassName('event_comment');

if (answerFormButtons.length > 0) {
  for (var i = 0; i < answerFormButtons.length; i++) {
    answerFormButtons[i].addEventListener('click', function (event) {
        event.preventDefault();
        var answerForm = document.querySelector('#comment_' + this.id + '_form');
        answerForm.classList.toggle('d-none');
    });
  }
}

var commentFormButton = document.querySelector('#comment-button');

if (commentFormButton) {
    commentFormButton.addEventListener('click', function (event) {
        event.preventDefault();
        var commentForm = document.querySelector('#comment_form');
        commentForm.classList.toggle('d-none');
    });
}

// When the user click on the button, display new comment form
