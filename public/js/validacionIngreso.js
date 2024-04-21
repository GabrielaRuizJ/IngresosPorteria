
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

/*
var checkboxesTi = document.getElementsByName('tipoi');

checkboxesTi.forEach(function(checkbox) {
    checkbox.addEventListener('change', function(event) {
        if (checkbox.checked) {
            var idcheck = checkbox.id;
            var label = document.querySelector('label[for="'+idcheck+'"]').textContent;
            if(label == 'Canje'){
                fetch('/ingresos/public/api/apiCanje').then(response => {
                    if (!response.ok) { throw new Error('La solicitud no fue exitosa'); }
                    return response.json();
                })
                .then(data => {
                    if (Object.keys(data).length === 0 && data.constructor === Object) {
                        console.log('La respuesta está vacía');
                    } else {
                        tabla = document.getElementById("bodytablecanje");
                        modal = document.getElementById("modalCanje");
                        fila=""
                        data['datos'].forEach(function(dato) {
                            nuevoCampo = "<input type='radio' style='width:3em;height:3em;' id='opcclub"+dato.id_club+"' name='opcclub' value='"+dato.id_club+"' /> "
                            fila += "<tr><td>"+dato.id_club+"</td><td><label for='opcclub"+dato.id_club+"'>"+dato.club+"</label></td><td>"+nuevoCampo+"</td></tr>";
                        });
                        tabla.innerHTML = fila;
                        $(modal).modal('show');
                    }
                })
                .catch(error => {
                    console.error('Error al obtener datos:', error);
                });
            }
        }
    });
});
*/
function agregarClub(){

    fecha1 = document.getElementById("rango1canje").value;
    fecha2 = document.getElementById("rango2canje").value;

    if(fecha1 > fecha2){
        Swal.fire({
            title:'Error',
            icon:'error',
            text:"Por favor elija un rango valido de fechas"
        });
    }else{
        club =  document.getElementsByName('opcclub');
        var valorCheckboxSeleccionado = null;
        var labelCheckboxSeleccionado = null;
        for (var i = 0; i < club.length; i++) {
            if (club[i].checked) {
                valorCheckboxSeleccionado = club[i].value;
                labelCheckboxSeleccionado = document.querySelector('label[for="opcclub'+valorCheckboxSeleccionado+'"]').textContent;
                break;  
            }
        }
        nuevoCampo = "<hr><div class='col'><input hidden class='form-control' type='text' name='idclub' value='"+valorCheckboxSeleccionado+"'/></div>"
        nuevoCampo2 = "<div class='col'><input hidden class='form-control' type='date' name='fecha1' value='"+fecha1+"' /></div>"
        nuevoCampo3 = "<div class='col'><input hidden class='form-control' type='date' name='fecha2' value='"+fecha2+"' /></div>"
        nuevoCampo3 = "<div class='col'><input disabled class='form-control' type='text' name='clubcanje' value='"+labelCheckboxSeleccionado+"' /></div><hr>"
        divcampos = document.getElementById("detalles")
        divcampos.innerHTML = nuevoCampo+nuevoCampo2+nuevoCampo3
        $(modal).modal('hide');
    }
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

        fetch('/ingresos/public/api/guardarIngreso', {
            method: 'POST',  body: formData
        }).then(response => {
            if (!response.ok) { throw new Error('La solicitud no fue exitosa'); }
            return response.json();
        })
        .then(data => {
            if (Object.keys(data).length === 0 && data.constructor === Object) {
                console.log('La respuesta está vacía');
            } else {
                console.log(data)
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
    

