/*function validacaoEmail(field) {
   console.log(field.value);
  usuario = field.value.substring(0, field.value.indexOf("@"));
  console.log(usuario);
  dominio = field.value.substring(field.value.indexOf("@") + 1, field.value.length);
  console.log(dominio);
    if(usuario.length >= 1){count=true;}
    else{console.log("Caracteres antes do @ nao suficientes");} 
    if(dominio.length >= 3&&count==true){count=true;}
    else{console.log("Dominio de e-mail muito curto");} 
    if(usuario.search("@") == -1&&count==true){count=true;}
    else{console.log("possui caracter antes do @");}
    if(dominio.search("@") == -1&&count==true){count=true;}
    else{console.log("possui caracter depois do @");}
    if(dominio.search(" ") == -1&&count==true){count=true;}
    else{console.log("possui espaço no email");}
    if(usuario.search(" ") == -1&&count==true){count=true;}
    else{console.log("possui espaço no email");}
    if(dominio.search(".") != -1&&count==true){count=true;}
    else{console.log("Nao tem . depois do @");}
    if(dominio.indexOf(".") >= 1&&count==true){count=true;}
    else{console.log("Nao possui caracter apos o .");}
    if(dominio.lastIndexOf(".") < dominio.length - 1||count==false){
    showToast("email valido", "success");
    } 
}*/