<?php 

class Responsable extends Persona{
    //Atributos
    private $numeroEmpleado;
    private $numeroLicencia;
    private $mensaje;

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->numeroEmpleado="";
        $this->numeroLicencia="";
        $this->mensaje="";
    }
    public function cargar($unNroDocumento,$unNombre,$unApellido,$unTelefono,$unNumeroLicencia=""){
        parent::cargar($unNroDocumento,$unNombre,$unApellido,$unTelefono);
        $this->numeroLicencia=$unNumeroLicencia;
    }

    //Observadores
    public function getNumeroEmpleado(){
        return $this->numeroEmpleado;
    }
    public function getNumeroLicencia(){
        return $this->numeroLicencia;
    }
    public function getMensaje(){
        return $this->mensaje;
    }
    public function __toString(){
        return "NumeroEmpleado: ".$this->getNumeroEmpleado()."\n".
        "NumeroLicencia: ".$this->getNumeroLicencia()."\n";
    }

    //Modificadores
    public function setNumeroEmpleado($unNumeroEmpleado){
        $this->numeroEmpleado=$unNumeroEmpleado;
    }
    public function setNumeroLicencia($unNumeroLicencia){
        $this->numeroLicencia=$unNumeroLicencia;
    }
    public function setMensaje($unMensaje){
        $this->mensaje=$unMensaje;
    }

    //Propios

    /**
     * Busca el registro en la tabla responsable donde numeroEmpleado coincida con el valor enviado por parametro
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function buscar($numeroEmpleado){
        $base=new BaseDatos();
        $encontrado=false;
        if($base->iniciar()){
            $consulta="SELECT * FROM responsable WHERE numeroEmpleado=".$numeroEmpleado;
            if($base->ejecutar($consulta)){
                while($registro=$base->registro()){
                    $this->setNroDocumento($registro['nroDocumento']);
                    $this->setNumeroEmpleado($registro['numeroEmpleado']);
                    $this->setNumeroLicencia($registro['numeroLicencia']);
                }
                if(parent::buscar($this->getNroDocumento())){
                    $encontrado=true;
                }else{
                    $this->setMensaje($base->getError());
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
            if(parent::insertar()){
                $consulta="INSERT INTO responsable(nroDoc,numeroLicencia) VALUES ('".$this->getNroDocumento()."',".
                $this->getNumeroLicencia().")";
                if($base->ejecutar($consulta)){
                    $agregado=true;
                }else{
                    $this->setMensaje($base->getError());
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $agregado;
    }

    /**
     * Elimina el registro donde numeroEmpleado coincida con el valor actual de la instancia
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function eliminar(){
        $base=new BaseDatos();
        $eliminado=false;
        if($base->iniciar()){
            $consulta="DELETE FROM responsable WHERE numeroEmpleado=".$this->getNumeroEmpleado();
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
     * Modifica el registro donde numeroEmpleado coincida con el valor actual de la instancia
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function modificar(){
        $modificado=false;
        $base=new BaseDatos();
        if($base->iniciar()){
            $consulta="UPDATE responsable SET numeroLicencia=".$this->getNumeroLicencia().
            ",nroDocumento='".$this->getNombre().
            "' WHERE numeroEmpleado=".$this->getNumeroEmpleado();
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
     * Crea una coleccion con informacion de todos los pasajeros
     * Se puede mandar una condicion de manera opcional
     * Si no hay registros, devuelve una coleccion vacia
     * @param string $condicion
     * @return array
     */
    public function listar($condicion=""){
        $colPasajeros=array();
        $base=new BaseDatos();
        if($base->iniciar()){
            $consulta="SELECT * FROM responsable";
            if($condicion!=""){
                $consulta.=" WHERE ".$condicion;
            }
            if($base->ejecutar($consulta)){
                while($registro=$base->registro()){
                    $numeroEmpleado=$registro['numeroEmpleado'];
                    $numeroLicencia=$registro['numeroLicencia'];
                    $nroDocumento=$registro['nroDocumento'];
                    $unResponsable=new Responsable;
                    $unResponsable->setNumeroEmpleado($numeroEmpleado);
                    array_push($colPasajeros,$unResponsable);
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