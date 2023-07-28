let paso = 1; //Para que muestre una seccion al incio
const pasoInicial = 1;
const pasoFinal = 3;

//arreglo vacio 
const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}


//?DOMContentloaded: cuando el documento este cargado
document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});


function iniciarApp() {
    mostrarSeccion(); //muestra y oculta las secciones
    tabs(); // cambia la seccion cuando se presionen los tabs
    botonesPaginador(); //Agrega o quita los botones del paginador
    paginaAnterior();
    paginaSiguiente();

    consultarAPI(); //consulta la API en el baquen de php

    idCliente(); //
    nombreCliente(); //asigna a el objeto cita.nombre el valor de el nombre del cliente
    seleccionarFecha(); // Añade al objetp cita.fecha el valor de la fecha seleccionada por el cliente
    seleccionarHora(); // Añade al objetp cita.hora el valor de la fecha seleccionada por el cliente
    mostrarResumen(); //Muestra el resumen de la cita

}

function mostrarSeccion() {
    //! Ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar'); //seleciona la clase mostrae
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar'); //elimina la clase mostrar
    }

    //! Seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector); ///Seleccionar la seccion con el paso...
    seccion.classList.add('mostrar'); //agrega la clase mostrar a  la seccion

    //! Quiatr resaltado a quien tenga la clase actual
    const tabAnterior = document.querySelector('.actual'); //seleciona la clase mostrae
    if (tabAnterior) {
        tabAnterior.classList.remove('actual'); //elimina la clase mostrar
    }

    //! Resalta tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');

}

//! cambia la seccion cuando se muestran los tabs
function tabs() {

    const botones = document.querySelectorAll('.tabs button');
    //todo: se ejecuta una vez por cada elemento que alla en el selector document.querySelectorAll('.tabs button');
    botones.forEach(boton => { //boton=> es un array function
        boton.addEventListener('click', function (e) { //cada vez que se de click
            //?parseInt: convierte a entero,
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();

        })
    })

}

//! ocultar o mostra botones anterior y seguiente
function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');
    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
    } else if (paso == 2) {
        paginaSiguiente.classList.remove('ocultar');
        paginaAnterior.classList.remove('ocultar');
    }
    mostrarSeccion(); // Hace que se muestre la seccion de acuerdo al paginador
    if (paso === 3) { // valida que estemos en la seccion de resumen
        mostrarResumen();
    }
}

//! Hacer que cambie de seleccion de tab a traves del boton anterior
function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function () {

        if (paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    });
}

//! Hacer que cambie de seleccion de tab a traves del boton siguiente
function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function () {

        if (paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    });

}
//? funcion asyncrona: la funcion se ejecutara y las siguientes tambien independientemente si se cumple la asyncrona
//? await: hace que no se ejecuten siguientes lineas de la funcion hasta que se cumpla todo lo que tiene conlleva el await
async function consultarAPI() {
    try {
        //? location.origin: detecta donde se esta ejecutando el codigo y lo agrega(http://localhost:3000)
        const url = `${location.origin}/api/servicios`; // consulta la base de datos
        //todo hace que primero se descargue todo el contenido de url para continuar en la siguiente linea
        const resultado = await fetch(url); // consultamos la API con fetch
        const servicios = await resultado.json(); // obtenemos los resultados con json
        mostrarServicios(servicios) //pasamos a otra funcion los resultados
    } catch (error) { //los errores que hay en try son cachados por catch
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => { //para ir iternado sobre cada uno de ellos
        const {
            id,
            nombre,
            precio
        } = servicio //creamos las variables
        //todo variable de nombre
        const nombreServicio = document.createElement('P'); // se crea un parrafo
        nombreServicio.classList.add('nombre-servicio'); // se crea una clase
        nombreServicio.textContent = nombre; // se crea el contenido del parrafo

        //todo variable de precio
        const precioServicio = document.createElement('P'); // se crea un parrafo
        precioServicio.classList.add('precio-servicio'); // se crea una clase
        precioServicio.textContent = `$${precio}`; // se crea el contenido del parrafo

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;


        servicioDiv.appendChild(nombreServicio); // se agrega contenido al div ( en este caso el parrafo nombre)
        servicioDiv.appendChild(precioServicio); // se agrega contenido al div ( en este caso el parrafo precio)

        document.querySelector('#servicios').appendChild(servicioDiv); //a el id servicis de html le agrega el contenido de servicioDiv

        //! pasar solo el servicio seleccionado
        servicioDiv.onclick = function () { // es un col back
            seleccionarServicio(servicio);
        }
    });
}

function seleccionarServicio(servicio) {
    const {
        id
    } = servicio;
    const {
        servicios
    } = cita; //extraer de el arreglo de servicios

    //! Identificar el elemento al que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
    //! comprobra si un servicio ya fue quitado o agregado
    //? servicios.some: determina si ya existe
    //?'  agregado=>agregado.id===id: agregado:variable de servicios de cita  
    //? agregado.id: variable id de la instancia de servicios a traves de cita
    //? id: es el id que se extrae de servicio¿


    if (servicios.some(agregado => agregado.id === id)) {
        //!Deseleccionar
        cita.servicios = servicios.filter(agregado => agregado.id !== id); //elimina el registro 
        divServicio.classList.remove('seleccionado'); //eliminar la clase
    } else {
        //! seleccionarlo
        //? ...servicios: hace que tome una copia con informacion
        cita.servicios = [...servicios, servicio]; // tomar una copia del arreglo de servicios yy se le agrega el nuevo servicio
        divServicio.classList.add('seleccionado'); //agregar la clase
    }
}

/*  const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
 divServicio.classList.add('seleccionado');
 */

