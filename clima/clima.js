const API_KEY = "cc530c245167a8169a6af9a903c259b4";
const BASE_URL = "https://api.openweathermap.org/data/2.5/";

// Función para buscar sugerencias en tiempo real
document.getElementById("searchInput").addEventListener("input", async (event) => {
    const query = event.target.value.trim();

    if (query.length >= 3) {
        try {
            const response = await fetch(`https://api.openweathermap.org/geo/1.0/direct?q=${query}&limit=5&appid=${API_KEY}`);
            if (!response.ok) throw new Error("Error al buscar sugerencias");

            const cities = await response.json();
            showSuggestions(cities);
        } catch (error) {
            console.error("Error en las sugerencias:", error);
        }
    } else {
        clearSuggestions();
    }
});

// Mostrar sugerencias debajo del campo de búsqueda
function showSuggestions(cities) {
    clearSuggestions(); // Limpiar sugerencias previas
    const suggestionsContainer = document.createElement("ul");
    suggestionsContainer.classList.add("suggestions");

    cities.forEach((city) => {
        const suggestion = document.createElement("li");
        suggestion.textContent = `${city.name}, ${city.country}`;
        suggestion.addEventListener("click", () => {
            document.getElementById("searchInput").value = city.name;
            clearSuggestions();
            fetchWeather(city.lat, city.lon);
        });
        suggestionsContainer.appendChild(suggestion);
    });

    document.querySelector(".search-bar").appendChild(suggestionsContainer);
}

// Limpiar las sugerencias
function clearSuggestions() {
    const existingSuggestions = document.querySelector(".suggestions");
    if (existingSuggestions) existingSuggestions.remove();
}

// Función para buscar el clima al dar clic en el botón de búsqueda
document.getElementById("searchButton").addEventListener("click", async () => {
    const query = document.getElementById("searchInput").value.trim();

    if (query) {
        try {
            const response = await fetch(`https://api.openweathermap.org/geo/1.0/direct?q=${query}&limit=1&appid=${API_KEY}`);
            if (!response.ok) throw new Error("No se encontró la ciudad");

            const [location] = await response.json();
            if (location) {
                fetchWeather(location.lat, location.lon);
            } else {
                alert("No se encontró la ciudad.");
            }
        } catch (error) {
            console.error("Error al buscar el clima:", error);
        }
    }
});

// Obtener el clima basado en latitud y longitud
async function fetchWeather(lat, lon) {
    try {
        const response = await fetch(`${BASE_URL}forecast?lat=${lat}&lon=${lon}&appid=${API_KEY}&units=metric&lang=es`);
        if (!response.ok) throw new Error("Error al obtener el clima");

        const weatherData = await response.json();
        displayWeather(weatherData);
    } catch (error) {
        console.error("Error al obtener el clima:", error);
    }
}

// Mostrar el clima en la interfaz
function displayWeather(data) {
    const weatherContainer = document.getElementById("weatherContainer");
    weatherContainer.innerHTML = "";

    data.list.slice(0, 5).forEach((forecast) => {
        const weatherBox = document.createElement("div");
        weatherBox.classList.add("weather-box");

        const date = new Date(forecast.dt * 1000);
        const day = date.toLocaleDateString("es-ES", { weekday: "long" });

        weatherBox.innerHTML = `
            <p><strong>${day}</strong></p>
            <img src="https://openweathermap.org/img/wn/${forecast.weather[0].icon}@2x.png" alt="${forecast.weather[0].description}">
            <p>${forecast.weather[0].description}</p>
            <p><strong>${forecast.main.temp}°C</strong></p>
            <p>Humedad: ${forecast.main.humidity}%</p>
        `;

        weatherContainer.appendChild(weatherBox);
    });
}

// Función para verificar la conexión con la API
async function checkConnection() {
    try {
        const response = await fetch(`${BASE_URL}weather?q=test&appid=${API_KEY}`);
        if (response.ok) {
            console.log("Conexión exitosa con la API");
        } else {
            throw new Error("Conexión fallida con la API");
        }
    } catch (error) {
        console.error("Error en la conexión:", error);
    }
}

// Verificar conexión al cargar la página
checkConnection();

// Función para mostrar mensajes de estado
function showMessage(message, type = 'info') {
    const messageBox = document.createElement('div');
    messageBox.className = `message-box ${type}`;
    messageBox.textContent = message;

    document.body.appendChild(messageBox);

    // Ocultar el mensaje después de 3 segundos
    setTimeout(() => {
        messageBox.remove();
    }, 3000);
}

// Verificar conexión al API con un ejemplo básico
async function testAPIConnection() {
    try {
        const response = await fetch(`https://api.openweathermap.org/data/2.5/weather?q=London&appid=ab9f7b95d909f6965e8f7d4bdf7ec5fb`);
        if (response.ok) {
            showMessage('Conexión exitosa con la API', 'success');
        } else {
            showMessage('Error en la conexión con la API', 'error');
        }
    } catch (error) {
        showMessage('No se pudo conectar a la API', 'error');
    }
}




