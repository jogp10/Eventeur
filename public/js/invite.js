// Get the modal
var modal = document.getElementsByClassName("modal")[0];

// Get the button that opens the modal
var btn = document.getElementById("invite");

// Get the <span> element that closes the modal
//var span = document.getElementsByClassName("close")[0];

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// When the user clicks on the button, open the modal
if (btn != null) {
  btn.onclick = function () {
    modal.style.display = "block";
  }
}

/*
// When the user clicks on <span> (x), close the modal
span.onclick = function () {
  modal.style.display = "none";
}

modal.addEventListener('shown.bs.modal', () => {
  span.focus()
})*/

var tr = document.getElementsByTagName("tr");


for (var i = 0; i < tr.length; i++) {
  tr[i].addEventListener('click', checks, false);
}

function checks(e) {
  let target = e.target;
  while (target.tagName != "TR") {
    target = target.parentNode;
  }

  var check = target.querySelector('td div svg');
  check.classList.toggle("hidden");
};


