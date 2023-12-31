

function listarTodosArticulos() {
  articulos = $('#admin_articulos').dataTable({
      processing: true,
      serverSide: true,
      dom: 'Bfrtip',
      ajax: {
          url: '../Controllers/AdminController.php?op=MostrarArticulos',
          type: 'get',
          dataType: 'json',
      },
      destroy: true,
      displayLength: 5,
      columnDefs: [
          {
              targets: 5, // El índice de la columna que contiene la categoría
              render: function (data, type, row, meta) {
                  switch (data) {
                      case 1:
                          return 'Sudaderas';
                      case 2:
                          return 'Camisas';
                      default:
                          return 'Otro';
                  }
              }
          }
      ],
  });
}



//FUNCIONES PRINCIPALES
$(function(){
  listarTodosArticulos();
});

function limpiarForms() {
    $('#add_articulos').trigger('reset');
    $('#update_articulo').trigger('reset');
}  
function openForm() {
    document.getElementById("Form_add").style.display = "block";
  }

  function closeForm() {
    document.getElementById("Form_add").style.display = "none";
  }
//FIN DE FUNCIONES PRINCIPALES


$('#add_articulo').on('submit', function (event) {
    event.preventDefault();  
    $('#btnAnadir').prop('disabled', true);
    
    var formData = new FormData($('#add_articulo')[0]);
    $.ajax({
      url: '../Controllers/AdminController.php?op=Agregar_Articulos',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      
      success: function (datos) {
      console.log(datos);
        switch (datos) {
          case '1':
            toastr.success(
              'Articulo Agregado Correctamente'
            );
            $('#add_articulo')[0].reset();
            articulos.api().ajax.reload();
            break;
  
          case '2':
            toastr.error(
              'El Articulo ya existe'
            );
            break;
  
          case '3':
            toastr.error('Hubo un error al tratar de ingresar los datos.');
            break;
  
          default:
            toastr.error('No entran los datos');
            break;
        }
        $('#btnAnadirUsu').removeAttr('disabled');
      },
    });
  });

  
/*Habilitacion de form de modificacion al presionar el boton en la tabla*/
$('#admin_articulos').on('click', 'button[id="modificarArticulo"]', function () {
  var modal = document.getElementById("Formulario_Update");
  var span = document.getElementsByClassName("close")[0];

  // Abrir el Modal
  modal.style.display = "block";

  // Cerrar el modal con la "x"
  span.onclick = function() {
      modal.style.display = "none";
  }  
  
  // Cerrar el Modal con un clic fuera del Modal
  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
  }



  var data = $('#admin_articulos').DataTable().row($(this).parents('tr')).data();
  
  limpiarForms();
  $('#EId').val(data[0]);
  $('#Enombre').val(data[1]);
  $('#Edescripcion').val(data[2]);
  var urlImagen = $(data[3]).attr('src'); //Esta vara es para que me imprima solo la ruta de la imagen como tal en la parte de Modal para modificar
  $('#Eruta_imagen').val(urlImagen); 
  $('#Eprecio').val(data[4]);
  $('#Ecategoria').val(data[5]);
  return false;
});



  //Modificar los datos del Articulo
  $('#update_articulo').on('submit', function (event) {
    event.preventDefault();
    var result = confirm("¿Desea actualizar los datos?");
    
    if (result) {
        var formData = new FormData($('#update_articulo')[0]);
        $.ajax({
            url: '../Controllers/AdminController.php?op=Editar_Articulos',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                switch (datos) {
                    case '0':
                        toastr.error('Error: No se pudieron actualizar los datos');
                        break;
                    case '1':
                        toastr.success('Datos actualizados correctamente');
                        articulos.api().ajax.reload();
                        break;
                    case '2':
                        toastr.error('Error: El ID es incorrecto');
                        break;
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
});

function Eliminar(id) {
  var result = confirm('¿Esta seguro de eliminar el producto?');
    if (result) {
      $.post(
        '../Controllers/AdminController.php?op=Eliminar_Articulos',
        { idArticulo: id },
        function (data) {
          switch (data) {
            case '1':
              toastr.success('Eliminado correctamente');
              articulos.api().ajax.reload();
              break;

            case '0':
              toastr.error(
                'Error: No se pudo eliminar el producto'
              );
              break;

            default:
              toastr.error("Error: Alguien tiene este producto en su carrito");
              break;
          }
        }
      );
    }
  }

