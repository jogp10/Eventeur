let profilePageSettingsButton = document.getElementById('settings-button')
let profilePageSecuritysButton = document.getElementById('security-button')
let editProfileSection = document.getElementById("edit-profile")
let editSecuritySection = document.getElementById("settings")

console.log(profilePageSettingsButton)

if(profilePageSettingsButton !== null) {

  profilePageSettingsButton.addEventListener('click', () => {
    editSecuritySection.className = "visually-hidden"
    editProfileSection.className = ""
    profilePageSecuritysButton.style.color = "grey"
    profilePageSettingsButton.style.color = "black"
  })

  profilePageSecuritysButton.addEventListener('click', () => {

      editSecuritySection.className = ""
      editProfileSection.className = "visually-hidden"
      profilePageSecuritysButton.style.color = "black"
      profilePageSettingsButton.style.color = "grey"
  })


  const alertPlaceholder = document.getElementById('liveAlertPlaceholder')

  const alert = (message, type) => {
    const wrapper = document.createElement('div')
    wrapper.innerHTML = [
      `<div class="alert alert-${type} alert-dismissible" role="alert">`,
      `   <div>${message}</div>`,
      '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
      '</div>'
    ].join('')

    alertPlaceholder.append(wrapper)
  }

  const alertTrigger = document.getElementById('liveAlertBtn')
  if (alertTrigger) {
    alertTrigger.addEventListener('click', () => {
      alert('Nice, you triggered this alert message!', 'success')
    })
  }
  
}

