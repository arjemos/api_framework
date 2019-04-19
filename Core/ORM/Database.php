<?php
    
    namespace Core\ORM;
    
    /**
    *	Clase con métodos relacionados con las operaciones en base de datos
    */
    class Database 
    {
        public static $intFilasAfectadas = 0;
        private static $servidor='dev';

        /**
        *   Método que retorna el número de filas afectadas
        *   @return 
        */
        static function setServidor($strServidor = 'dev')
        {
            return self::$servidor = $strServidor;
        }  

        /**
        *   Método que retorna servidor
        *   @return 
        */
        static function getServidor()
        {
            return self::$servidor;
        }        

        /**
        *   Método que retorna el número de filas afectadas
        *   @return 
        */
        static function getFilasAfectadas()
        {
            return self::$intFilasAfectadas;
        }

        /**
        *	Método que establece conexión con la base de datos
        *	@return $cnxConexion Conexión con la base de datos
        */
        static function cnxConectar()
        {
            try
            {
                $servidores['dev'] = array('host' => 'localhost', 'user' => 'administrador', 'clave' => 'zero', 'db' => 'api');

                $strServidor = $servidores[self::getServidor()]['host'];
                $strUsuario = $servidores[self::getServidor()]['user'];
                $strClave = $servidores[self::getServidor()]['clave'];
                $strBaseDatos = $servidores[self::getServidor()]['db'];

                //	Establecer conexión con la base de datos
                $cnxConexion = mysqli_connect($strServidor, $strUsuario, $strClave, $strBaseDatos);

                //	Fijar charset
                mysqli_set_charset($cnxConexion, "utf8");

                //	Validar errores en la conexión
                if (mysqli_connect_errno())
                    throw new \Exception(mysqli_connect_error());

                //	Retornar conexión
                return $cnxConexion;
            }
            catch (\Exception $e)
            {
                throw new \Exception($e->getMessage());
            }
        }

        /**
        *	Método que finaliza la conexión con la base de datos
        *	@param $cnxConexion Objeto de conexión
        */
        static function cnxDesconectar($cnxConexion)
        {
            try
            {
                mysqli_close($cnxConexion);
            }
            catch (\Exception $e)
            {
                throw new \Exception($e->getMessage());
            }
        }

        /**
        *   Método que ejecuta un query en la base de datos
        *   @param $cnxConexion Objeto de conexión
        */
        static function query($strQuery)
        {
            try 
            {
                $obCnx = self::cnxConectar();
                $rslConsulta = mysqli_query($obCnx, $strQuery);
                $arrFilas = array();

                if (is_object($rslConsulta))
                {
                    if ( mysqli_num_rows($rslConsulta) >= 2 ) {
                        while ($drFila = mysqli_fetch_assoc($rslConsulta))
                            $arrFilas[] = $drFila;
                    }
                } else if ($rslConsulta === TRUE)
                {
                    $arrFilas['insert_id'] = $obCnx->insert_id;
                    $arrFilas['affected_rows'] = $obCnx->affected_rows;
                }

                if ($obCnx->errno > 0) {
                    throw new \Exception('Error insertanto el registro.');
                }

                if ( empty($arrFilas) )
                    return mysqli_fetch_assoc($rslConsulta);
                self::cnxDesconectar($obCnx);
                return $arrFilas;

            } 
            catch (\Exception $e) 
            {
                if ($obCnx->errno == 1062) {
                    $response = ['codigo'=>1062, "error"=>"Entrada Duplicada"];
                } else {
                    $response = ['codigo'=>$obCnx->errno, "error"=>$obCnx->error];
                }
                self::cnxDesconectar($obCnx);
                return $response;
            }
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

?>
