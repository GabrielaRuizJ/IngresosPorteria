const btnAturizaCreate = document.getElementById("btnGuardarAutoriza");
const formCreateAut = document.getElementById('formAutoriza');

btnAturizaCreate.addEventListener("click", (e) =>{ 

    var campo1 = document.getElementById("docautorizado").value;
    var campo2 = document.getElementById("nomautorizado").value;
    var campo3 = document.getElementById("docautoriza").value;
    var campo4 = document.getElementById("nomautoriza").value;
    var campo5 = document.getElementById("fechaIngreso").value;

    if(campo1 && campo2 && campo3 && campo4 && campo5){
        Swal.fire({
            title: "Confirmación ",
            text:'¿Desea autorizar este ingreso?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Si",
            denyButtonText: "No"
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                formCreateAut.submit()
            }
        });
    }else{
        Swal.fire({
            title: 'Error',
            text:'Campos incompletos',
            icon:'error'
        });
    }

});