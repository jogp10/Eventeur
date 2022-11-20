const date = new Date();

function renderCalendar() {

    const monhtDays = document.querySelector('.days')
    const lastDay = new Date(date.getFullYear(), date.getMonth()+1, 0).getDate()

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

    for(let i=1; i<=lastDay; i++) {

        let day = i

        if(i < 10) {
            day = '0' + i
        }
        if(i == date.getUTCDate()) {
            days += `<div class="today border border-grey m-0 p-4">${day}</div>`
            continue
        }

        days += `<div class="border border-grey m-0 p-4">${day}</div>`
    }

    monhtDays.innerHTML = days
}


renderCalendar()


const prevButton = document.querySelector('.prev-month');
prevButton.addEventListener('click', () => {
    date.setMonth(date.getMonth()-1)
    renderCalendar()
})


const nextButton = document.querySelector('.next-month');
nextButton.addEventListener('click', () => {
    date.setMonth(date.getMonth()+1)
    renderCalendar()
})


function truncateText(selector, maxLength) {
    var element = document.querySelector(selector), truncated = element.innerText;
  
    if (truncated.length > maxLength) {
        truncated = truncated.substr(0, maxLength) + '...';
    }
    
    return truncated;
    }
  
document.querySelector('#invite-event-description').innerText = truncateText('#invite-event-description', 150);
  
