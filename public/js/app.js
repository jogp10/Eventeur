function addEventListeners() {
  let searchCard = document.querySelector('#searchuser_invite');
  if (searchCard != null) {
    window.addEventListener('load', sendSearchUserInviteRequest);
    searchCard.addEventListener('input', sendSearchUserInviteRequest);
  }

  let searchCard2 = document.querySelector('#searchuser_ticket');
  if (searchCard2 != null) {
    window.addEventListener('load', sendSearchUserTicketRequest);
    searchCard2.addEventListener('input', sendSearchUserTicketRequest);
  }

  let searchCard3 = document.querySelector('#searchusers');
  if (searchCard3 != null) {
    window.addEventListener('load', sendSearchUsersRequest);
    searchCard3.addEventListener('input', sendSearchUsersRequest);
  }

  let searchCard4 = document.querySelector('#searchattendee');
  if (searchCard4 != null) {
    window.addEventListener('load', sendSearchAttendeesRequest);
    searchCard4.addEventListener('input', sendSearchAttendeesRequest);
  }

  let submitInvites = document.getElementById("sendInvite");
  if (submitInvites != null) {
    submitInvites.addEventListener('click', sendInvitesRequest);
  }

  let submitTickets = document.getElementById("sendTicket");
  if (submitTickets != null) {
    submitTickets.addEventListener('click', sendTicketsRequest);
  }

  let submitRequest = document.getElementById("requestInvite");
  if (submitRequest != null) {
    submitRequest.addEventListener('click', sendRequestRequest);
  }
}

