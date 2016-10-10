
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

//echo "hla";
$test_data= $_GET["data"];
$ball = new GuessBall($test_data);
echo $ball->guess();

class GuessBall{
		
	private $data;	
		
	function __construct($data){
	
		$this->data=$data;
	
	}

	function guess(){

		$data = explode(" ",$this->data);
		//return json_encode($data);
		
				
		
		$servername = "localhost";
		$username = "root";
		$password = "hnhnhn";
		$dbname = "guessing";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$res=array();
		foreach($data as $d){
		
			$sql = "SELECT * FROM mono_guess where keyword='".$d."'";

			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
				$res[] =array("object" => $row["object"], "type" => $row["type"]);
			    }
			} else {

				
			    $res[] =array("object" => null, "type" => null);
			}

		}

//var_dump($res);die();
		
		foreach($res as &$r){
			if($r["type"]!=null){		
				if($r["type"]=="action"){
					$table = "actions";
					$key = array("action");
				}else{
					$table="objects";
					$key = array("kind", "val");
				}	
				$sql = "SELECT * FROM $table where id='".$r["object"]."'";	

		
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    // output data of each row
				    while($row = $result->fetch_assoc()) {
					foreach($key as $k){
					$r[$k] = $row[$k];
				    	}
				    }
				} else {
				    	$r["type"]="objects";
					$r["kind"]="unknow";
					$r["val"]=$d;
				}
			}else{
	
			}
		}

		$conn->close();
		return json_encode($res);
		

	}



}

?>

