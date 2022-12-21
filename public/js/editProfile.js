let profilePageSettingsButton = document.getElementById('settings-button')
let profilePageSecuritysButton = document.getElementById('security-button')
let editProfileSection = document.getElementById("settings")
let editSecuritySection = document.getElementById("security")

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
}

