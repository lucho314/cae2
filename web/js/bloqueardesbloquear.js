function activar_desactivar(campo,radio) {
  var x = document.getElementById(campo);
  var r = document.getElementsByName(radio);  
    for(var i=0; i<r.length;i++){
        if(r[i].checked){
               var y=r[i].value;
        }
    }
    
    if (y=='si') {
        x.disabled = false;
    } else {
        x.value = null;
        x.readOnly=true;
    }   

}
