function target_popup(form) {
    window.open('', 'formpopup', 'width=400,height=400,resizeable,scrollbars');
    form.target = 'formpopup';
}

function guardar()
{
    let abono = $('#abono').val();
    let abonoModify = ($('#abono_modify').val() == "") ? "$0" : $('#abono_modify').val();
    if(abonoModify != "$0"){
        if (confirm(`Esta seguro que desea cambiar el valor del abono de ${abono} por ${abonoModify} al credito`))
        {      
            console.log("Prueba")
        }
        else
        {
            window.close();
        }
    }else{
        alert("El valor del abono no puede ser 0")
    }

    
}