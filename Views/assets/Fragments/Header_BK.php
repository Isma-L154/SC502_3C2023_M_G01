<?php session_start();
?>
<header>
  <div class="container_logo">
    <a href="./index.php">
      <img src="./assets/Img/Logo2.png" alt="LogoRode" class="Mi_logo" style="height: 85px; width: 96px;"></a>
  </div>

  <nav id="navbar">

    <div class="SearchBar">
      <form class="d-flex m-4 b-4" role="search">
        <input class="form-control me-3 " type="search" placeholder="Buscar" aria-label="Search">
        <button class="btn btn-outline-success" id="Button_Search" type="submit" onmouseover="this.style.backgroundColor='#007bff';" onmouseout="this.style.backgroundColor='#D4AF37';">Buscar
        </button>

      </form>

    </div>

    <!--Menu del Navbar-->
    <div class="navbar navbar-dark bg-dark m-2" style="background-color: #2A2A2A!important;">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation" fdprocessedid="23sb5r">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 m-3">

              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./Carrito.php" style="color: #2A2A2A; font-size: x-large;"><i class="fa-solid fa-cart-shopping" style="margin-right: 15px;"></i> Carrito</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="./Perfil.php" style="color: #2A2A2A; font-size: x-large;"><i class="fa-solid fa-address-card" style="margin-right: 15px;"></i> Perfil</a>
              </li>

              <?php
              if (!isset($_SESSION['user_Rol'])) {
                echo '<li class="nav-item">
                <a class="nav-link" href="./login.php" style="color: #2A2A2A; font-size: x-large;"><i class="fa-solid fa-user"style="margin-right: 15px;"></i>Login</a>
              </li>';
              }
              ?>

              <li class="nav-item">
                <a class="nav-link" href="./registro.php" style="color: #2A2A2A; font-size: x-large;"><i class="fa-solid fa-right-to-bracket" style="margin-right: 15px;"></i>Registro</a>
              </li>

              <?php
              if (isset($_SESSION['user_Rol']) && $_SESSION['user_Rol'] == 1) {
                echo '<li class="nav-item">
                <a class="nav-link" href="./Admin_Dashboard.php" style="color: #2A2A2A; font-size: x-large;"><i class="fa-solid fa-screwdriver-wrench"style="margin-right: 15px;"></i>Administrador</a>
              </li>';
              }

              if (isset($_SESSION['user_Rol'])) {
                echo '<li class="nav-item">
                    <button id="btnCerrarSesion" class="nav-link" style="color: #2A2A2A; font-size: x-large;">
                        <i class="fa-solid fa-right-from-bracket" style="margin-right: 15px;"></i>Cerrar Sesión
                    </button>
                </li>';
                
                //FIXME Arreglar esto, ya que el JS no esta cerrando sesion correctamente, quitar esta funcion si es necesario
                echo '<script>
                    $(document).ready(function() {
                        $("#btnCerrarSesion").on("click", function() {
                            $.ajax({
                                url: "../Controllers/LoginController.php",
                                type: "POST",
                                data: { op: "CerrarSesion", action: "CerrarSesion" },
                                success: function(response) {
                                    console.log(response);
                                    // Redireccionar después de cerrar la sesión
                                    window.location.href = "../Views/index.php";
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                                }
                            });
                        });
                    });
                </script>';
              }
            
            

              
              ?>
            </ul>

          </div>
        </div>


      </div>
    </div>
  </nav>

</header>