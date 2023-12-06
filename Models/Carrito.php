<?php 
require_once '../Config/Conexion.php';
final class Carrito extends Conexion{

    protected static $cnx;
    private $idLinea = null;
    private $Cantidad = null;
    private $Talla = null;
    private $Total_Linea = null;
    private $idArticulo = null;

public function __construct() {}


public function getidLinea()
    {
        return $this->idLinea;
    }
    public function setidLinea($idLinea)
    {
        $this->idLinea = $idLinea;
    }

    public function getCantidad()
    {
        return $this->Cantidad;
    }
    public function setCantidad($Cantidad)
    {
        $this->Cantidad = $Cantidad;
    }

    public function getTalla()
    {
        return $this->Talla;
    }
    public function setTalla($Talla)
    {
        $this->Talla = $Talla;
    }

    public function getTotal_Linea()
    {
        return $this->Total_Linea;
    }
    public function setTotal_Linea($Total_Linea)
    {
        $this->Total_Linea = $Total_Linea;
    }

    public function getidArticulo()
    {
        return $this->idArticulo;
    }
    public function setidArticulo($idArticulo)
    {
        $this->idArticulo = $idArticulo;
    }


    public static function getConexion()
    {
        self::$cnx = Conexion::conectar();
    }

    public static function desconectar()
    {
        self::$cnx = null;
    }


    public function guardarEnCarritoDB(){
        $query = "INSERT INTO Carrito (idArticulo, Cantidad, Talla, Total_Linea) 
        VALUES (:idArticulo,:Cantidad,:Talla,:Total_Linea)";
     try {
         self::getConexion();
         $idArticulo=$this->getidArticulo();
         $Cantidad=$this->getCantidad();
         $Talla=$this->getTalla();
         $Total_Linea=$this->getTotal_Linea();
         
         $resultado = self::$cnx->prepare($query);
        $resultado->bindParam(":idArticulo",$idArticulo,PDO::PARAM_INT);
        $resultado->bindParam(":Cantidad",$Cantidad,PDO::PARAM_INT);
        $resultado->bindParam(":Talla",$Talla,PDO::PARAM_STR);
        $resultado->bindParam(":Total_Linea",$Total_Linea,PDO::PARAM_INT);
            $resultado->execute();
            self::desconectar();
           } catch (PDOException $Exception) {
               self::desconectar();
               $error = "Error ".$Exception->getCode( ).": ".$Exception->getMessage( );;
             return json_encode($error);
           }
    }
    public function listarTodosCarrito(){
        $query = "SELECT * FROM Carrito";
        //Almacenar los articulos
        $arr = array();
        try {
            self::getConexion();
            $resultado = self::$cnx->prepare($query);
            $resultado->execute();
            self::desconectar();
            foreach ($resultado->fetchAll() as $encontrado) {
                $cart = new Carrito();
                $cart->setidLinea($encontrado['idLinea']);
                $cart->setidArticulo($encontrado['idArticulo']);
                $cart->setCantidad($encontrado['Cantidad']);
                $cart->setTalla($encontrado['Talla']);
                $cart->setTotal_Linea($encontrado['Total_Linea']);
                //Almacenamos todos los datos de la tabla dentro del Array
                $arr[] = $cart;
            }
            return $arr;

        } catch (PDOException $Exception) {
            self::desconectar();
            $error = "Error ".$Exception->getCode( ).": ".$Exception->getMessage( );;
            return json_encode($error);
        }
    }




}


?>