<?php
	if (! function_exists('DB')) {
		function DB($sql,$parametros=[]){
			return response()->select($sql,$parametros);
		}
	}

	if (! function_exists('view')) {
		function view($view,$var_array = array()){
			return response()->view($view,$var_array);
		}
	}

	if (!function_exists('request')){
		function request(){
			require_once 'Request.php';
			return new Request();
		}
	}

	if(!function_exists('response')){
		function response(){
			require_once 'Response.php';
			return new Response();
		}
	}

	if(!function_exists('getSession')){
		function getSession($key){
			return (isset($_SESSION[$key]))?$_SESSION[$key]:NULL;
		}
	}

	if(!function_exists('json')){
		function json($val){
			return json_encode($val);
		}
	}

	if(!function_exists('flushSession')){
		function flushSession($key){
			(isset($_SESSION[$key]) && !empty($_SESSION[$key]))?$_SESSION[$key] = NULL:NULL;
		}
	}

	if(!function_exists('getWith')){
		function getWith($key=''){
			$with = (isset($_SESSION['with'][$key]))?$_SESSION['with'][$key]:NULL;
			flushSession('with');
			return $with;
		}
	}

	if(!function_exists('isWith')){
		function isWith($key){
			return (isset($_SESSION['with'][$key]))?$_SESSION['with'][$key]:NULL;
		}
	}

	if(!function_exists('jsonSave')){
		function jsonSave($path,$data){
			if(is_array($data)){
				if(file_exists($path)){
					$temp = jsonList($path);
					$add = [];
					if(is_null(json_decode($temp))){
						$add[] = $data;
					}else{
						$add = json_decode($temp);
						$add[] = $data;
					}
					if(file_put_contents($path, json_encode($add))){
						return true;
					}
				}else{
					// create file if not exits
				}
			}
			return false;
		}
	}
	
	if(!function_exists('jsonList')){
		function jsonList($path,$items=[]){
			if(file_exists($path)){
				if(!empty($items) & is_array($items)){
					$d = [];
					$jsonString = file_get_contents($path);
					if(empty($jsonString))
						return $d;
					$array = array_filter(json_decode($jsonString));
					foreach ($array as $k => $v) {
						$v = (array)$v;
						$respuesta = [];
						foreach (array_keys($v) as $k1 => $v1) {
							foreach ($items as $keyItems => $valueItems) {
								if($valueItems == $v1){
									$respuesta[$v1] = $v[$v1];
								}
							}
						}
						$d[] = $respuesta;
					}
					return $d;
				}else{
					return $jsonString = file_get_contents($path);
				}
			}
			return [];
		}
	}
	
	if(!function_exists('getFilter')){
		function getFilter(array $data, array $items=[], $paramsDB=false){
			$r = []; $d = [];
			foreach ($data as $k => $v) {
				foreach ($items as $key => $value) {
					if(is_array($v)){
						$r[$value] = $v[$value];
					}else{
						if($paramsDB){
							$d[$key] = $data[$value];
						}else{
							$d[$value] = $data[$value];
						}
					}
				}
				if(is_array($v)){
					$d[] = $r;
				}else{
					return $d;
				}
			}
			return $d;
		}
	}

	if(!function_exists('Version')){
		function Version(){
			echo "<span style='color:#2D8848'>============================================</span><br><span style='color:#992F1E;font-weight:bold'>&nbsp;&nbsp;MVC BASE IN PHP v. 1.0 | By. Ronny Matute Granizo</span><br><span style='color:#2D8848'>============================================</span><br>";
		}
	}
	if(!function_exists('error')){
		function error($a=array()){
			echo "<br><span style='color:#2D8848'>==================================================================</span><br><span style='color:#992F1E;font-weight:bold'>";
			switch($a[0]):
				case 'M':echo "Error, al parecer no existe el metodo [".$a[1]."] en el controlador [".$a[2]."Controller.php]";break;
				case 'C':echo "Error, al parecer no existe el controlador [".$a[1]."Controller.php] en el directorio [controllers]";break;
				case 'V':echo "Error, al parecer no existe la vista [".$a[1]."] en el directorio [views]";break;
			endswitch;
			echo "</span><br><span style='color:#2D8848'>==================================================================</span><br>";
		}
	}
?>