
var checkboxes = document.getElementsByName('tipov');

checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', function(event) {
        if (checkbox.checked) {
            var idcheck = checkbox.id;
            var label = document.querySelector('label[for="'+idcheck+'"]').textContent;
            if(label == 'Sin vehiculo'){
                document.getElementById("placa_v").value="N/A";
            }else{document.getElementById("placa_v").value="";}
        }
    });
});

var checkboxesTingreso = document.getElementsByName('tipoi');

checkboxesTingreso.forEach(function(checkbox) {
    checkbox.addEventListener('change', function(event) {
        if (checkbox.checked) {
            limpiarCampos()
        }
    });
});

function fBorrarCampo(){
    document.getElementById("placa_v").value="";
}

const btn = document.querySelector("#guardarIngreso");
const form = document.querySelector("#formIng");

btn.addEventListener("click", (e) =>{       

    tipoveh =  document.getElementsByName('tipov');
    var valorCheckboxSeleccionado = null;
    for (var i = 0; i < tipoveh.length; i++) {
        if (tipoveh[i].checked) {
            valorCheckboxSeleccionado = tipoveh[i].value;
            break;  
        }
    }
    placa = document.getElementById("placa_v").value;
    tipoingreso =  document.getElementsByName('tipoi');
    var valorIngresoeleccionado = null;
    for (var i = 0; i < tipoingreso.length; i++) {
        if (tipoingreso[i].checked) {
            valorIngresoeleccionado = tipoingreso[i].value;
            break;  
        }
    }
    cedula = document.getElementById("cedulaOcp").value;
    primAp = document.getElementById("primAp").value;
    segAp = document.getElementById("segAp").value;
    primNm = document.getElementById("primNm").value;
    segNm = document.getElementById("segNm").value;
    if(valorCheckboxSeleccionado && placa && valorIngresoeleccionado && cedula && primAp && primNm){
        
        const formData = new FormData(document.getElementById('formIng'));

        fetch('/IngresosPorteria/public/api/guardarIngreso', {
            method: 'POST',  body: formData
        }).then(response => {
            if (!response.ok) { throw new Error('La solicitud no fue exitosa'); }
            return response.json();
        })
        .then(data => {
            if (Object.keys(data).length === 0 && data.constructor === Object) {
                console.log('La respuesta está vacía');
            } else {
                if(data.respuesta == 404){
                    crearCamposCanje();
                }else if(data.respuesta == 300){
                    Swal.fire({
                        title:'Error',
                        icon: 'error',
                        text: data.datos
                    });
                }else if(data.respuesta == 301){
                    Swal.fire({
                        title: "El rango de fechas de canje ya ha vencido ",
                        text:'Registrar nuevo rango de rechas',
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: "Si",
                        denyButtonText: "No"
                      }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            crearCamposCanje()
                        }else{
                            limpiarCampos()
                        }
                    });
                }else if(data.respuesta == 200){
                    Swal.fire({
                        title:'Correcto',
                        icon: 'success',
                        text: "Ingreso registrado correctamente"
                    });
                    limpiarCampos()
                }
                console.log(data.respuesta)
            }
        })
        .catch(error => {
            console.error('Error al obtener datos:', error);
        });
    }else{
        Swal.fire({
            title:'Error',
            icon:'error',
            text:"Los datos no están completos"
        });
    }

    
});
    

function crearCamposCanje(){
    fetch('/IngresosPorteria/public/api/apiCanje').then(response => {
        if (!response.ok) { throw new Error('La solicitud no fue exitosa'); }
        return response.json();
    })
    .then(data => {
        if (Object.keys(data).length === 0 && data.constructor === Object) {
            console.log('La respuesta está vacía');
        } else {
            var fechainput = new Date();
            var dia1 = ('0' + fechainput.getDate()).slice(-2);  
            var mes1 = ('0' + (fechainput.getMonth() + 1)).slice(-2);
            fechainput = fechainput.getFullYear()+"-"+mes1+"-"+dia1;

            var fechainput2 = new Date();
            fechainput2.setDate(fechainput2.getDate() + 1);
            var dia2 = ('0' + fechainput2.getDate()).slice(-2); 
            var mes2 = ('0' + (fechainput2.getMonth() + 1)).slice(-2); 
            fechainput2 = fechainput2.getFullYear()+"-"+mes2+"-"+dia2;
            
            divclub = document.getElementById("dat_canje");
            var newRow = "<div class='row'><label>Club del canje:</label> <select id='idclubcanje' name='idclubcanje' class='form-control'>";
            var theOptions = "";
            data['datos'].forEach(function(dato) {
                theOptions += '<option value="'+dato.id_club+'">'+dato.club+'</option>';
            });
            newRow += theOptions;
            newRow += "</select></div><div class='row'><div class='col'><label>Fecha inicio:</label>";
            newRow += "<input class='form-control' type='date' id='finiciocanje' name='finiciocanje' value='"+fechainput+"'>";
            newRow += "</div><div class='col'><label>Fecha fin:</label>";
            newRow += "<input type='date' placeholder='MM/DD/YYYY' class='form-control' id='ffincanje' name='ffincanje' value='"+fechainput2+"'>";
            newRow += "</div></div>";
            divclub.innerHTML = newRow;
            return
        }
    })
    .catch(error => {
        console.error('Error al obtener datos:', error);
    });

    
}

function limpiarCampos(){
    var div = document.getElementById('dat_canje');
    div.innerHTML = '';
    document.getElementById('cedulaOcp').value="";
    document.getElementById('primAp').value="";
    document.getElementById('segAp').value="";
    document.getElementById('primNm').value="";
    document.getElementById('segNm').value="";
    document.getElementById('dtOct1').value="";
    document.getElementById('dtOct2').value="";
}