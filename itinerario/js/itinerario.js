document.addEventListener("DOMContentLoaded", function () {
    //AGREGAR HEADER Y FOOTER
    fetch("../../navbar/html/navbar.html")
        .then(response => response.text())
        .then(data => document.getElementById("header").innerHTML = data);

    fetch("../../navbar/html/footer.html")
        .then(response => response.text())
        .then(data => document.getElementById("footer").innerHTML = data);
});

function showSection(section, day = null) {
    document.getElementById('calendar').classList.toggle('hidden', section !== 'calendar');
    document.getElementById('itinerary').classList.toggle('hidden', section !== 'itinerary');
    //Sdocument.getElementById('map').classList.toggle('hidden', section !== 'map');
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('selected'));
    document.querySelector(`.tab[onclick="showSection('${section}')"]`).classList.add('selected');

    // Si se ha pasado un día, seleccionarlo en el itinerario
    if (day) {
        document.getElementById('day-select').value = day;
        showDay();
    }
}

function showDay() {
    const selectedDay = document.getElementById('day-select').value;
    document.querySelectorAll('.day-section').forEach(section => {
        section.classList.add('hidden');
    });
    document.getElementById(selectedDay).classList.remove('hidden');
}
