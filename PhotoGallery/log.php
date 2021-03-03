<?

$cfg = new MyConfig();
insertRow($cfg->db);
writeLogFile($cfg->queryUrl);

// Classes 
class MyDB extends SQLite3 {
   function __construct() {
      $this->open('test.db');
   }
}

class MyConfig {
	public $x = 223;
	public $queryUrl = "";
	public $db = 0;

	function __construct() {
		if (!empty($_SERVER)) {
			$this->queryUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
		}
		$this->db = initDB();
	}
	public function xyzzy() {
	}
}


// Functions

function writeLogFile($x) {
	// parse query args
	parse_str($x, $query);
	$response = $query;
	$response["log_time"] = $_SERVER["REQUEST_TIME"];
	$response["log_raddr"] = $_SERVER["REMOTE_ADDR"];
	$response["log_ua"] = $_SERVER["HTTP_USER_AGENT"];
	// json encode
	$json = (json_encode($response));
	// append to log file
	$logfile = "applog.txt";
	$size = filesize($logfile);
	if ($size < 1024*1024) {
		$fp = fopen($logfile, 'a');
		fwrite($fp, $json . "\n");
		fclose($fp);  
	}
	else {
		echo("NOTICE: log file overflow, size $size");
	}
}

// Database

function initDB() {
	$db = new MyDB();
	if(!$db) {
	   // echo $db->lastErrorMsg();
	}
	else {
		createTable($db);
		//$db->close();
	}
	return $db;
}
   
function createTable($db) {
   $sql =<<<EOF
      CREATE TABLE IF NOT EXISTS COMPANY
      (ID INT PRIMARY KEY     NOT NULL,
      NAME           TEXT    NOT NULL,
      AGE            INT     NOT NULL,
      ADDRESS        CHAR(50),
      SALARY         REAL);
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   }
}

function insertRow($db) {
   $sql =<<<EOF
      INSERT INTO COMPANY (ID,NAME,AGE,ADDRESS,SALARY)
      VALUES (1, 'Paul', 32, 'California', 20000.00 );

      INSERT INTO COMPANY (ID,NAME,AGE,ADDRESS,SALARY)
      VALUES (2, 'Allen', 25, 'Texas', 15000.00 );

      INSERT INTO COMPANY (ID,NAME,AGE,ADDRESS,SALARY)
      VALUES (3, 'Teddy', 23, 'Norway', 20000.00 );

      INSERT INTO COMPANY (ID,NAME,AGE,ADDRESS,SALARY)
      VALUES (4, 'Mark', 25, 'Rich-Mond ', 65000.00 );
EOF;

   $ret = $db->exec($sql);
   if(!$ret) {
      echo $db->lastErrorMsg();
   }
}

?>
