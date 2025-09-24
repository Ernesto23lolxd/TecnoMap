window.addEventListener('load', function() {
    var form = document.getElementById("form");

    form.addEventListener('submit', function(e) {
        var ncontrol = document.getElementById("ncontrol").value.trim();
        var email = document.getElementById("email").value.trim();
        var clave = document.getElementById("Clave").value;
        var rclave = document.getElementById("RClave").value;

        // Validar campos vacíos
        if (ncontrol === '' || email === '' || clave === '' || rclave === '') {
            e.preventDefault();
            alert("Todos los campos son obligatorios");
            return;
        }

        // Validar correo electrónico
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            alert("El correo electrónico no es válido");
            return;
        }

        // Validar contraseñas iguales
        if (clave !== rclave) {
            e.preventDefault();
            alert("Las contraseñas no coinciden");
            return;
        }
    }, false);
});