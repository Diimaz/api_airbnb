<?php
namespace App\Models;

use CodeIgniter\Model;

class AnfitrionesModel extends Model{
    protected $table      = 'tbl_anfitriones';
    protected $primaryKey = 'idAnfitrion';

    protected $returnType     = 'object';
    protected $allowedFields = ['descripcion','puntuacion','cuentaBanco','banco','totalPuntuacion','idUsuario','idIdiomaAnfitrion'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';

    /*Variables para antes de insertar en la tabla*/
    //protected $beforeInsert = ['agregarUsuario','addPuntaje','addTotalPuntaje','addIdiomaPrimario','addIdiomaSecundario','addIdiomaExtra'];

    protected $agregarUnUsuario;
    protected $addPuntajeInicial;
    protected $asignarIdiomaPrimario;
    protected $asignarIdiomaSecundario;
    protected $asignarIdiomaExtra;

/*--Funcion para agregar en la tabla anfitriones un idUsuario---------------------------------------------*/
    protected function agregarUsuario($data){
        $data['data']['idUsuario'] = $this->agregarUnUsuario;
        return $data;
    }
/*-------------------------------------------------------------------------------------------------------*/

/*--Funcion para buscar el usuario correspondiente al de anfitrion---------------------------------------*/
    public function agregarElUsuario(string $email){
        $row = $this->db()->table('tbl_usuarios')->where('email',$email)->get()->getFirstRow();
        if($row !== null){
            $this->agregarUnUsuario = $row->idUsuario;
        }
    }

/*--Funcion para agregar puntaje inicial-----------------------------------------------------------------*/
    public function addPuntaje($data){
        $data['data']['puntuacion'] = 0;
        return $data;
    }
/*-------------------------------------------------------------------------------------------------------*/

/*--Funcion para agregar puntaje total inicial-----------------------------------------------------------*/
    public function addTotalPuntaje($data){
        $data['data']['totalPuntuacion'] = 0;
        return $data;
    }
/*-------------------------------------------------------------------------------------------------------*/

/*--Funcion para agregar idioma primario-----------------------------------------------------------------*/
    protected function addIdiomaPrimario($data){
        $data['data']['idiomaPrimario'] = $this->asignarIdiomaPrimario;
        return $data;
    }
/*-------------------------------------------------------------------------------------------------------*/

/*--Funcion para buscar el idioma correspondiente al de anfitrion----------------------------------------*/
    public function agregarIdiomaPrimario(string $idioma){
        $row = $this->db()->table('tbl_idiomas')->where('idioma',$idioma)->get()->getFirstRow();
        if($row !== null){
            $this->asignarIdiomaPrimario = $row->idIdioma;
        }
    }
/*-------------------------------------------------------------------------------------------------------*/

/*--Funcion para agregar idioma Secundario----------------------------------------------------------------*/
    protected function addIdiomaSecundario($data){
        $data['data']['idiomaSecundario'] = $this->asignarIdiomaSecundario;
        return $data;
    }
/*-------------------------------------------------------------------------------------------------------*/

/*--Funcion para buscar el idioma correspondiente al de anfitrion----------------------------------------*/
    public function agregarIdiomaSecundario(string $idioma){
        $row = $this->db()->table('tbl_idiomas')->where('idioma',$idioma)->get()->getFirstRow();
        if($row !== null){
            $this->asignarIdiomaSecundario = $row->idIdioma;
        }
    }
/*-------------------------------------------------------------------------------------------------------*/

/*--Funcion para agregar idioma Extra--------------------------------------------------------------------*/
    protected function addIdiomaExtra($data){
        $data['data']['idiomaExtra'] = $this->asignarIdiomaExtra;
        return $data;
    }
/*-------------------------------------------------------------------------------------------------------*/

/*--Funcion para buscar el idioma correspondiente al de anfitrion----------------------------------------*/
    public function agregarIdiomaExtra(string $idioma){
        $row = $this->db()->table('tbl_idiomas')->where('idioma',$idioma)->get()->getFirstRow();
        if($row !== null){
            $this->asignarIdiomaExtra = $row->idIdioma;
        }
    }
/*-------------------------------------------------------------------------------------------------------*/

    public function anfitrion($id){
        $anfitrion = $this->asArray()->where(['idAnfitrion' => $id]);

        if (!$anfitrion) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $anfitrion;
    }
    
}