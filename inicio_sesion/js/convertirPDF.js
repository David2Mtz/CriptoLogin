{/* <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> */} // Se debe agregar en el HTML

// convertirPDF es el boton que se debe agregar en el HTML para mandar a convertir a PDF

// contenidoPDF es el id del div que se desea convertir a PDF 


document.getElementById('convertirPDF').addEventListener('click', () => {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const content = document.getElementById('contenidoPDF');

    doc.html(content, {
        callback: function (doc) {
            doc.save('documento.pdf');
        },
        x: 10,
        y: 10
    });

});