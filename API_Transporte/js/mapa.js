let mapa, directionsService, directionsRenderer, geocoder;

function iniciarMapa() {
  // Inicializar el mapa
  mapa = new google.maps.Map(document.getElementById("mapa"), {
    zoom: 14,
    center: { lat: 19.504952676161075, lng: -99.14629081790021 }, // Centro inicial
  });

  // Inicializar servicios de direcciones y renderización
  directionsService = new google.maps.DirectionsService();
  directionsRenderer = new google.maps.DirectionsRenderer({
    draggable: true,
    map: mapa,
    panel: document.getElementById("panel"),
  });

  directionsRenderer.setMap(mapa);

  // Inicializar geocoder
  geocoder = new google.maps.Geocoder();

  // Configurar Autocomplete para los campos de entrada
  const opciones = {
    fields: ["formatted_address", "geometry"],
    componentRestrictions: { country: "mx" }, // Opcional: restringir a México
  };

  const autocompleteInicio = new google.maps.places.Autocomplete(
    document.getElementById("inicio"),
    opciones
  );

  const autocompleteDestino = new google.maps.places.Autocomplete(
    document.getElementById("destino"),
    opciones
  );

  // Manejar selección de Autocomplete
  autocompleteInicio.addListener("place_changed", () => {
    const lugar = autocompleteInicio.getPlace();
    if (lugar.geometry) {
      console.log("Inicio seleccionado:", lugar.formatted_address);
    } else {
      alert("Por favor, selecciona una ubicación válida para el inicio.");
    }
  });

  autocompleteDestino.addListener("place_changed", () => {
    const lugar = autocompleteDestino.getPlace();
    if (lugar.geometry) {
      console.log("Destino seleccionado:", lugar.formatted_address);
    } else {
      alert("Por favor, selecciona una ubicación válida para el destino.");
    }
  });

  // Manejar cambios en las direcciones para calcular distancia total
  directionsRenderer.addListener("directions_changed", () => {
    const directions = directionsRenderer.getDirections();
    if (directions) {
      computeTotalDistance(directions);
    }
  });
}

function calcularRuta() {
  const inicio = document.getElementById("inicio").value;
  const destino = document.getElementById("destino").value;
  const escalasTexto = document.getElementById("escalas").value;
  const modo = document.getElementById("modo").value;

  if (!["DRIVING", "WALKING", "TRANSIT"].includes(modo)) {
    alert("Por favor, selecciona un modo de transporte válido.");
    return;
  }

  const escalas = escalasTexto
    .split(",")
    .map((lugar) => lugar.trim())
    .filter((lugar) => lugar.length > 0);

  obtenerCoordenadas(inicio, (inicioCoord) => {
    obtenerCoordenadas(destino, (destinoCoord) => {
      if (escalas.length > 0) {
        const waypoints = [];
        let procesadas = 0;

        escalas.forEach((escala) => {
          obtenerCoordenadas(escala, (escalaCoord) => {
            waypoints.push({ location: escalaCoord, stopover: true });
            procesadas++;

            if (procesadas === escalas.length) {
              generarRuta(inicioCoord, destinoCoord, waypoints, modo);
            }
          });
        });
      } else {
        generarRuta(inicioCoord, destinoCoord, [], modo);
      }
    });
  });
}

function obtenerCoordenadas(direccion, callback) {
  geocoder.geocode({ address: direccion }, (resultados, estado) => {
    if (estado === google.maps.GeocoderStatus.OK) {
      callback(resultados[0].geometry.location);
    } else {
      alert("No se pudo obtener la ubicación de: " + direccion);
    }
  });
}

function generarRuta(inicio, destino, waypoints, modo) {
  const solicitud = {
    origin: inicio,
    destination: destino,
    waypoints: waypoints,
    travelMode: modo,
  };

  directionsService.route(solicitud, (result, status) => {
    if (status === google.maps.DirectionsStatus.OK) {
      directionsRenderer.setDirections(result);
      
    } else {
      alert("No se pudo calcular la ruta.");
    }
  });
}


function mostrarTiempoTotal(result) {
  const tiempoTotalDiv = document.getElementById("total");

  const duracionTotal = result.routes[0].legs.reduce((total, leg) => {
    return total + leg.duration.value; // Duración en segundos
  }, 0);

  const minutos = Math.floor(duracionTotal / 60);
  const horas = Math.floor(minutos / 60);
  const minutosRestantes = minutos % 60;

  tiempoTotalDiv.innerHTML = `<strong>Tiempo estimado de viaje:</strong> ${
    horas > 0 ? `${horas} horas y ` : ""
  }${minutosRestantes} minutos.`;
}

function computeTotalDistance(result) {
  let total = 0;
  const myroute = result.routes[0];

  if (!myroute) {
    return;
  }

  for (let i = 0; i < myroute.legs.length; i++) {
    total += myroute.legs[i].distance.value;
  }

  total = total / 1000; // Convertir metros a kilómetros
  document.getElementById("total").innerHTML = total + " km";
}
