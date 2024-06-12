
function elimBloqueo(contador,accion){
    var formElimBloq = document.getElementById("formElimBloq"+contador); 
    Swal.fire({
        title: "Confirmación ",
        text:'¿Esta seguro que desea '+accion+' este bloqueo?',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Si",
        denyButtonText: "No"
      }).then((result) => {
  
        if (result.isConfirmed) {
            formElimBloq.submit();
        }
    });
}