function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function (k) {
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

function sendSearchUserInviteRequest() {
  let search;
  if (this.value) search = this.value;
  else search = "";

  sendAjaxRequest('get', '/api/searchuser?search=' + search, { search: search }, searchUserInviteHandler);
}

function sendSearchUserTicketRequest() {
  let search;
  if (this.value) search = this.value;
  else search = "";

  sendAjaxRequest('get', '/api/searchuser?search=' + search, { search: search }, searchUserTicketHandler);
}

function sendSearchUsersRequest() {
  let search;
  if (this.value) search = this.value;
  else search = "";

  sendAjaxRequest('get', '/api/searchuser?search=' + search, { search: search }, searchUsersHandler);
}

function sendSearchAttendeesRequest() {
  let search;
  if (this.value) search = this.value;
  else search = "";
  const event_id = document.querySelector(".event").id;

  sendAjaxRequest('get', '/api/searchattendee?search=' + search + '&event_id=' + event_id, { search: search, }, searchAttendeesHandler);
}

function sendInvitesRequest(event) {
  var checked = document.querySelectorAll("#inviteModal td div svg:not(.hidden)");
  var event_id = document.querySelector(".event").id;

  var checkedArray = [];
  for (var i = 0; i < checked.length; i++) {
    let id = checked[i].parentElement.parentElement.parentElement.id;
    checkedArray.push(Number(id));
  }

  if (checkedArray.length > 0)
    sendAjaxRequest('post', '/api/invite/', { ids: checkedArray, event_id: event_id }, sendInviteHandler);
}

function sendRequestRequest(event) {
  // if (this.status != 200) window.location = '/';
  // user_id = document.querySelector(".user").id;
  event_id = document.querySelector(".event").id;

  sendAjaxRequest('post', '/api/request_join/', {event_id:event_id }, sendRequestHandler);
}

function sendTicketsRequest(event) {
  var checked = document.querySelectorAll("#giveticketModal td div svg:not(.hidden)");
  var event_id = document.querySelector(".event").id;

  var checkedArray = [];
  for (var i = 0; i < checked.length; i++) {
    let id = checked[i].parentElement.parentElement.parentElement.id;
    checkedArray.push(Number(id));
  }

  if (checkedArray.length > 0)
    sendAjaxRequest('post', '/api/ticket/', { ids: checkedArray, event_id: event_id }, sendTicketHandler);
}


function searchUserInviteHandler() {
  if (this.status != 200) window.location = '/';

  let users = JSON.parse(this.responseText);
  let new_rows = [];

  for (let i = 0; i < users.length; i++) {
    new_rows += createRow(users[i]);
  }

  let table = document.querySelector('#inviteModal tbody');

  if (users.length == 0) {
    table.innerHTML = '<tr><td colspan="8">No users found</td></tr>';
  } else {
    table.innerHTML = new_rows;
  }

  var tr = document.getElementsByTagName("tr");
  for (var i = 0; i < tr.length; i++) {
    tr[i].addEventListener('click', checks, false);
  }
}

function searchAttendeesHandler() {
  if (this.status != 200) window.location = '/';

  let users = JSON.parse(this.responseText);
  let new_rows = [];


  for (let i = 0; i < users.length; i++) {
    new_rows += createRow(users[i]);
  }

  let table = document.querySelector('#attendeeModal tbody');

  if (users.length == 0) {
    table.innerHTML = '<tr><td colspan="8">No users found</td></tr>';
  } else {
    table.innerHTML = new_rows;
  }
}

function searchUserTicketHandler() {
  if (this.status != 200) window.location = '/';

  let users = JSON.parse(this.responseText);
  let new_rows = [];


  for (let i = 0; i < users.length; i++) {
    new_rows += createRow(users[i]);
  }

  let table = document.querySelector('#giveticketModal tbody');

  if (users.length == 0) {
    table.innerHTML = '<tr><td colspan="3">No users found</td></tr>';
  } else {
    table.innerHTML = new_rows;
  }

  var tr = document.getElementsByTagName("tr");
  for (var i = 0; i < tr.length; i++) {
    tr[i].addEventListener('click', checks, false);
  }
}

function searchUsersHandler() {
  if (this.status != 200) window.location = '/';

  let users = JSON.parse(this.responseText);
  let new_rows = [];

  let url = window.location.href;
  url = url.substring(0, url.indexOf('/'));

  for (let i = 0; i < users.length; i++) {
    new_rows += createUserRow(users[i], url);
  }

  let sections = document.querySelector('#cards');

  if (users.length == 0) {
    sections.innerHTML = '<div><h3>No users found</h3></div>';
  } else {
    sections.innerHTML = new_rows;
  }
}

function sendInviteHandler() {
  if (this.status != 200) window.location = '/';

  let invites = JSON.parse(this.responseText);
}

function sendRequestHandler(){
  // if (this.status != 200) window.location = '/';

}

function sendTicketHandler() {
  if (this.status != 200) window.location = '/';

  let tickets = JSON.parse(this.responseText);
}

function createCard(card) {
  let new_card = document.createElement('article');
  new_card.classList.add('card');
  new_card.setAttribute('data-id', card.id);
  new_card.innerHTML = `

  <header>
    <h2><a href="cards/${card.id}">${card.name}</a></h2>
    <a href="#" class="delete">&#10761;</a>
  </header>
  <ul></ul>
  <form class="new_item">
    <input name="description" type="text">
  </form>`;

  let creator = new_card.querySelector('form.new_item');
  creator.addEventListener('submit', sendCreateItemRequest);

  let deleter = new_card.querySelector('header a.delete');
  deleter.addEventListener('click', sendDeleteCardRequest);

  return new_card;
}




function createRow(user) {
  let htmlView = '';
  htmlView += '<tr class="d-flex flex-row btn pb-1" id="' + user['id'] + '">';
  htmlView += ' <td>';
  htmlView += '   <img src="/images/profiles/perfil.png" class="rounded-circle img-fluid m-0 p-0" style="height:3rem; width:3.5rem" alt="...">';
  htmlView += ' </td>';
  htmlView += ' <td class="align-middle ps-2">';
  htmlView += '  <div class="d-flex flex-column">';
  htmlView += '    <span class="fw-bold">' + user['name'] + '</span>';
  htmlView += '  </div>';
  htmlView += ' </td>';
  htmlView += ' <td class="d-flex flex-fill justify-content-end">';
  htmlView += '   <div class="align-self-center">';
  htmlView += '    <svg xmlns="http://www.w3.org/2000/svg" style="height:22px" class="check hidden" width="56" height="16" fill="currentColor" viewBox="0 0 16 16">';
  htmlView += '      <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"></path>';
  htmlView += '    </svg>';
  htmlView += '  </div>';
  htmlView += ' </td>';
  htmlView += '</tr >';

  return htmlView;
}

function createUserRow(user, url) {
  const csrf = document.querySelector('meta[name="csrf-token"]').content;
  user['updated_at'] = user['updated_at'].substring(0, 10) + ' ' + user['updated_at'].substring(11, 19);

  let htmlView = '';
  htmlView += '<div class="card mb-3" style="max-width: 540px;">';
  htmlView += '  <div class="row g-0">';
  htmlView += '    <div class="col-md-4">';
  htmlView += '      <img src="/images/profiles/perfil.png" class="rounded-circle img-fluid rounded-start" alt="...">';
  htmlView += '    </div>';
  htmlView += '    <div class="col-md-8 d-flex flex-row">';
  htmlView += '      <div class="card-body col-md-8">';
  htmlView += '        <a href="' + url + '/profile/' + user['id'] + '">';
  htmlView += '        <h5 class="card-title">' + user['name'] + '</h5></a>';
  htmlView += '        <p class="card-text">' + user['email'] + '</p>';
  htmlView += '        <p class="card-text"><small class="text-muted">Last updated ' + user['updated_at'] + '</small></p>';
  htmlView += '      </div>';
  htmlView += '      <div class="col-md-4 d-flex flex-column justify-content-center">';
  htmlView += '        <p>Reports: ' + user['user']['reports'].length + '</p>';
  if (user['admin'] != null) { htmlView += '        <p>Bans: ' + user['admin']['bans'].length + '</p>'; };
  htmlView += '      <form class="pb-1" action="' + url + '/admin/users/' + user['id'] + '/edit" method="GET">'
  htmlView += '         <button type="submit" class="btn btn-warning">Edit</button></form>'
  if (user['banned'] != null) {
    htmlView += '      <form class="pb-1" action="' + url + '/admin/users/' + user['id'] + '/unban" method="POST">'
    htmlView += '<input type="hidden" name="_token" value="' + csrf + '">'
    htmlView += '<input type="hidden" name="user_id" value="' + user['id'] + '">'
    htmlView += '         <button type="submit" class="btn btn-danger">Unban</button></form>'
  } else {
    htmlView += '      <form class="pb-1" action="' + url + '/admin/users/' + user['id'] + '/ban" method="POST">'
    htmlView += '<input type="hidden" name="_token" value="' + csrf + '">'
    htmlView += '<input type="hidden" name="user_id" value="' + user['id'] + '">'
    htmlView += '         <button type="submit" class="btn btn-danger">Ban</button></form>'
  }
  htmlView += '      <form class="pb-1" action="' + url + '/admin/users/' + user['id'] + '/delete" method="POST">'
  htmlView += '<input type="hidden" name="_method" value="DELETE">'
  htmlView += '<input type="hidden" name="_token" value="' + csrf + '">'
  htmlView += '         <button type="submit" class="btn btn-danger">Delete</button></form>'
  htmlView += '    </div>';
  htmlView += '  </div>';
  htmlView += '</div>';
  htmlView += '</div>';

  return htmlView;
}

addEventListeners();