function idCliente() {
    const id = document.querySelector('#id').value;
    cita.id = id; // en el arreglo cita al nombre le pasamos el valor de nombre
}

function nombreCliente() {
    const nombre = document.querySelector('#nombre').value;
    cita.nombre = nombre; // en el arreglo cita al nombre le pasamos el valor de nombre


}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function (e) {

        //todo funcion que arroja el valor del dia domingo es 0 y sabado es 6
        const dia = new Date(e.target.value).getUTCDay();
        if ([6, 0].includes(dia)) { //en caso de ser domingo o sabado hacer:
            e.target.value = ''; //le quita el valor a  la fecha
            mostrarAlerta('Los fines de semana no estan disponibles', 'error', '.formulario');
        } else {

            cita.fecha = e.target.value; // le asigna el valor a la fecha
        }
    });
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function (e) {

        //todo funcion que arroja el valor del dia domingo es 0 y sabado es 6
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0]; //? split: separador de string 


        if (hora < 10 || hora > 18) {
            mostrarAlerta('Hora no válida', 'error', '.formulario');
        } else {
            cita.hora = e.target.value;
        }
    });
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
    const alertaPrevia = document.querySelector('.alerta');
    // evitar que se llene de alertas
    if (alertaPrevia) {
        alertaPrevia.remove();
    }
    //!Escriptin para crear alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento); //seleccionamos el fomrulario ya que es el paso 2
    referencia.appendChild(alerta); // le agregamos la alerta

    //! eliminar alerta
    if (desaparece) {
        setTimeout(() => {
            alerta.remove(); //despues de 3 segundos eliminar alerta
        }, 4000);
    }
}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');
    //! Limpiar contenido de resumen
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    // cita es un objeto
    // todo iteramos sobre citas con Object.values y determinamos si include string vacio includes('')
    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan datos de servicios, fecha u hora', 'error', '.contenido-resumen', false);
        return; // evita que lo demas  se ejecute
    }
    mostrarAlerta('Has completado el formulario', 'exito', '.contenido-resumen', false);

    //! Formatear el div de resumen
    // todo extraccion de variables de cita
    const {
        nombre,
        fecha,
        hora,
        servicios
    } = cita;


    //! Heading para servicios y resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    let total = 0;
    //! servicio=>: es una instancia 'function servicio(servicio)'
    servicios.forEach(servicio => {
        //!extraccion de las variable sde servicio
        const {
            id,
            nombre,
            precio
        } = servicio;
        //! Scriptin para crear html de los servicios
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenido-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;
        textoServicio.classList.add('nombre-servicio');

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        //suma del total
        n1 = parseFloat(precio);
        total = total + n1;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    }) // fin foreach

    //!  Crear scriptin html para datos de la cita

    //! Heading para servicios y resumen
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);


    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;


    //!Formatear la fecha en español
    const dateObjeto = new Date(fecha); // instancia de la fecha que el usuario ingresa
    const month = dateObjeto.getMonth(); //Obtenemos el mes de la fecha ingresada por el usuario
    const day = dateObjeto.getDate() + 2; // el +2 es porque la fecha se recorre 2 dias al ser usada 2 veces Obtenemos el dia del mes de la fecha ingresada por el usuario, getDay() retorna el dia de la semana
    const year = dateObjeto.getFullYear(); //Obtenemos el año de la fecha ingresada por el usuario

    const dateUTC = new Date(Date.UTC(year, month, day));

    //? toLocaleDateString: retorna una fecha formateada y funciona con objetos de fecha no con string

    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    } // viernes, 28 de julio de 2023
    const dateFormated = dateUTC.toLocaleDateString('es-MX', options); // lo formatea en español

    const fechaCliente = document.createElement('P');
    fechaCliente.innerHTML = `<span>Fecha:</span> ${dateFormated}`;

    const horaCliente = document.createElement('P');
    horaCliente.innerHTML = `<span>Hora:</span> ${hora} horas`;

    const totalServicios = document.createElement('P');
    totalServicios.innerHTML = `<span>Total: </span>$${total}`;

    //!Boton para crear cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCliente);
    resumen.appendChild(horaCliente);
    resumen.appendChild(totalServicios);
    resumen.appendChild(botonReservar);


}

//todo uso de FETCH para base de datos
async function reservarCita() {
    // console.log(['ejecutando...']);// toma una copia de FormData() y lo formatea
    const {
        id,
        nombre,
        fecha,
        hora,
        servicios
    } = cita; // extraemos las variables de cita

    //? map: las coincidencias las ira colocando en la variable
    const idServicios = servicios.map(servicio => servicio.id);
    const datos = new FormData(); // para instanciar los datos del servidor
    //? append: agregar datos al servidor;
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);

    try {

        //! Peticion hacia la API
        const url = `${location.origin}/api/citas`;

        //todo usamos asyn await por la demora en la que el servidor responde y asi bloqueamos el codigo
        const respuesta = await fetch(url, {
            method: 'POST', // se usuara metodo post hacia la url http://127.0.0.1:3000/api/citas , luego en app.js tenemos api/citas registrado  con metodo post y se conectada js con controlador de la api definido
            body: datos //identifica los datos que vienen de FormData()
        });
        const resultado = await respuesta.json();

        //! Mostrar un alaerta con codigo sweetalert2
        if (resultado.resultado) {
            Swal.fire({
                icon: 'success',
                title: 'Cita Creada',
                text: '¡Tu cita ha sido creada correctamente!',
                button: 'OK'
            }).then(() => {
                setTimeout(() => {
                    window.location.reload(); //recarcar la pagina despues de seleccionar el boton OK
                }, 4000);
            })
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al guardar la cita',
            button: 'OK'
        })
    }



}