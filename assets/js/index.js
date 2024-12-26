AOS.init(); //Animaciones al hacer scroll
document.getElementById('year').textContent = new Date().getFullYear(); //Tomar el año actual

// Cuando el formulario se envía
    document.getElementById('contact-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar la recarga de la página

        // Obtener los datos del formulario
        var formData = new FormData(this);

        // Realizar la petición AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'enviar_correo.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Respuesta exitosa
                var response = JSON.parse(xhr.responseText);
                mostrarToast(response.status, response.message);

                // Si el mensaje se envió exitosamente, vaciar el formulario
                if (response.status === 'exito') {
                    document.getElementById('contact-form').reset();
                }
            } else {
                // Si ocurre algún error al procesar el formulario
                mostrarToast('error', 'Hubo un error al procesar el formulario.');
            }
        };
        xhr.send(formData);
    });

// Mostrar el toast con el mensaje
function mostrarToast(status, message) {
    var toast = document.getElementById("toast");
    var toastMessage = document.getElementById("toast-message");
    toastMessage.innerText = message;

    // Cambiar el tipo de clase dependiendo del resultado
    if (status === 'exito') {
        toast.classList.add("show-toast", "toast-exito");
    } else {
        toast.classList.add("show-toast", "toast-error");
    }

    // Ocultar el toast después de 3 segundos
    setTimeout(function() {
        toast.classList.remove("show-toast", "toast-exito", "toast-error");
    }, 3000);
}