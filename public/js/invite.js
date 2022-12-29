// Get the modal
var modal = document.getElementsByClassName("modal")[0];
var modal2 = document.getElementsByClassName("modal")[1];
var modal3 = document.getElementsByClassName("modal")[2];

// Get the button that opens the modal
var btn = document.getElementById("invite");
var btn2 = document.getElementById("giveticket");
var btn3 = document.getElementById("attendees");
var sbmt1 = document.getElementById("sendInvite");
var sbmt2 = document.getElementById("sendTicket");

// Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
if (btn != null) {
  btn.onclick = function () {
    modal.style.display = "block";
  }
}

if (btn2 != null) {
  btn2.onclick = function () {
    modal2.style.display = "block";
  }
}

if (btn3 != null) {
  btn3.onclick = function () {
    modal3.style.display = "block";
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

var tr = document.getElementsByTagName("#inviteModal tr");
var tr2 = document.getElementsByTagName("#giveticketModal tr");

for (var i = 0; i < tr.length; i++) {
  tr[i].addEventListener('click', checks, false);
}

for (var i = 0; i < tr2.length; i++) {
  tr2[i].addEventListener('click', checks, false);
}

function checks(e) {
  let target = e.target;
  while (target.tagName != "TR") {
    target = target.parentNode;
  }

  var check = target.querySelector('td div svg');
  check.classList.toggle("hidden");
};
