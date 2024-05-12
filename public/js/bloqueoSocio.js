var bloqueoIndefBtn = document.getElementById('bloqueo_indf');

bloqueoIndefBtn.addEventListener('change', function(event) {
    if (bloqueoIndefBtn.checked) {
        document.getElementById("fecBloqueoIndf").style.display = "initial";
        document.getElementById("fecInicioBloqueo").disabled = false; 
        document.getElementById("fecFinBloqueo").disabled = false; 
    }else{
        document.getElementById("fecBloqueoIndf").style.display = "none";
        document.getElementById("fecInicioBloqueo").disabled = true; 
        document.getElementById("fecFinBloqueo").disabled = true; 

    }
});

var bloqueoTodosNucleo = document.getElementById('bloqueoTodosAccion');

bloqueoTodosNucleo.addEventListener('change', function(event) {
    if (bloqueoTodosNucleo.checked) {
        document.getElementById("bloqueoCedulaDiv").style.visibility = "hidden";
        document.getElementById("cedulaBloqueo").disabled = false; 
    }else{
        document.getElementById("bloqueoCedulaDiv").style.visibility = "initial";
        document.getElementById("cedulaBloqueo").disabled = false; 
        document.getElementById("bloqueoTodosAccion").checked = false; 

    }
});

const btnBloqueoSocio = document.getElementById("btnBloqueoxSocio");

btnBloqueoSocio.addEventListener("click", (e) =>{      
    const form = document.querySelector("#formBloqueoxSocio");

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

