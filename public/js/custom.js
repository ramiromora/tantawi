///escript para el CKEditor
function myFunction() {
    var select  = $("#user_id2 option:selected").text();
    var valor   = $("#user_id2").val();
    //alert(valor);
    //alert(select);
    $.ajax({
        url:"/api/cargo",
        type:'POST',                
        data:{
            "id":valor
        },  
            success:function(data){
                $('#cargo').fadeIn();
                var str1 = "Cargo: ";
                var res = str1.concat(data);  
                $('#cargo').html(res);             
            }
    })
}
function myFunction3() {    
 var select  = $("#committee_id option:selected").text();////este es el nombre del select box
    var valor   = $("#committee_id").val();
    //alert(valor);
    //alert(select);
    $.ajax({
        url:"/api/comite",
        type:'POST',                
        data:{
            "id":valor
        },  
        success:function(data){
                $('#miembros').fadeIn();
                var str1 = "<b>Miembros:</b> <br> ";
                $.each(data,function(index,val){
                        str1 = str1.concat("<input type='checkbox' name='members[]' value='");
                        str1 = str1.concat(val.id);
                        str1 = str1.concat("' checked>");
                        str1 = str1.concat(val.name);///aqui we :v
                        str1 = str1.concat("</br>");
                });
                str1 = str1.concat("<br><div class='alert alert-info' role='alert'><i><b>En caso de no estar ningun representante del grupo seleccionado Usted quedara como unico representante</b></i></div>");
                $('#miembros').html(str1);  ////# cargo es el nombre del div en la vista    <input type="checkbox" name="skills[b]" value="mysql">MySql</br> 
        }
    })               
}
function mF4() {
    var ids = new Array();
    $( "#departaments option:selected" ).each(function() {
        ids.push($( this ).val());
    });
    $.ajax({
        url:"/department/users",
        type:'get',                
        data:{
            "ids[]":ids
        },
        success:function(data){
            //toastr.warning(data);
            //return false;
            $('#miembros').fadeIn();
            var str1 = "<label for='users'>Participantes de la OFEP </label> <select class='form-control select2-multiples' id='users' name='users[]'  multiple='multiple'> ";
            $.each(data,function(index,val){
                str1 = str1.concat("<option value='"+val.id+"' >"+val.name+"</option>");
            });
            str1 = str1.concat("</select>");
            $('#miembros').html(str1); 
            $('.select2-multiples').select2();
        }
    })  
    
    
}
///agregar estas funciones
function mifuncion4(){
    document.getElementById("compani").disabled = true;    
    $('#nueva').fadeIn();
    var str1 = "<label for='institution'>Agregar nueva institución</label><input type='text' class='form-control' name='institution' required>";   
    $('#nueva').html(str1); 
}
function mifuncion5(){
    document.getElementById("compani").disabled = false;    
    $('#nueva').fadeIn();
    var str1 = "";   
    $('#nueva').html(str1); 
}



function mostrarReferencia(){
    //Si la opcion con id Conocido_1 (dentro del documento > formulario con name fcontacto >
    ///     y a la vez dentro del array de Conocido) esta activada
    if (document.guests_a.company[1].checked == true) {
    //muestra (cambiando la propiedad display del estilo) el div con id 'desdeotro'
    document.getElementById('otro').style.display='block';
    //por el contrario, si no esta seleccionada
    } else {
    //oculta el div con id 'desdeotro'
    document.getElementById('otro').style.display='none';
    }
}

function mostrarReferencia2(){
    //Si la opcion con id Conocido_1 (dentro del documento > formulario con name fcontacto >
    ///     y a la vez dentro del array de Conocido) esta activada
    if (document.act_new.addres1[1].checked == true) {
    //muestra (cambiando la propiedad display del estilo) el div con id 'desdeotro'
    document.getElementById('direccion').style.display='block';
    //por el contrario, si no esta seleccionada
    } else {
    //oculta el div con id 'desdeotro'
    document.getElementById('direccion').style.display='none';
    }
}
$(document).on('click','.create-modal', function(){
    $('#create').modal('show');
    $('.form-horizontal').show();
    $('.modal-title').text('Añadir invitado');
});

//CKEDITOR.replace('body_o');

  