$(function () {
  $(".btn-save-fechas").on("click", function () {
    let form = $("#" + $(this).data("formulario"));
    let tipo_form = $(this).data("tipo");
    let url = tipo_form == "nuevo" ? "guardarFechas" : "actualizarDocumento";
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
  async function cardsFechas() {
    console.log("Entras");
    try {
      let peticion = await fetch(servidor + `admin/infoFechas/${fechas}`);
      let response = await peticion.json();
      console.log(response);
      if (response.length == 0) {
        jQuery(
          `<h3 class="mt-4 text-center text-uppercase">Sin fechas asignadas</h3>`
        )
          .appendTo("#container-fechas")
          .addClass("text-danger");
        return false;
      }
      response.forEach((item, index) => {
        jQuery(`
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                        <div class="h-100 card card-profile card-plain move-on-hover border border-dark">
                            <div class="card-body text-center bg-white shadow border-radius-lg p-3">
                                <h5 class="mt-3 mb-1 d-md-block ">${
                                  item.fecha_programa
                                }</h5>
                                <div class="row mt-3">
                                    <!--<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <button data-fecha="${
                                          item.fecha_programa
                                        }" data-id="${btoa(
          btoa(item.id_fecha_programa)
        )}" class="btn btn-danger form-control btn-delete-fecha"><i class="fa-solid fa-trash"></i> Eliminar</button>
                                    </div>-->
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <a href="${servidor}admin/salones/${btoa(
          btoa(item.id_fecha_programa)
        )}/${btoa(btoa(item.fk_id_programa))}/${btoa(
          item.fecha_programa
        )}" class="btn btn-dark form-control">Administrar <i class="fa-solid fa-gear"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `).appendTo("#container-fechas");
      });
    } catch (error) {
      if (error.name == "AbortError") {
      } else {
        throw error;
      }
    }
  }
  cardsFechas();
  $("#container-fechas").on("click", ".btn-delete-fecha", function () {
    Swal.fire({
      title: `Desea eliminar la fecha \n'${$(this).data("fecha")}'?`,
      text: `Tenga en cuenta que al eliminar la fecha se eliminaran todas las asignaciones relacionadas con la misma (salones, capitulos,actividades, temas).\n Los catalogos creados no se veran afectados.`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#82d616",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminar!",
      cancelButtonText: "No, cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        editarPrograma($(this).data('id'))
      }
    });
  });
  function editarPrograma(idfecha) {
    $.ajax({
      type: "POST",
      url: servidor + `admin/eliminarFecha/${idfecha}`,
      dataType: "json",
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
});
