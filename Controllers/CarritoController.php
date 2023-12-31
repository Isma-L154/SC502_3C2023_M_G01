<?php   
session_start();  

require_once '../Models/Articulo.php';
require_once '../Models/Carrito.php';
require_once '../Models/Articulo_Pers.php';
require_once '../Models/Stickers.php';


switch ($_GET["op"]) {

    case 'AgregarCarrito':
       
            if (isset($_POST['id'])) {
                $idProductoEspecifico = $_POST['id'];
                $TallaSelec = isset($_POST['talla']) ? $_POST['talla'] : 'S';
                $CantidadSelec = isset($_POST['cantidad']) ? $_POST['cantidad'] : 1;
            
                $Carrito = new Carrito();
                $articulo = new Articulo();           
                $articulo_espec = $articulo ->MostrarArticulo_Especifico($idProductoEspecifico);
    
                if ($articulo_espec !== null && $articulo_espec !== false) {
                    
                    $precio = $articulo_espec['precio'];
                    $Total_Linea = $CantidadSelec * $precio;
    
                    $Carrito -> setidArticulo($idProductoEspecifico);
                    $Carrito -> setTalla($TallaSelec);
                    $Carrito -> setCantidad($CantidadSelec);
                    $Carrito -> setTotal_Linea($Total_Linea);
                    $Carrito -> guardarEnCarritoDB();
                    
                    echo 1; //Se ingreso
                }else {
                    echo 2; //No se ingreso
                }
            }else{
                echo 2;

            }
            break;

        case 'AgregarCarritoPers':
       
                if (isset($_POST['id'])) {
                    $idProductoEspecifico = $_POST['id'];
                    $TallaSelec = isset($_POST['talla']) ? $_POST['talla'] : 'S';
                    $CantidadSelec = isset($_POST['cantidad']) ? $_POST['cantidad'] : 1;
                
                    $Carrito = new Carrito();
                    $articulo_pers = new Articulo_Pers();           
                    $articulo_espec = $articulo_pers ->MostrarArticulo_Especifico($idProductoEspecifico);
        
                    if ($articulo_espec !== null && $articulo_espec !== false) {
                        
                        $precio = $articulo_espec['precio'];
                        $Total_Linea = $CantidadSelec * $precio;
        
                        $Carrito -> setidArtPersonalizado($idProductoEspecifico);
                        $Carrito -> setTalla($TallaSelec);
                        $Carrito -> setCantidad($CantidadSelec);
                        $Carrito -> setTotal_Linea($Total_Linea);
                        $Carrito -> guardarEnCarritoDB();
                        
                        echo 1; //Se ingreso
                    }else {
                        echo 2; //No se ingreso
                    }
                }else{
                    echo 2;
    
                }             
        break;

        case 'AgregarCarritoSticker':
            
            if (isset($_POST['idSticker'])) {
                $idSticker = $_POST['idSticker'];
                $TamanioSelec = isset($_POST['Tamanio']) ? $_POST['Tamanio'] : '4x4';
                $CantidadSelec = isset($_POST['Cantidad']) ? $_POST['Cantidad'] : 10;
                $Precio = isset($_POST['Precio']) ? $_POST['Precio'] : 5000;

                $Carrito = new Carrito();
                $Sticker = new Stickers();           
                $Sticker_espec = $Sticker ->MostrarSticker_Especifico($idSticker);
                
                
                if ($Sticker_espec !== null && $Sticker_espec !== false) {
                    $Total_Linea = $Precio;
                    $Carrito -> setidSticker($idSticker);
                    $Carrito -> setCantidad($CantidadSelec);
                    $Carrito -> setTotal_Linea($Total_Linea);
                    $Carrito -> guardarEnCarritoDB();
                    
                    echo 1; //Se ingreso
                }else {
                    echo 2; //No se ingreso
                }
            }else{
                echo 2;

            } 
            break;
       
        case 'ListarCarrito':
            $Articulo = new Articulo();
            $Pers = new Articulo_Pers();
            $Sticker = new Stickers();
            $Cart = new Carrito();
            $Carr_Art = $Cart->listarTodosCarrito();
            $datos = array();
            
            foreach ($Carr_Art as $reg) {
                
            $art = $Articulo->MostrarArticulo_Especifico($reg->getidArticulo());
            $art_pers = $Pers->MostrarArticulo_Especifico($reg->getidArtPersonalizado());
            $Sticker_prs = $Sticker->MostrarSticker_Especifico($reg->getidSticker());
                


            if (is_array($art) && array_key_exists('idTipoProducto', $art) && $art['idTipoProducto'] !== null && $art['idTipoProducto'] === 1) {
        
                    echo '
                    <div class="row mb-4 d-flex justify-content-between align-items-center" style="flex-wrap: nowrap;">
                        <div class="col-md-2 col-lg-2 col-xl-2">
                            <img src="' . $art['ruta_imagen'] . '" alt="Product" class="img-responsive" width="85px" height="85px" />
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-2">
                            <h6 class="text-muted">' . $art['nombre'] . '</h6>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2">
                            <h6 class="text-muted ">' . $reg->getTalla() . '</h6>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2">
                            <h6 class="text-muted">' . $art['precio'] . '₡</h6>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2">
                            <h6 class="text-muted">' . $reg->getCantidad() . '</h6>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2">
                            <h6 class="text-muted">' . $reg->getTotal_Linea() . '₡</h6>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-2 ">
                        <button class="btn btn-md eliminar-linea" data-id="' . $reg->getIdLinea() . '"><i class="fas fa-times"></i></button>
                        </div>
                       
                        </div>';
                    
                } 
                elseif (is_array($art_pers) && array_key_exists('idTipoProducto', $art_pers) && $art_pers['idTipoProducto'] !== null && $art_pers['idTipoProducto'] === 2) {
        
                    echo '
                    <div class="row mb-4 d-flex justify-content-between align-items-center" style="flex-wrap: nowrap;">
                        <div class="col-md-2 col-lg-2 col-xl-2">
                            <img src="' . $art_pers['ruta_imagen'] . '" alt="Product" class="img-responsive" width="85px" height="85px" />
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-2">
                            <h6 class="text-muted">' . $art_pers['nombre'] . '</h6>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2">
                            <h6 class="text-muted ">' . $reg->getTalla() . '</h6>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2">
                            <h6 class="text-muted">' . $art_pers['precio'] . '₡</h6>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2">
                            <h6 class="text-muted">' . $reg->getCantidad() . '</h6>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2">
                            <h6 class="text-muted">' . $reg->getTotal_Linea() . '₡</h6>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-2 ">
                        <button class="btn  btn-md eliminar-linea" data-id="' . $reg->getidLinea(). '"><i class="fas fa-times"></i></button>
                        </div>
                        
                        
                        </div>';
                    
                }
                elseif (is_array($Sticker_prs) && array_key_exists('idTipoProducto', $Sticker_prs) && $Sticker_prs['idTipoProducto'] !== null && $Sticker_prs['idTipoProducto'] === 3) {
        
                    echo '
                    <div class="row mb-4 d-flex justify-content-between align-items-center" style="flex-wrap: nowrap;">
                        <div class="col-md-2 col-lg-2 col-xl-2">
                            <img src="' . $Sticker_prs['RutaLogo'] . '" alt="Product" class="img-responsive" width="80px" height="80px" />
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-2">
                            <h6 class="text-muted">Sticker</h6>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2">
                            <h6 class="text-muted ">' . $Sticker_prs['Tamanio']  . '</h6>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2">
                            <h6 class="text-muted"> 500₡</h6>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2">
                            <h6 class="text-muted">' . $reg->getCantidad() . '</h6>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2">
                            <h6 class="text-muted">' . $reg->getTotal_Linea() . '₡</h6>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-2 ">
                        <button class="btn  btn-md eliminar-linea" data-id="' . $reg->getidLinea(). '"><i class="fas fa-times"></i></button>
                        </div>
                        
                        
                        </div>';
                    
                }
                
            }
            break;
        
        
            case 'ListarResumen':
                $Cart = new Carrito();
                $Carr_Art = $Cart->listarTodosCarrito();
                $Cant_Total = 0;
                $Cant_Items = 0;
            
                foreach($Carr_Art as $reg){
                    $Cant_Items += $reg->getCantidad();
                    $Cant_Total += $reg->getTotal_Linea();
                }   
            
                if ($Cant_Total == 0) {
                    // Si el total es 0 y existe la variable de sesión, la elimina
                    if (isset($_SESSION['Cant_Product'])) {
                        unset($_SESSION['Cant_Product']);
                    }
                } else {
                    // Si el total es mayor que 0, crea o actualiza la variable de sesión
                    $_SESSION['Cant_Product'] = $Cant_Items;
                }
            
                echo '<div class="d-flex justify-content-between mb-4">
                    <h5 class="text-uppercase">Items</h5>
                    <span style="font-size: 24px;">'.$Cant_Items.'</span>
                </div>
            
                <hr class="my-4">
            
                <div class="d-flex justify-content-between mb-5">
                    <h5 class="text-uppercase">Total</h5>
                    <span style="font-size: 24px;">'.$Cant_Total.'₡</span>          
                </div>';
                
                break;
            
        


            case 'EliminarLinea':
                $ul = new Carrito();
                $ul->setidLinea(trim($_POST['idLinea']));
                $rspta = $ul->EliminarLinea();
                if($rspta) {
                    echo 1; // Éxito para eliminar 
                } else {
                    echo 0; // Error para eliminar toda la linea
                }
                break;
            
            case 'EliminarCarrito':
                $Carrito = new Carrito();
                $rspa = $Carrito -> EliminarCarrito();
                if($rspta) {
                    echo 1; // Éxito para eliminar 
                } else {
                    echo 0; // Error para eliminar toda la info
                }
                if(isset($_SESSION['Cant_Product'])) {
                    unset($_SESSION['Cant_Product']);
                }
                break;
        }



?>