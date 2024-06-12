var bloqueoIndefBtn = document.getElementById('bloqueo_indf');

bloqueoIndefBtn.addEventListener('change', function(event) {
    if (bloqueoIndefBtn.checked) {
        document.getElementById("fecBloqueoIndf").style.display = "none";
        document.getElementById("fecInicioBloqueo").disabled = true; 
        document.getElementById("fecFinBloqueo").disabled = true; 
    }else{
        document.getElementById("fecBloqueoIndf").style.display = "initial";
        document.getElementById("fecInicioBloqueo").disabled = false; 
        document.getElementById("fecFinBloqueo").disabled = false; 
    }
});

const btnBloqueoSocio = document.getElementById("btnBloqueoxSocio");

btnBloqueoSocio.addEventListener("click", (e) =>{      
    const form = document.querySelector("#formBloqueoxPersona");

    Swal.fire({
        title: "Confirmación ",
        text:'¿Esta seguro que desea realizar este bloqueo',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Si",
        denyButtonText: "No"
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            form.submit();
        }
    });

})

function elimBloqueo(contador){
    var formElimBloq = document.getElementById("formElimBloq"+contador); 
    Swal.fire({
        title: "Confirmación ",
        text:'¿Esta seguro que desea desactivar este bloqueo? Esta accion no puede se reversar',
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
