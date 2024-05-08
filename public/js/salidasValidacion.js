const btn = document.querySelector("#salidaMSV");
const form = document.querySelector("#formSMV");

btn.addEventListener("click", (e) =>{      

    Swal.fire({
        title: "Confirmación ",
        text:'¿Esta seguro que desea hacer una salida masiva? Esta accion no puede se reversar',
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



function salidaIndv(id,nombre_ingreso,cedula,nombre,nombre_vehiculo,placa){
   
    document.getElementById("dat1salidaINDV").value = id;
    document.getElementById("dat2salidaINDV").value = nombre_ingreso;
    document.getElementById("dat3salidaINDV").value = cedula;
    document.getElementById("dat4salidaINDV").value = nombre;
    document.getElementById("dat5salidaINDV").value = nombre_vehiculo;
    document.getElementById("dat6salidaINDV").value = placa;

}
const btnSalidaIndv = document.querySelector("#btnsalidaIndv");

btnSalidaIndv.addEventListener("click", (e) =>{  
    const formSalidaIdnv = document.querySelector("#formSIDV");     
    Swal.fire({
        title: "Confirmación ",
        text:'¿Esta seguro que desea realizar esta salida? Esta accion no puede se reversar',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Si",
        denyButtonText: "No"
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            formSalidaIdnv.submit();
        }
    });
})


var salidaTodos = document.getElementById('tiposalidaTodos');

salidaTodos.addEventListener('change', function(event) {
    if (salidaTodos.checked) {
        document.querySelectorAll('#formSMV input[name="tiposalida[]"]').forEach(function(checkElement) {
            checkElement.checked = false;
            checkElement.disabled = true; 
        });
    }else{
        document.querySelectorAll('#formSMV input[name="tiposalida[]"]').forEach(function(checkElement) {
            checkElement.checked = false;
            checkElement.disabled = false;
        });
    }
});