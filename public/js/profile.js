let date = new Date();
var days_aux = document.querySelector('.days').childNodes;
localStorage.setItem("days_aux", days_aux)

console.log(">>>", days_aux)

function check_element_in_array(array, elem) {

    for(let i=0; i<array.length; i++) {
        if(elem == array[i].innerHTML) {
            return true
        }
    }

    return false;
}


function get_element_in_array(array, elem) {

    for(let i=0; i<array.length; i++) {
        if(elem == array[i].innerHTML) {
            return array[i]
        }
    }

    return null;
}

function renderCalendar() {
    
    let lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate()

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


    document.querySelector('.date > h3').innerHTML = months[date.getUTCMonth()]
    document.querySelector('.date > p').innerHTML = date.toDateString()


    let days = ""

    for (let i = 1; i <= lastDay; i++) {

        let day_aux = get_element_in_array(days_aux, i)
        let splited_date = null

        

        if(day_aux != null) {
            splited_date = day_aux.getAttribute("id")
            if(splited_date != null) {
                splited_date.split("-");
            }
        }

        //console.log(">", day_aux)

        //console.log(date)
        //console.log(">", date.getFullYear())
        //console.log(">", date.getMonth())

        if(splited_date != null && splited_date[0] == date.getFullYear() && splited_date[1] == date.getMonth()) {
            days += day_aux.outerHTML
        }
        else {

            let day = i

            if (i < 10) {
                day = '0' + i
            }

            //let id = i + "-" + date.getMonth()

            if (i == date.getUTCDate()) {
                days += `<div class="today border border-grey m-0 p-4">${day}</div>`
                continue
            }

            days += `<div class="border border-grey m-0 p-4">${day}</div>`
        }


        
    }

    monhtDays.innerHTML = days
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

        console.log()

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


let eventsButton = document.querySelector('#see-invites-button')
let invitesButton = document.querySelector('#see-events-button')
let profileInvites = document.getElementById('perfil-invites')
let profileEvents = document.getElementById('perfil-events')


eventsButton.addEventListener('click', () => {
    profileInvites.className = ""
    profileEvents.className = "visually-hidden"
    eventsButton.style.color = "black"
    invitesButton.style.color = "grey"
})


invitesButton.addEventListener('click', () => {
    profileEvents.className = ""
    profileInvites.className = "visually-hidden"
    eventsButton.style.color = "grey"
    invitesButton.style.color = "black"
})


function truncateText(selector, maxLength) {
    var element = document.querySelector(selector), truncated = element.innerText;
  
    if (truncated.length > maxLength) {
        truncated = truncated.substr(0, maxLength) + '...';
    }
    
    return truncated;
}
  
document.querySelector('#invite-event-description').innerText = truncateText('#invite-event-description', 150);




