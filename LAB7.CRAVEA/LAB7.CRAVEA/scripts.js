// validaciones.js

function validarFormularioCliente(event) {
    var nombre = document.querySelector('input[name="nombre"]').value;
    var apellido = document.querySelector('input[name="apellido"]').value;
    var email = document.querySelector('input[name="email"]').value;
    var calle = document.querySelector('input[name="calle"]').value;
    var numero = document.querySelector('input[name="numero"]').value;

    if (!nombre || !apellido || !email || !calle || !numero) {
        alert("Tíenes que completar todos los campos.");
        event.preventDefault();
        return false;
    }

    if (!email.includes('@')) {
        alert("El correo electrónico debe tener '@'.");
        event.preventDefault();
        return false;
    }

    if (isNaN(numero)) {
        alert("El número de teléfono debe tener solo números.");
        event.preventDefault();
        return false;
    }

    return true;
}

function validarFormularioProducto(event) {
    var nombreprod = document.querySelector('input[name="nombreprod"]').value;
    var precio = document.querySelector('input[name="precio"]').value;

    if (!nombreprod || !precio) {
        alert("Todos los campos son obligatorios.");
        event.preventDefault();
        return false;
    }
    
    if (isNaN(precio)) {
        alert("El precio debe ser un número.");
        event.preventDefault();
        return false;
    }

    return true;
}

function validarFormularioBusqueda(event) {
    var idProducto = document.querySelector('input[name="id_producto"]').value;

    if (!idProducto) {
        alert("El ID del producto es obligatorio.");
        event.preventDefault();
        return false;
    }

    if (isNaN(idProducto)) {
        alert("El ID del producto debe ser un número.");
        event.preventDefault();
        return false;
    }

    return true;
}
