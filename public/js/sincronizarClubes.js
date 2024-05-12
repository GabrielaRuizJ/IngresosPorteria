const btn = document.querySelector("#btnSyncClubes");

btn.addEventListener("click", (e) =>{      
  const form = document.querySelector("#syncClubes");
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
          form.submit();
        }
    });
})

function decodeEntities(encodedString) {
  const textarea = document.createElement('textarea');
  textarea.style.textAlign = "left";
  textarea.innerHTML = encodedString;
  return textarea.value;
}