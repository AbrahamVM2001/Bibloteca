$(function(){
    $(document).ready(function() {
        $("#btn-registro").click(function () {
            let form = $("#form-new-registro");
            if (form[0].checkValidity() === false) {
                event.preventDefault()
                event.stopPropagation()
            } else {
                $.ajax({
                    type : 'POST',
                    url  : servidor + 'login/registro',
                    dataType: 'json',
                    data : form.serialize(),
                beforeSend: function() {
                    // setting a timeout
                    $("#loading").addClass('loading');
                },
                success :  function(data){
                        Swal.fire({
                        icon: data.estatus,
                        title: data.titulo,
                        text: data.respuesta,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    if (data.estatus == 'success') {
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                },
                error: function (data) {
                    console.log(data);
                },
                complete: function() {
                    $("#loading").removeClass('loading');
                }
            });
        }
        form.addClass('was-validated');
        });
        $("#btn-acceso").click(function () {
            let form = $("#form-new-iniciar");
            if (form[0].checkValidity() === false) {
                event.preventDefault()
                event.stopPropagation()
            } else {
                $.ajax({
                    type : 'POST',
                    url  : servidor + 'login/acceso',
                    dataType: 'json',
                    data : form.serialize(),
                beforeSend: function() {
                    // setting a timeout
                    $("#loading").addClass('loading');
                },
                success :  function(data){
                    Swal.fire({
                        icon: data.estatus,
                        title: data.titulo,
                        text: data.respuesta,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    if (data.estatus == 'success') {
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                },
                error: function (data) {
                    console.log(data);
                },
                complete: function() {
                    $("#loading").removeClass('loading');
                }
            });
        }
        form.addClass('was-validated');
        });
    });
});