function listarTodosCarrito() {
    // Realizar la petición AJAX para obtener los datos
      $.ajax({
          url: '../Controllers/CarritoController.php?op=ListarCarrito',
          type: 'POST',
          dataType: 'html',
          success: function(data) {
              // Insertar el HTML generado en el contenedor deseado
              $('#ContenedorCarrito').html(data);
          },
          error: function(e) {
              console.log(e.responseText);
          }
      });
  
  }

  function listarResumen() {
    // Realizar la petición AJAX para obtener los datos
      $.ajax({
          url: '../Controllers/CarritoController.php?op=ListarResumen',
          type: 'POST',
          dataType: 'html',
          success: function(data) {
              // Insertar el HTML generado en el contenedor deseado
              $('#Resumen').html(data);
          },
          error: function(e) {
              console.log(e.responseText);
          }
      });
  
  }

 
  $(document).ready(function () {
    $(document).on('click', '.eliminar-linea', function () {
        var id = $(this).data('id');
        //Para eliminar el producto sin necesidad de recargar la pagina
        var fila = $(this).closest('.row'); 
        EliminarLinea(id ,fila);
    });
});

function EliminarLinea(id, fila) {
    bootbox.confirm('¿Desea modificar los datos?', function (result) {
        if (result) {
            $.post(
                '../Controllers/CarritoController.php?op=EliminarLinea',
                { idLinea: id },
                function (data) {
                    switch (data) {
                        case '1':
                            toastr.success('Eliminado correctamente');
                            //Hacer los cambios en vivo
                            fila.remove(); 
                            listarResumen();
                            break;
    
                        case '0':
                            toastr.error('Error: No se pudo eliminar el producto');
                            break;
    
                        default:
                            toastr.error("Error: No se encontró el ID");
                            break;
                    }
                }
            );
        };
    });
}
$(document).ready(function () {
    $(document).on('click', '#btnPagar', function(event) {
        var sesionIniciada = $(this).data('sesion') === true;
        var tieneProductos = $(this).data('productos') === true;

        if (!sesionIniciada) {
            toastr.error('Debe iniciar sesión antes de pagar.');
            event.preventDefault();
        } else if (!tieneProductos) {
            toastr.error('Debe agregar al menos un producto al carrito antes de pagar.');
            event.preventDefault();
        }
    });
});



$(function(){
    listarTodosCarrito();
  });
  $(function(){
    listarResumen();
  });