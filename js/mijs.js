function validarBuscar(event) {
    const mitexto = document.getElementById("texto");
    
    // Check if the input is empty
    if (!mitexto.value.trim()) {
        event.preventDefault(); // Prevent form submission
        alert("El texto debe estar completo");
        mitexto.focus(); // Focus the input for the user
        return false;
    }
    
    // Input is valid
    return true;
}