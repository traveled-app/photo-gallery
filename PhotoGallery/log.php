<?

// Main program

$cfg = new MyConfig();
insertRow($cfg);
writeLogFile($cfg);
$cfg->db->close();

// Classes 

class MyConfig {
	public $queryUrl = "";
	public $queryDict = "";
	public $db = 0;
	public $logfile = "dt/lg/applog.txt";

	function __construct() {
		if (!empty($_SERVER)) {
			$this->queryUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
			parse_str($this->queryUrl, $this->queryDict);
		}
		$this->db = initDB("test.db");
	}
}

// Functions

function writeLogFile($cfg) {
	$queryDict = $cfg->queryDict;
	$queryDict["log_time"] = $_SERVER["REQUEST_TIME"];
	$queryDict["log_raddr"] = $_SERVER["REMOTE_ADDR"];
	$queryDict["log_ua"] = $_SERVER["HTTP_USER_AGENT"];
	// json encode
	$json = (json_encode($queryDict));
	// append to log file
	$logfile = $cfg->logfile; //"applog.txt";
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

class MyDB extends SQLite3 {
   function __construct($dbName) {
      //$this->open('test.db');
      $this->open($dbName);
   }
}

function initDB($dbName) {
	$db = new MyDB($dbName);
	if(!$db) {
	   // echo $db->lastErrorMsg();
	}
	else {
		createTable($db);
	}
	return $db;
}
   
function createTable($db) {
   $sql =<<<EOF
      CREATE TABLE IF NOT EXISTS CLIENTLOG
      (AL           TEXT    NOT NULL,
      I            INT     NOT NULL);
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   }
}

function insertRow($cfg) {
	$queryDict = $cfg->queryDict;
	$al = $queryDict['al'];
	$i = $queryDict['i'];

   $sql =<<<EOF
      INSERT INTO CLIENTLOG (AL,I)
      VALUES ("$al", $i);
EOF;
   $ret = $cfg->db->exec($sql);
   if(!$ret) {
      echo $cfg->db->lastErrorMsg();
   }
}

/*
function selectRows($db) {
   $sql =<<<EOF
      SELECT * from CLIENTLOG;
EOF;

   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
      echo "AL = ". $row['AL'] . "\n";
      echo "I = ". $row['I'] ."\n";
		echo '<br/>';
   }
   echo "Operation done successfully\n";
}
*/

?>
