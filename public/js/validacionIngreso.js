
var checkboxes = document.getElementsByName('tipov');

checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', function(event) {
        if (checkbox.checked) {
            var idcheck = checkbox.id;
            var label = document.querySelector('label[for="'+idcheck+'"]').textContent;
            if(label == 'Sin vehiculo'){
                document.getElementById("placa").value="N/A";
            }else{document.getElementById("placa").value="";}
        } 
    });
});

var modal = document.getElementById('modalIngreso');

$('#modalIngreso').on('shown.bs.modal', function() {
    var radioButtons = document.getElementsByName('tipov');
    var seleccionado = false;
    for (var i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            seleccionado = true;
            break; }
    }
    if (seleccionado && document.getElementById("placa").value) {} else {
        Swal.fire({
            title:'Error',
            icon:'error',
            timer: 900,
            text:'Por favor seleccione un tipo de vehiculo y digite la placa'
        }).then((result) => {
            $(modal).modal('hide');
        });
    }
});

var cantidad = 0;
const btn = document.querySelector("#btn-consulta");
const form = document.querySelector("#formIng");
btn.addEventListener("click", (e) =>{       

    var fBuscarDoc = buscarDoc(document.getElementById("cedulaOcp").value);
    if(fBuscarDoc){
        Swal.fire({
            title:'Error',
            icon:'error',
            timer: 1500,
            text:'El documento ya se agregó como acompañante'
        }).then((result) => {
            document.getElementById("cedulaOcp").value = '';
            document.getElementById("nombreOcp").value = '';
        });
    }else{  
        var radioButtons = document.getElementsByName('tipoi');
        var seleccionadoi = false;
        for (var i = 0; i < radioButtons.length; i++) {
            if (radioButtons[i].checked) {
                seleccionadoi = true;
                break; }
        }
        if (seleccionadoi && document.getElementById('cedulaOcp').value && document.getElementById("nombreOcp").value) {

            e.preventDefault();
            const datos = new FormData(form);

            document.getElementById('textcarg').textContent="Buscando autorizacion...";

            fetch('/ingresos/public/api/apiInv').then(response => {
                if (!response.ok) { throw new Error('La solicitud no fue exitosa'); }
                return response.json();
            })
            .then(data => {
                if (Object.keys(data).length === 0 && data.constructor === Object) {
                    console.log('La respuesta está vacía');
                } else {
                    if (data[0]=="200" && data[1]== "Ingresar") {
                        document.getElementById('textcarg').textContent="";
                        cantidad++;

                        var contenedor = document.getElementById('ocupantes');

                        var nuevoDiv1 = document.createElement('div');
                        nuevoDiv1.classList.add('row');
                        
                        var nuevoDiv2 = document.createElement('div');
                        nuevoDiv2.classList.add('col');

                        var titulo = document.createElement('label');
                        titulo.textContent ='Acompañante n° '+cantidad;

                        var nuevoCampo1 = document.createElement('input');
                        nuevoCampo1.setAttribute('readonly','');
                        nuevoCampo1.setAttribute('type', 'number');
                        nuevoCampo1.classList.add('form-control','form-group','cedulaacompa');
                        nuevoCampo1.name = 'cedulaacompa'+cantidad;
                        nuevoCampo1.value = document.getElementById("cedulaOcp").value;

                        var nuevoCampo2 = document.createElement('input');
                        nuevoCampo2.setAttribute('readonly','');
                        nuevoCampo2.setAttribute('type', 'text');
                        nuevoCampo2.classList.add('form-control','form-group');
                        nuevoCampo2.name = 'nombreacompa'+cantidad;
                        nuevoCampo2.value = document.getElementById("nombreOcp").value;
                        
                        var nuevoCampo3 = document.createElement('input');
                        nuevoCampo3.setAttribute('readonly','');
                        nuevoCampo3.setAttribute('type', 'radio');
                        nuevoCampo3.setAttribute('checked', '');
                        nuevoCampo3.name = 'tipoingresoacompa'+cantidad;

                        nuevoCampo3.classList.add('form-group');

                        var saltol = document.createElement('hr');

                        var checkboxes3 = document.getElementsByName('tipoi');
                        var valorCheckboxSeleccionado = null;
                        var idCheckboxSeleccionado = null;

                        for (var i = 0; i < checkboxes3.length; i++) {
                            if (checkboxes3[i].checked) {
                                valorCheckboxSeleccionado = checkboxes3[i].value;
                                idCheckboxSeleccionado =checkboxes3[i].id;
                                break;  }
                        }

                        nuevoCampo3.value = valorCheckboxSeleccionado;                             
                        var labecheckl = document.createElement('label');
                        labecheckl.htmlFor = idCheckboxSeleccionado;
                        labecheckl.textContent = " -- "+document.querySelector('label[for="'+idCheckboxSeleccionado+'"]').textContent;

                        nuevoDiv2.appendChild(titulo);
                        nuevoDiv2.appendChild(saltol);
                        nuevoDiv2.appendChild(nuevoCampo3);
                        nuevoDiv2.appendChild(labecheckl);                                
                        nuevoDiv2.appendChild(nuevoCampo1);
                        nuevoDiv2.appendChild(nuevoCampo2);
                        
                        nuevoDiv1.appendChild(nuevoDiv2);
                        
                        contenedor.appendChild(nuevoDiv1);

                        Swal.fire({
                            title:'Correcto',
                            icon:'success',
                            timer: 900,
                            text:"El acompañante fue agregado correctamente"
                        }).then((result) => {
                            document.getElementById("cantidadocp").value= cantidad;
                            document.getElementById("cedulaOcp").value = '';
                            document.getElementById("nombreOcp").value = '';
                            var radioButtons = document.getElementsByName('tipoi');
                            // Iterar sobre los radio buttons y deseleccionarlos
                            radioButtons.forEach(function(radioButton) {
                                radioButton.checked = false;
                            });
                            $(modal).modal('hide');
                        });

                    } else {
                        Swal.fire({
                            title:'Error',
                            icon:'error',
                            text:data[1]
                        });
                    }

                }
            })
            .catch(error => {
                console.error('Error al obtener datos:', error);
            });
        }else{
            Swal.fire({
                title:'Error',
                icon:'error',
                timer: 1500,
                text:'Por favor digite todos los datos del acompañante'
            });
        }
    }
});

function buscarDoc(documento){

    // Obtener el div por su id
    var divElement = document.getElementById('ocupantes');
    // Obtener todos los inputs dentro del div
    var inputs = divElement.getElementsByTagName('input');
    // Valor a buscar
    var valorBuscado = document.getElementById('cedulaOcp').value;
    // Variable para indicar si se encontró el valor
    var encontrado = false;
    // Iterar sobre los inputs
    for (var i = 0; i < inputs.length; i++) {
        // Verificar si el valor existe en el input actual
        console.log(inputs[i].value +" "+valorBuscado);
        if (inputs[i].value === valorBuscado) {
            encontrado = true;
            break; // Detener la iteración una vez que se encuentre el valor
        }
    }

    return encontrado;
}