<?php 
namespace Core\ORM;

use \Core\ORM\Database as Database;

class Model
{
	public $pk = 'id';

    public function __construct($id = '')
    {
    	/*
    	if ($id != '') {
    		$response = $this->getById($id);
    		return $response;
    	}*/
    }

    public function getById($id) {
    	$strQuery = "SELECT * FROM {$this->table} WHERE {$this->pk} = {$id};";
    	$user = Database::query($strQuery);
    	return $user;
    }

    public function get() {}
    public function getWhere($arrParams) {}
    public function save($arrParams) {}

    public function update($arrParams) {
        if (empty($arrParams) || $arrParams == "" || $arrParams <= 0 || $arrParams == NULL)
            return ['codigo'=>1, 'error'=>'No se enviaron datos a actualizar.'];

        if (!isset($arrParams['id'])) 
            return ['codigo'=>1, 'error'=>'No se envió el id.'];

        $id = $arrParams['id'];
        unset($arrParams['id']);

        $strQuery = "UPDATE {$this->table} SET ";
        $strSet = "";
        
        if (empty($arrParams))
            return ['codigo'=>1, 'error'=>'.'];


        foreach ($arrParams as $key => $value) {
            $strSet .= $key . " = '" . $value . "',";
        }

        $strSet = substr($strSet, 0, -1);
        $strQuery .= $strSet . " WHERE {$this->pk} = " . $id;

        $update = Database::query($strQuery);

        return $update;

    }

    public function delete($arrParams) {
    	if (empty($arrParams) || $arrParams == "" || $arrParams <= 0 || $arrParams == NULL)
    		return ['codigo'=>1, 'error'=>'No se enviaron datos a insertar.'];

        $strQuery = "DELETE FROM {$this->table} WHERE ";
        $strWhere = "";

        if (gettype($arrParams) == "string" || gettype($arrParams) == "integer") {
            $strWhere .= "{$this->pk} =  " . $arrParams . ";";
        } else if (gettype($arrParams) == "array" || gettype($arrParams) == "object") {
            foreach ($arrParams as $key => $value) {
                $strWhere .= $key . " =  " . $value . " AND ";
            }
            $strWhere = substr($strWhere, 0, -5) . ";";
        }

        $strQuery.=$strWhere;
        $delete = Database::query($strQuery);
        
    	return $delete;
    }

    public function insert($arrParams) {
    	if (empty($arrParams))
    		return ['codigo'=>1, 'error'=>'No se enviaron datos a insertar.'];

    	$strQuery = "INSERT INTO {$this->table} ";
    	$keys = array();
    	$values = array();

    	foreach ($arrParams as $key => $value) {
    		array_push($keys, $key);
    		array_push($values, $value);
    	}

    	$strQuery .= "(id,".implode($keys, ",").") VALUES (NULL,'".implode($values, "','")."');";
		$insert = Database::query($strQuery);

    	if (isset($insert['codigo']) && $insert['codigo'] > 0){
    		return ['codigo'=>$insert['codigo'], "error"=>$insert['error']];
    	}

    	return $insert;
    }

    public static function debug(){
        $class = __CLASS__;
        return [
            "Class" => __CLASS__,
            "Methods" => get_class_methods($class),
            "Default Vars" => get_class_vars($class),
            "Current Vars" => ""//$this
        ];
    }
}