let pollFormElle = document.getElementById('form-poll-event')
let addPollButton = document.getElementById('add-poll')
let numOptions = 3
let cont = 1
let formElle = `<div class="row mb-3">
                    <div class="form-floating">
                        <textarea class="form-control" name="question" placeholder="Write yoyr queation" id="floatingTextarea2" style="height: 100px"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="option1" class="col-3 col-form-label">Option 1</label>
                    <div class="col-9">
                        <input type="text" name="option1" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="option2" class="col-3 col-form-label">Option 2</label>
                    <div class="col-9">
                      <input type="text" name="option2" class="form-control">
                    </div>
                </div>`


if (addPollButton !== null) {
    addPollButton.addEventListener('click', () => {
        if (cont % 2 == 0) {
            changeFormElement()
        } else {
            let addOptionButton = document.getElementById('add-option')
            addOptionButton.classList.add('invisible')
            pollFormElle.innerHTML = ""
        }
        cont++
    })
}

function createPoll(url) {
    document.location.href = url
}

function changeFormElement() {

    pollFormElle.innerHTML = `${formElle}<button id="poll-submit-button" type=submit class="float-end">submit</button>`


    let addOptionButton = document.getElementById('add-option')
    addOptionButton.classList.remove('invisible')
    addOptionButton.addEventListener('click', addOption)

}

function addOption() {

    if (numOptions <= 6) {
        formElle += `<div class="row mb-3">
                    <label for="option ${numOptions}" class="col-3 col-form-label">Option ${numOptions}</label>
                    <div class="col-9">
                        <input type="text" name="option${numOptions}" class="form-control">
                    </div>
                </div>`
    }

    numOptions++

    changeFormElement()
}









