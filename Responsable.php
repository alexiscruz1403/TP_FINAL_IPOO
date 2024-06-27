<?php 

class Responsable extends Persona{
    //Atributos
    private $numeroEmpleado;
    private $numeroLicencia;

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->numeroEmpleado="";
        $this->numeroLicencia="";
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
    public function __toString(){
        $cadena=parent::__toString();
        $cadena.="NumeroEmpleado: ".$this->getNumeroEmpleado()."\n".
        "NumeroLicencia: ".$this->getNumeroLicencia()."\n";
        return $cadena;
    }

    //Modificadores
    public function setNumeroEmpleado($unNumeroEmpleado){
        $this->numeroEmpleado=$unNumeroEmpleado;
    }
    public function setNumeroLicencia($unNumeroLicencia){
        $this->numeroLicencia=$unNumeroLicencia;
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
                if($registro=$base->registro()){
                    if(parent::buscar($registro['nroDocumento'])){
                        $this->setNumeroEmpleado($registro['numeroEmpleado']);
                        $this->setNumeroLicencia($registro['numeroLicencia']);
                        $encontrado=true;
                    }else{
                        $this->setMensaje($base->getError());
                    }
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
        $base = new BaseDatos();
        $agregado = false;
        if ($base->iniciar()) {
            if (parent::insertar()) {
                $consulta = "INSERT INTO responsable (nroDocumento, numeroLicencia) VALUES ('" . $this->getNroDocumento() . "', " . $this->getNumeroLicencia() . ")";
                if ($base->ejecutar($consulta)) {
                    $agregado = true;
                } else {
                    $this->setMensaje($base->getError());
                }
            } else {
                $this->setMensaje($base->getError());
            }
        } else {
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
                if(parent::eliminar()){
                    $eliminado=true; 
                }else{
                    $this->setMensaje($base->getError());
                }
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
            " WHERE numeroEmpleado=".$this->getNumeroEmpleado();
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
                    $unResponsable=new Responsable;
                    parent::buscar($registro['nroDocumento']);
                    $unResponsable->setNumeroLicencia($registro['numeroLicencia']);
                    $unResponsable->setNumeroEmpleado($registro['numeroEmpleado']);
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

// Metodo para buscar un responsable, por el nroDOcumento
    public function buscarPorDocumento($nroDocumento) {
        $base = new BaseDatos();
        $consulta = "SELECT * FROM responsable WHERE nroDocumento = '" . $nroDocumento . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row = $base->registro()) {
                    parent::buscar($nroDocumento);
                    $this->setNumeroEmpleado($row['numeroEmpleado']);
                    $this->setNumeroLicencia($row['numeroLicencia']);
                    $this->setNroDocumento($row['nroDocumento']);
                    return true;
                }
            } else {
                $this->setMensaje($base->getError());
            }
        } else {
            $this->setMensaje($base->getError());
        }
        return false;
    }

}


