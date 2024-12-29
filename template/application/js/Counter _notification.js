$(document).ready(function () {
    function updateNotificationCount() {
        $.ajax({
            url: "application/api/fetch_notification_count.php",
            method: "GET",
            dataType: "JSON",
            success: function (response) {
                if (response.status) {
                    let count = response.count;
                    if (count > 0) {
                        $(".notification-count").text(count).removeClass("d-none");
                    } else {
                        $(".notification-count").addClass("d-none");
                    }
                }
            },
            error: function () {
                console.error("Failed to fetch notification count.");
            },
        });
    }

    updateNotificationCount();
    setInterval(updateNotificationCount, 10000); // Refresh every 10 seconds
});
