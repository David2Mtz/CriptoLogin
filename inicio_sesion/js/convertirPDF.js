document.getElementById('convertirPDF').addEventListener('click', () => {
    const { jsPDF } = window.jspdf;
    const content = document.getElementById('contenidoPDF');

    html2canvas(content, {
        scale: 2, // Mejora la calidad del lienzo
        useCORS: true // Permite cargar imágenes externas
    }).then((canvas) => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'mm', 'a4'); // PDF en formato vertical (A4)

        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = pdf.internal.pageSize.getHeight();
        const canvasWidth = canvas.width;
        const canvasHeight = canvas.height;

        // Definir los márgenes (20mm de margen en todos los bordes)
        const margin = 10;
        const imgWidth = pdfWidth - 2 * margin; // Ancho de la imagen ajustado con márgenes
        const imgHeight = (canvasHeight * imgWidth) / canvasWidth;

        // Posicionar la imagen con márgenes
        pdf.addImage(imgData, 'PNG', margin, margin, imgWidth, imgHeight);
        pdf.save('documento.pdf');
    }).catch((error) => {
        console.error('Error al generar PDF:', error);
    });
});
