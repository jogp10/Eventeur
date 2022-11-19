let date = new Date();

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

        let day = i

        if (i < 10) {
            day = '0' + i
        }
        if (i == date.getUTCDate()) {
            days += `<div class="today border border-grey m-0 p-4">${day}</div>`
            continue
        }

        days += `<div class="border border-grey m-0 p-4">${day}</div>`
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
        renderCalendar()
    })
}


let nextButton = document.querySelector('.next-month');
if (nextButton != null) {
    nextButton.addEventListener('click', () => {
        date.setMonth(date.getMonth() + 1)
        renderCalendar()
    })
}
