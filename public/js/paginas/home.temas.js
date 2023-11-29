$(function () {
    $(".btn-save-temas").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        let tipo_form = $(this).data("tipo");
        let url = (tipo_form == 'nuevo') ? 'guardarTemas' : 'actualizarDocumento';
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $.ajax({
                type: "POST",
                url: servidor + "admin/" + url,
                dataType: "json",
                data: new FormData(form.get(0)),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    // setting a timeout
                    $("#loading").addClass("loading");
                },
                success: function (data) {
                    console.log(data);
                    Swal.fire({
                        position: "top-end",
                        icon: data.estatus,
                        title: data.titulo,
                        text: data.respuesta,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                },
                error: function (data) {
                    console.log("Error ajax");
                    console.log(data);
                    /* console.log(data.log); */
                },
                complete: function () {
                    $("#loading").removeClass("loading");
                },
            });
        }
        form.addClass("was-validated");
    });
    $(".btn-save-profesores").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        let tipo_form = $(this).data("tipo");
        let url = (tipo_form == 'nuevo') ? 'guardarProfesor' : 'actualizarDocumento';
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $.ajax({
                type: "POST",
                url: servidor + "admin/" + url,
                dataType: "json",
                data: new FormData(form.get(0)),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    // setting a timeout
                    $("#loading").addClass("loading");
                },
                success: function (data) {
                    console.log(data);
                    Swal.fire({
                        position: "top-end",
                        icon: data.estatus,
                        title: data.titulo,
                        text: data.respuesta,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    profesores('#profesor');
                    $('#modalNuevoProfesor').modal('hide')
                },
                error: function (data) {
                    console.log("Error ajax");
                    console.log(data);
                    /* console.log(data.log); */
                },
                complete: function () {
                    $("#loading").removeClass("loading");
                },
            });
        }
        form.addClass("was-validated");
    });
    async function tablaTemas() {
        try {
            let peticion = await fetch(servidor + `admin/infoTemas/${fechas}/${salon}/${capitulo}/${actividad}`);
            let response = await peticion.json();
            $("#container-temas").empty();
            if (response.length == 0) {
                jQuery(`<h2>Sin temas asignados</h2>`).appendTo("#container-temas").addClass('text-danger text-center text-uppercase');
                return false;
            }
            jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-result">
            <thead><tr>
            <th class="text-uppercase">Tema</th><th class="text-uppercase">Hora inicial</th><th class="text-uppercase">Horal final</th><th class="text-uppercase">Profesor</th><th class="text-uppercase">Modalidad</th>
            </tr></thead>
            </table>`).appendTo("#container-temas").removeClass('text-danger');

            $('#info-table-result').DataTable({
                "drawCallback": function (settings) {
                    $('.paginate_button').addClass("btn").removeClass("paginate_button");
                    $('.dataTables_length').addClass('pull-left');
                    $('#info-table-result_filter').addClass('pull-right');
                    $('input').addClass("form-control");
                    $('select').addClass('form-control');
                    $('.previous.disabled').addClass("btn-outline-info opacity-5 btn-rounded mx-2 mt-3");
                    $('.next.disabled').addClass("btn-outline-info opacity-5 btn-rounded mx-2 mt-3");
                    $('.previous').addClass("btn-outline-info btn-rounded mx-2 mt-3");
                    $('.next').addClass("btn-outline-info btn-rounded mx-2 mt-3");
                },
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                "pageLength": 5,
                "lengthMenu": [[5, 10, -1], [5, 10, "All"]],
                data: response,
                "columns": [
                    { "data": "nombre_tema", className: 'text-vertical text-center' },
                    { "data": "hora_inicial", className: 'text-vertical text-center' },
                    { "data": "hora_final", className: 'text-vertical text-center' },
                    { "data": "nombreprofesor", className: 'text-vertical text-center' },
                    { "data": "nombre_modalidad", className: 'text-vertical text-center' },
                ]
            });
        } catch (error) {
            console.log(error);
        }
    }
    tablaTemas();
    $('#asignar_tema').change(function () {
        if ($(this).val() == "agregar_tema") {
            $('#contenedor-agregar').removeClass('d-none');
            $('#nuevo_tema').attr('disabled', false);
            $('#nuevo_tema').attr('required', true);
        } else {
            $('#contenedor-agregar').addClass('d-none');
            $('#nuevo_tema').val("");
            $('#nuevo_tema').attr('disabled', true);
            $('#nuevo_tema').attr('required', false);
        }
    });
    $('#profesor').change(function () {
        if ($(this).val() == "agregar_profesor") {
            $('#modalNuevoProfesor').modal('show')
        } else {
            $('#modalNuevoProfesor').modal('hide')
        }
    });
    async function temas(identificador) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_temas/${fechas}/${salon}/${capitulo}/${actividad}/${programa}`);
            let response = await peticion.json();
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar actividad...';
            let option_select2 = document.createElement("option")
            option_select2.value = 'agregar_tema';
            option_select2.text = 'Crear nuevo tema';
            $(identificador).append(option_select);
            $(identificador).append(option_select2);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_tema;
                option.text = item.nombre_tema
                $(identificador).append(option)
            }
            console.log('cargando temas ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    temas('#asignar_tema');
    async function profesores(identificador) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_profesores`);
            let response = await peticion.json();
            console.log(response);
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar profesor...';
            let option_select2 = document.createElement("option")
            option_select2.value = 'agregar_profesor';
            option_select2.text = 'Crear nuevo profesor';
            $(identificador).append(option_select);
            $(identificador).append(option_select2);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_profesor;
                option.text = item.profesor + ' - (' + item.pais + '/' + item.estado + ')'
                $(identificador).append(option)
            }
            console.log('cargando profesores ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    profesores('#profesor');
    async function modalidades(identificador) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_modalidades`);
            let response = await peticion.json();
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar modalidad...';
            $(identificador).append(option_select);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_modalidad;
                option.text = item.nombre_modalidad
                $(identificador).append(option)
            }
            console.log('cargando profesores ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    modalidades('#modalidad');
    async function prefijos(identificador) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_prefijos`);
            let response = await peticion.json();
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar prefijo...';
            $(identificador).append(option_select);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_prefijo;
                option.text = item.siglas_prefijo + ' - ' + item.nombre_prefijo
                $(identificador).append(option)
            }
            console.log('cargando profesores ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    prefijos('#prefijo');
    async function ladas(identificador) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_ladas`);
            let response = await peticion.json();
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar lada...';
            $(identificador).append(option_select);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_lada;
                option.text = item.numero_lada + ' - ' + item.nombre_lada
                $(identificador).append(option)
            }
            console.log('cargando ladas ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    ladas('#lada');
    async function cat_paises(identificador) {
        try {
          $("#" + identificador).empty();
          let peticion = await fetch(servidor + `admin/cat_paises`);
          let response = await peticion.json();
          let option_select = document.createElement("option");
          option_select.value = "";
          option_select.text = "Seleccionar País...";
          $("#" + identificador).append(option_select);
          for (let item of response) {
            let option = document.createElement("option");
            option.value = item.id_pais;
            option.text = item.pais;
            $("#" + identificador).append(option);
          }
          console.log("cargando países ...");
        } catch (err) {
          if (err.name == "AbortError") {
          } else {
            throw err;
          }
        }
      }
      cat_paises('pais');
      async function cat_estados(identificador, bus = null) {
        try {
          $("#" + identificador).empty();
          let peticion = await fetch(servidor + `admin/cat_estados/${bus}`);
          let response = await peticion.json();
          /* console.log(response); */
          let option_select = document.createElement("option");
          option_select.value = "";
          option_select.text = "Seleccionar estado...";
          $("#" + identificador).append(option_select);
          for (let item of response) {
            let option = document.createElement("option");
            option.value = item.id_estado;
            option.text = item.estado;
            $("#" + identificador).append(option);
          }
          console.log("cargando estados ...");
        } catch (err) {
          if (err.name == "AbortError") {
          } else {
            throw err;
          }
        }
      }
    $('#pais').change(function () {
        cat_estados('estado', $(this).val());
    })
});