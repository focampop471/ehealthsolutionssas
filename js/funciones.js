/**
* Funcion que permite cambiar el source y el caption de una imagen
* @param lista objeto de tipo HTMLinputSelect
*/
function cambiarImagen(lista){
  //Split a los valores que vienen en el value
  var valores = lista.options[lista.selectedIndex].value.split('|');
  img_src = valores[0];
  img_caption = valores[1];
  //Asigno el source de la imagen
  document.getElementById('foto_galeria').src = img_src;
  //Asigno el caption de la imagen
  document.getElementById('label_galeria').innerHTML = img_caption;
}


/**
* Funcion que permite agregar un nuevo interes
*/
function agregarInteres() {
  if(cont_intereses_nuevos < 5){
    //Traigo la tabla
    var tabla = document.getElementById('intereses_nuevos');
    //Creo una nueva fila
    var tr = document.createElement('TR');
    tr.id = 'interes_' + seq_intereses_nuevos;
    //Creo una nueva celda
    var td1 = document.createElement('TD');
    //Creo una nueva celda
    var td2 = document.createElement('TD');
    //Creo una nueva entrada de texto
    var input = document.createElement('INPUT');
    input.name = 'otros_intereses[]';
    input.type = 'text';
	input.placeholder = 'Ingresa tu interes';
    // Agrego el input a la celda
    td1.appendChild(input);
    // Agrego la celda a la fila
    tr.appendChild(td1);
    // Agrego la celda a la fila
    td2.innerHTML='<a href="javascript:eliminarInteres(\'interes_' + seq_intereses_nuevos + '\')">[ X ]</a>';
    tr.appendChild(td2);
    // Agrego la fila a la tabla
    tabla.appendChild(tr);
    seq_intereses_nuevos++;
    cont_intereses_nuevos++;
  }
  else
    alert('No puede adicionar mas de cinco (5) intereses');
  
}


/**
* Funcion que permite eliminar un interes
* @param interes fila de la tabla de intereses a eliminar
*/
function eliminarInteres(interes) {
  //Obtengo la fila por el id
  var fila = document.getElementById(interes);
  fila.innerHTML = '';
  cont_intereses_nuevos--;
}
