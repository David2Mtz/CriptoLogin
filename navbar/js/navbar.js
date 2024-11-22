// Función para alternar la visibilidad del recuadro de notificaciones
function toggleNotifications() {
    var notifications = document.getElementById("notifications");
    if (notifications.style.display === "block") {
        notifications.style.display = "none";
    } else {
        notifications.style.display = "block";
    }
}
