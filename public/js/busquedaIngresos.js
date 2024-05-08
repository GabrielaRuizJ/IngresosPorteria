var salidaTodos = document.getElementById('tiposalidaTodos');

salidaTodos.addEventListener('change', function(event) {
    if (salidaTodos.checked) {
        document.querySelectorAll('#formBusquedaIngresos input[name=tiposalida]').forEach(function(checkElement) {
            checkElement.checked = false;
            checkElement.disabled = true; 
        });
    }else{
        document.querySelectorAll('#formBusquedaIngresos input[name=tiposalida]').forEach(function(checkElement) {
            checkElement.checked = false;
            checkElement.disabled = false;
        });
    }
});

var vehiculosTodos = document.getElementById('tiposvehiculosTodos');

vehiculosTodos.addEventListener('change', function(event) {
    if (vehiculosTodos.checked) {
        document.querySelectorAll('#formBusquedaIngresos input[name=tipovehiculo]').forEach(function(checkElement) {
            checkElement.checked = false;
            checkElement.disabled = true; 
        });
    }else{
        document.querySelectorAll('#formBusquedaIngresos input[name=tipovehiculo]').forEach(function(checkElement) {
            checkElement.checked = false;
            checkElement.disabled = false;
        });
    }
});