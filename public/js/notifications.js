let bell = document.getElementById('bell');

/* Toggle notifications div */
if (bell) {
    bell.addEventListener('click', function() {
        let notifications = document.getElementById('notifications');
        if (notifications.style.display === "none") {
            notifications.style.display = "block";
        }
        else {
            notifications.style.display = "none";
        }
    });


}