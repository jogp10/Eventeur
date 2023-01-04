let profilePageSettingsButton = document.getElementById('settings-button')
let profilePageSecuritysButton = document.getElementById('security-button')
let editProfileSection = document.getElementById("settings")
let editSecuritySection = document.getElementById("security")

if(profilePageSettingsButton !== null) {

  profilePageSettingsButton.addEventListener('click', () => {
    editSecuritySection.classList.add("visually-hidden");
    editProfileSection.classList.remove("visually-hidden");
    profilePageSecuritysButton.style.color = "grey"
    profilePageSettingsButton.style.color = "black"
  })

  profilePageSecuritysButton.addEventListener('click', () => {
      editSecuritySection.classList.remove("visually-hidden");
      editProfileSection.classList.add("visually-hidden");
      profilePageSecuritysButton.style.color = "black"
      profilePageSettingsButton.style.color = "grey"
  })
}

