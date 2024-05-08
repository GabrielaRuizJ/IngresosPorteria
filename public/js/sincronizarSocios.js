const btn = document.querySelector("#btnSyncSocios");

btn.addEventListener("click", (e) =>{      
    Swal.fire({
        title: "Confirmación ",
        text:'¿Esta seguro que desea sincronizar los datos? Esta accion no puede se reversar',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Si",
        denyButtonText: "No"
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            
        }
    });
})