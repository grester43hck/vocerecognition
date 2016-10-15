
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once ("DB.php");

//echo "hla";
$test_data= $_GET["data"];
$ball = new GuessBall($test_data);
echo $ball->guess();

class GuessBall{
		
	private $data;	
	private $db;

	function __construct($data){
	
		$this->data=$data;
		$this->db = new DB("localhost", "root", "root", "guessing");
	
	}

	function guess(){

		$data = self::monoguess();
		foreach($data["action"] as &$d){
			$d = self::getAction(intval($d["object"]));
		}
		return json_encode($data);

	}

	private function monoguess(){
		$res = array("action"=>array(), "objects"=>array());
		foreach(explode(" ",$this->data) as $d){

			$sql = "SELECT object, type, action, count() as rel FROM mono_guess where keyword='$d' group by object, type, action";

			$result = $this->db->select($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					$res[$row["type"]][] =array("object" => $row["object"], "value"=>$d);
				}
			} else {
				$res["objects"][] = array("object" => null, "value"=>$d);
			}

		}

		return $res;
	}

	private function getAction($object_id){
		$sql = "SELECT * FROM actions where id='$object_id'";

		$result = $this->db->select($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				return array("object" => $object_id, "action"=>$row["action"]);
			}
		}

		return false;
	}



}

?>

