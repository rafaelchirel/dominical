function monto (event) {
    $(event.target).val(function(index, value) {
      return value.replace(/\D/g, "")
        .replace(/([0-9])([0-9]{1})$/, '$1,$2')
        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
    });
}

function soloLetras(e) {
    key            = e.keyCode || e.which;
    tecla          = String.fromCharCode(key).toLowerCase();
    letras         = "Ã¡Ã©Ã­Ã³ÃºabcdefghijklmnÃ±opqrstuvwxyzñ";
    especiales     = [08, 7, 39, 46, 13, 32];
    tecla_especial = false;
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }
    if (letras.indexOf(tecla) == -1 && !tecla_especial){
        return false;
    }
}

//Numero enteros
function SoloNumeros(evt){
     if(window.event){//asignamos el valor de la tecla a keynum
      keynum = evt.keyCode; //IE
     }
     else{
      keynum = evt.which; //FF
     } 
     //comprobamos si se encuentra en el rango numérico y que teclas no recibirá.
     if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6){
      return true;
     }
     else{
      return false;
     }
}

function cedula(e){
      tecla = (document.all) ? e.keyCode : e.which;
      tecla = String.fromCharCode(tecla);
      //  /^(V|E){1}(-){1}([0-9]){7,8}(-[1-9]\d?)?$/
      //return /^[0-9\-\Vv\Ee]+$/.test(tecla);
      return /^[XxTtYyZz]{1}[0-9]{7}[a-zA-Z]{1}$/.test(tecla);
}

