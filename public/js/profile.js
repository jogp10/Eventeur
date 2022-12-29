let date = new Date();
var d = document.querySelector('.days');

if (d != null) {
    console.log(d)
    //var days_aux = document.querySelector('.days').childNodes;
    //
    //localStorage.setItem("days_aux", days_aux)
    //
    //function check_element_in_array(array, elem) {
    //
    //    for (let i = 0; i < array.length; i++) {
    //        if (elem == array[i].innerHTML) {
    //            return true
    //        }
    //    }
    //
    //    return false;
    //}
    //
    //
    //function get_element_in_array(array, elem) {
    //
    //    for (let i = 0; i < array.length; i++) {
    //        if (elem == array[i].innerHTML) {
    //            return array[i]
    //        }
    //    }
    //
    //    return null;
    //}
    //

    const months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ]

    function renderCalendar() {

        let lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate()

        document.querySelector('.date > h3').innerHTML = months[date.getUTCMonth()]
        document.querySelector('.date > p').innerHTML = date.toDateString()


        let days = ""
        

        for (let i = 1; i <= lastDay; i++) {

            day = i

            if (i < 10) {
                day = '0' + i
            }

            

            //let id = i + "-" + date.getMonth(
            if (i == date.getUTCDate()) {
                days += `<div class="today border border-grey m-0 p-4">${day}</div>`
                continue
            }
            
            days += `<div class="border border-grey m-0 p-4">${day}</div>`

            monhtDays.innerHTML = days
        }

        console.log(monhtDays)
    }

    let monhtDays = document.querySelector('.days')

    if (monhtDays != null) {
        renderCalendar()
    }

    let prevButton = document.querySelector('.prev-month');
    
    if (prevButton != null) {
        prevButton.addEventListener('click', () => {
            date.setMonth(date.getMonth() - 1)
            days_aux = localStorage.getItem("days_aux")
            renderCalendar()
        })
    }

    let nextButton = document.querySelector('.next-month');
    if (nextButton != null) {
        nextButton.addEventListener('click', () => {
            date.setMonth(date.getMonth() + 1)
            days_aux = localStorage.getItem("days_aux")
            renderCalendar()
        })
    }
}

let eventsButton = document.querySelector('#see-invites-button')
let invitesButton = document.querySelector('#see-events-button')
let ticketsButton = document.querySelector('#see-tickets-button')
let profileInvites = document.getElementById('perfil-invites')
let profileEvents = document.getElementById('perfil-events')
let profileTickets = document.getElementById('perfil-tickets')


if (eventsButton != null) {
    eventsButton.addEventListener('click', () => {
        profileEvents.className = "visually-hidden"
        profileTickets.className = "visually-hidden"
        profileInvites.className = ""
        invitesButton.style.color = "grey"
        ticketsButton.style.color = "grey"
        eventsButton.style.color = "black"
    })
}

if (invitesButton != null) {
    invitesButton.addEventListener('click', () => {
        profileInvites.className = "visually-hidden"
        profileTickets.className = "visually-hidden"
        profileEvents.className = ""
        eventsButton.style.color = "grey"
        ticketsButton.style.color = "grey"
        invitesButton.style.color = "black"
    })
}

if (ticketsButton != null) {
    ticketsButton.addEventListener('click', () => {
        profileEvents.className = "visually-hidden"
        profileInvites.className = "visually-hidden"
        profileTickets.className = ""
        eventsButton.style.color = "grey"
        invitesButton.style.color = "grey"
        ticketsButton.style.color = "black"
    })
}



function truncateText(selector, maxLength) {
    var element = document.querySelector(selector), truncated = element.innerText;

    if (truncated.length > maxLength) {
        truncated = truncated.substr(0, maxLength) + '...';
    }

    return truncated;
}

let description = document.querySelector('#invite-event-description')

if (description != null) {
    description.innerHTML = truncateText('#invite-event-description', 150)
}
