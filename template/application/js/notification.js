$(document).ready(function () {
    function loadNotifications() {
        $.ajax({
            url: "application/api/fetch_notifications.php",
            method: "GET",
            dataType: "JSON",
            success: function (response) {
                if (response.status) {
                    let notifications = response.data;
                    let notificationList = "";

                    notifications.forEach((notification) => {
                        let time = new Date(notification.created_at).toLocaleString();
                        notificationList += `
                            <li class="notification">
                                <div class="media">
                                    <div class="media-body">
                                        <p><a href="application/views/user_profile.php"  class="notify_appliedd"><strong>${notification.message}</strong> </a><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>${time}</span></p>
                                    </div>
                                </div>
                            </li>
                        `;
                    });

                    $(".noti-body").html(notificationList);
                }
            },
            error: function () {
                console.error("Failed to fetch notifications.");
            },
        });
    }


    loadNotifications();
    setInterval(loadNotifications, 30000); // Refresh notifications every 30 seconds


    $("#mark-as-read").on("click", function () {
        $.ajax({
            url: "application/api/mark_notifications_read.php",
            method: "POST",
            success: function () {
                loadNotifications();
            },
        });
    });


    $("#clear-all").on("click", function () {
        $.ajax({
            url: "application/api/clear_notifications.php",
            method: "POST",
            success: function () {
                loadNotifications();
            },
        });
    });



    $(".mark-as-read").on("click", function () {
        $.ajax({
            url: "application/api/mark_notifications_as_read.php",
            method: "POST",
            success: function (response) {
                if (response.status) {
                    $(".notification-count").addClass("d-none");
                    alert("All notifications marked as read.");
                }
            },
            error: function () {
                console.error("Failed to mark notifications as read.");
            },
        });
    });
    
    
    


});
