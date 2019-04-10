<?php
ini_set('display_errors', 1);

class Database{
    
    private $DB_SERVER;
    private $DB_USERNAME;
    private $DB_PASSWORD;
    private $DB_NAME;
    public $conn;

    public function __construct() {
        $this->db_connect();
    }

    private function db_connect() {
        $this->DB_SERVER = 'shareddb-i.hosting.stackcp.net';
        $this->DB_USERNAME = 'the-first-of-many-33357f3c';
        $this->DB_PASSWORD = '@lien$$$';
        $this->DB_NAME = 'the-first-of-many-33357f3c';
        
        $this->conn = new mysqli($this->DB_SERVER, $this->DB_USERNAME, $this->DB_PASSWORD, $this->DB_NAME);
        
        if($this->conn === false) {
            return 1;
        } else {
            return $this->conn;
        }
    }
    
    public function selectQuery($query) {
        $return = "";
        $result = $this->conn->query($query);
        while ($row = $result->fetch_assoc()) {
            $return[] = $row;
        }
        return $return;
    }
    
    public function createPlayer($values) {
        $accountBalance = 99.00;
        $query = "INSERT INTO Player (`player_name`,`password`,`gender`,`first_name`,`last_name`,`city`,`state`,`country`,`occupation`,`account_balance`) VALUES (?,?,?,?,?,?,?,?,?,$accountBalance)";
        $stmt = $this->conn->stmt_init();
        if ($stmt->prepare($query)) {
            $stmt->bind_param('sssssssss',$values['player_name'],$values['password'],$values['gender'],$values['first_name'],$values['last_name'],$values['city'],$values['state'],$values['country'],$values['occupation']);
            $stmt->execute();
            if ($this->conn->affected_rows === 1) {
                return 1;
            } else {
                printf("Error message, %s\n", $this->conn->error);
            }
        }
        
    }
    
    public function checkUserName($playerName)  {
        $query = "SELECT * FROM Player WHERE `player_name` = '".$playerName."'";
        $stmt = $this->conn->stmt_init();
        $stmt->prepare($query);
        $stmt->execute();
        $stmt->store_result();
        $cnt = $stmt->num_rows;
            if ($cnt > 0) {
                return 1;
            } else {
                return 0;
            }
    }
    
    public function increaseAccountBalance($playerName, $money) {
        $update = "UPDATE `Player` SET `account_balance` = ? WHERE `player_name` = '".$playerName."'";
        $stmt = $this->conn->stmt_init();
        $stmt->prepare($update);
        $balance = $money +  $this->getBalance($playerName);
        $stmt->bind_param('i',$balance);
        $stmt->execute();
        if ($stmt->affected_rows == 1) {
            return 1;
        } else {
            return 0;
        }
    }
    
    private function getBalance($playerName) {
        $balance = 0;
        $query = "SELECT account_balance FROM Player WHERE player_name = '".$playerName."'";
        $result = $this->conn->query($query);
        while ($row = $result->fetch_array()) {
            $balance = $row[0];
        }
        return $balance;
    }
    
    

}




$playerData = ['player_name' => "Lucina", 
               'password' => password_hash('MarthSucks', PASSWORD_BCRYPT),
               'gender' => "F",
               'first_name' => "Lucina",
               'last_name' => "",
               'city' => "Cherry Hill",
               'state' => "NJ",
               'country' => "USA",
               'occupation' => "Sword Fighter"
              ];

$db = new Database();

if($db->checkUserName($playerData['player_name']) === 0) {
    echo $db->createPlayer($playerData);
} else {
    echo $playerData['player_name']." already exists";
}

$players = $db->selectQuery("SELECT * FROM Player");
foreach ($players as $player) {
    echo $player['player_name']."\n";
}

$db->increaseAccountBalance("Lucina", 45);





?>