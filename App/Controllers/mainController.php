<?php 

namespace App\Controllers;

use \Core\Controller as Controller;
use \Core\ORM\Database as Database;
use \App\Models\Users as Users;

class mainController extends Controller
{
	static function index($id = "")
	{
		$response = new \stdClass();
		//print_r(Database::debug());
		//print_r(Database::query("SELECT * FROM Users"));
		//print_r(Users::get());
		$users = new Users;
		$arrParams = array(
			'name'=>'Brayan Colorado',
			'username'=>'brcolorado',
			'password'=>md5('123'),
		);
		$insert = $users->insert($arrParams);
		
		if (isset($insert['codigo']) && $insert['codigo']>0) {
			$response->type = "ERROR";
			$response->mensaje = isset($insert['error'])?$insert['error']:false;
			$response->data = null;
		}else{
			$response->type = "INFO";
			$response->mensaje = "Registro con exito.";
			$response->data = $insert['insert_id'];
		}

		return $response;
	}

	static function delete($id = '')
	{
		$response = new \stdClass;
		$user = new Users;
		$usuario = $user->getById($id);
		
		if ($usuario == false) {
			$response->type = "ERROR";
			$response->type = "No se encontró el usuario";
			$response->data = null;
			return $response;
		}

		$delete = $user->delete($usuario['id']);
		
		if (isset($delete['affected_rows']) && $delete['affected_rows'] >= 1) {
			$response->type = "INFO";
			$response->type = "Se eliminó el usuario correctamente.";
			$response->data = $delete['affected_rows'];
		} else {
			$response->type = "ERROR";
			$response->type = "No se pudo eliminar el usuario.";
			$response->data = null;
		}

		return $response;
	}

	static function update($id = '')
	{
		$user = new Users;

		$update = $user->update(array("id"=>$id,"name"=>"xxx","password"=>MD5("test")));


	}


}

?>