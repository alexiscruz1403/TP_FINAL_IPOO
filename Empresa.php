<?php

include_once 'BaseDatos.php';

class Empresa{
    //Atributos
    private $idEmpresa;
    private $nombre;
    private $direccion;
    private $mensaje;

    //Constructor
    public function __construct(){
        $this->idEmpresa="";
        $this->nombre="";
        $this->direccion="";
        $this->mensaje="";
    }
    public function cargar($unNombre,$unaDireccion){
        $this->nombre=$unNombre;
        $this->direccion=$unaDireccion;
    }

    //Observadores
    public function getIdEmpresa(){
        return $this->idEmpresa;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function __toString(){
        return "IdEmpresa: ".$this->getIdEmpresa()."\n".
        "Nombre: ".$this->getNombre()."\n".
        "Direccion: ".$this->getDireccion()."\n";
    }
    public function getMensaje(){
        return $this->mensaje;
    }

    //Modificadores
    public function setIdEmpresa($unIdEmpresa){
        $this->idEmpresa=$unIdEmpresa;
    }
    public function setNombre($unNombre){
        $this->nombre=$unNombre;
    }
    public function setDireccion($unaDireccion){
        $this->direccion=$unaDireccion;
    }
    public function setMensaje($unMensaje){
        $this->mensaje=$unMensaje;
    }

    //Propios

    /**
     * Busca el registro en la tabla empresa donde idEmpresa coincida con el valor enviado por parametro
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function buscar($idEmpresa){
        $base=new BaseDatos();
        $encontrado=false;
        if($base->iniciar()){
            $consulta="SELECT * FROM empresa WHERE idEmpresa=".$idEmpresa;
            if($base->ejecutar($consulta)){
                while($registro=$base->registro()){
                    $this->setIdEmpresa($registro['idEmpresa']);
                    $this->setNombre($registro['nombre']);
                    $this->setDireccion($registro['direccion']);
                    $encontrado=true;
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $encontrado;
    }

    /**
     * Agrega la instancia actual como un registro en la base de datos
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function insertar(){
        $base=new BaseDatos();
        $agregado=false;
        if($base->iniciar()){
            $consulta="INSERT INTO empresa(nombre,direccion) VALUES ('".$this->getNombre()."','".
            $this->getDireccion()."')";
            if($base->ejecutar($consulta)){
                $agregado=true;
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $agregado;
    }

    /**
     * Elimina el registro donde idEmpresa coincida con el valor actual de la instancia
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function eliminar(){
        $base=new BaseDatos();
        $eliminado=false;
        if($base->iniciar()){
            $consulta="DELETE FROM empresa WHERE idEmpresa=".$this->getIdEmpresa();
            if($base->ejecutar($consulta)){
                $eliminado=true;
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $eliminado;
    }

    /**
     * Modifica el registro donde idPasajero coincida con el valor actual de la instancia
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function modificar(){
        $modificado=false;
        $base=new BaseDatos();
        if($base->iniciar()){
            $consulta="UPDATE empresa SET nombre='".$this->getNombre().
            "',direccion='".$this->getDireccion().
            "' WHERE idEmpresa=".$this->getIdEmpresa();
            if($base->ejecutar($consulta)){
                $modificado=true;
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $modificado;
    }

    /**
     * Crea una coleccion con informacion de todas las empresas
     * Se puede mandar una condicion de manera opcional
     * Si no hay registros, devulve una coleccion vacia
     * @param string $condicion
     * @return array
     */
    public function listar($condicion=""){
        $colPasajeros=array();
        $base=new BaseDatos();
        if($base->iniciar()){
            $consulta="SELECT * FROM empresa";
            if($condicion!=""){
                $consulta.=" WHERE ".$condicion;
            }
            if($base->ejecutar($consulta)){
                while($registro=$base->registro()){
                    $unaEmpresa=new Empresa();
                    $unaEmpresa->buscar($registro['$idEmpresa']);
                    array_push($colPasajeros,$unaEmpresa);
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $colPasajeros;
    }
}