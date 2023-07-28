let paso=1;const pasoInicial=1,pasoFinal=3,cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){mostrarSeccion(),tabs(),botonesPaginador(),paginaAnterior(),paginaSiguiente(),consultarAPI(),idCliente(),nombreCliente(),seleccionarFecha(),seleccionarHora(),mostrarResumen()}function mostrarSeccion(){
//! Ocultar la seccion que tenga la clase de mostrar
const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar");
//! Seleccionar la seccion con el paso
const t="#paso-"+paso;document.querySelector(t).classList.add("mostrar");
//! Quiatr resaltado a quien tenga la clase actual
const o=document.querySelector(".actual");o&&o.classList.remove("actual");
//! Resalta tab actual
document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}
//! cambia la seccion cuando se muestran los tabs
function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarSeccion(),botonesPaginador()}))})}
//! ocultar o mostra botones anterior y seguiente
function botonesPaginador(){const e=document.querySelector("#anterior"),t=document.querySelector("#siguiente");1===paso?(e.classList.add("ocultar"),t.classList.remove("ocultar")):3===paso?(e.classList.remove("ocultar"),t.classList.add("ocultar")):2==paso&&(t.classList.remove("ocultar"),e.classList.remove("ocultar")),mostrarSeccion(),3===paso&&mostrarResumen()}
//! Hacer que cambie de seleccion de tab a traves del boton anterior
function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<=1||(paso--,botonesPaginador())}))}
//! Hacer que cambie de seleccion de tab a traves del boton siguiente
function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=3||(paso++,botonesPaginador())}))}async function consultarAPI(){try{const e=location.origin+"/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:o,precio:n}=e,a=document.createElement("P");a.classList.add("nombre-servicio"),a.textContent=o;const c=document.createElement("P");c.classList.add("precio-servicio"),c.textContent="$"+n;const r=document.createElement("DIV");r.classList.add("servicio"),r.dataset.idServicio=t,r.appendChild(a),r.appendChild(c),document.querySelector("#servicios").appendChild(r),
//! pasar solo el servicio seleccionado
r.onclick=function(){seleccionarServicio(e)}})}function seleccionarServicio(e){const{id:t}=e,{servicios:o}=cita,n=document.querySelector(`[data-id-servicio="${t}"]`);
//! comprobra si un servicio ya fue quitado o agregado
o.some(e=>e.id===t)?(
//!Deseleccionar
cita.servicios=o.filter(e=>e.id!==t),n.classList.remove("seleccionado")):(
//! seleccionarlo
cita.servicios=[...o,e],n.classList.add("seleccionado"))}function idCliente(){const e=document.querySelector("#id").value;cita.id=e}function nombreCliente(){const e=document.querySelector("#nombre").value;cita.nombre=e}function seleccionarFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?(e.target.value="",mostrarAlerta("Los fines de semana no estan disponibles","error",".formulario")):cita.fecha=e.target.value}))}function seleccionarHora(){document.querySelector("#hora").addEventListener("input",(function(e){const t=e.target.value.split(":")[0];t<10||t>18?mostrarAlerta("Hora no válida","error",".formulario"):cita.hora=e.target.value}))}function mostrarAlerta(e,t,o,n=!0){const a=document.querySelector(".alerta");a&&a.remove();
//!Escriptin para crear alerta
const c=document.createElement("DIV");c.textContent=e,c.classList.add("alerta"),c.classList.add(t);document.querySelector(o).appendChild(c),
//! eliminar alerta
n&&setTimeout(()=>{c.remove()},4e3)}function mostrarResumen(){const e=document.querySelector(".contenido-resumen");
//! Limpiar contenido de resumen
for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return void mostrarAlerta("Faltan datos de servicios, fecha u hora","error",".contenido-resumen",!1);mostrarAlerta("Has completado el formulario","exito",".contenido-resumen",!1);
//! Formatear el div de resumen
const{nombre:t,fecha:o,hora:n,servicios:a}=cita,c=document.createElement("H3");
//! Heading para servicios y resumen
c.textContent="Resumen de Servicios",e.appendChild(c);let r=0;
//! servicio=>: es una instancia 'function servicio(servicio)'
a.forEach(t=>{
//!extraccion de las variable sde servicio
const{id:o,nombre:n,precio:a}=t,c=document.createElement("DIV");
//! Scriptin para crear html de los servicios
c.classList.add("contenido-servicio");const i=document.createElement("P");i.textContent=n,i.classList.add("nombre-servicio");const s=document.createElement("P");s.innerHTML="<span>Precio:</span> $"+a,n1=parseFloat(a),r+=n1,c.appendChild(i),c.appendChild(s),e.appendChild(c)});
//!  Crear scriptin html para datos de la cita
//! Heading para servicios y resumen
const i=document.createElement("H3");i.textContent="Resumen de Cita",e.appendChild(i);const s=document.createElement("P");s.innerHTML="<span>Nombre:</span> "+t;
//!Formatear la fecha en español
const d=new Date(o),l=d.getMonth(),u=d.getDate()+2,m=d.getFullYear(),p=new Date(Date.UTC(m,l,u)).toLocaleDateString("es-MX",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),v=document.createElement("P");v.innerHTML="<span>Fecha:</span> "+p;const h=document.createElement("P");h.innerHTML=`<span>Hora:</span> ${n} horas`;const f=document.createElement("P");f.innerHTML="<span>Total: </span>$"+r;
//!Boton para crear cita
const C=document.createElement("BUTTON");C.classList.add("boton"),C.textContent="Reservar Cita",C.onclick=reservarCita,e.appendChild(s),e.appendChild(v),e.appendChild(h),e.appendChild(f),e.appendChild(C)}async function reservarCita(){const{id:e,nombre:t,fecha:o,hora:n,servicios:a}=cita,c=a.map(e=>e.id),r=new FormData;r.append("fecha",o),r.append("hora",n),r.append("usuarioId",e),r.append("servicios",c);try{
//! Peticion hacia la API
const e=location.origin+"/api/citas",t=await fetch(e,{method:"POST",body:r});
//! Mostrar un alaerta con codigo sweetalert2
(await t.json()).resultado&&Swal.fire({icon:"success",title:"Cita Creada",text:"¡Tu cita ha sido creada correctamente!",button:"OK"}).then(()=>{setTimeout(()=>{window.location.reload()},4e3)})}catch(e){Swal.fire({icon:"error",title:"Error",text:"Hubo un error al guardar la cita",button:"OK"})}}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));