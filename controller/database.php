<?php 

class database {
    
    function connect() {
        
        if (isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"] == "www.owncatch.de") {    
            $hostname="db457523083.db.1and1.com";
            $database="db457523083";
            $username="dbo457523083";
            $password="kevinriggs";
            
        } else {
            $hostname="localhost";
            $database="thegame";
            $username="root";
            $password="kevinriggs";
        }

        $link = mysql_connect($hostname, $username, $password);
        
        if (!$link) return false;

        if (!$db_selected = mysql_select_db($database, $link)) {
            return false;
        }


        if (!mysql_select_db($database)) {
            return false;
        }

        return true;
    }
    
    
 
    public function getResults($tbl, $column = "*", $where = "") {
       
        $ergebnis = mysql_query("SELECT " . $column . " FROM " . $tbl . $where);
        $users    = array();

        $i = 0;

        while($row = mysql_fetch_object($ergebnis)) {
            $users[$i]['id']  = $row->id;
            $users[$i]['user']  = $row->user;
            $users[$i]['password']  = $row->password;

            $i++;
        }

        return $users;
    }
    
    
    public function getUserData($userId) {

       $query = "Select u.user as user_name, 
                        p.name as planet_name, p.position as planet_position 
                 
                  FROM users u INNER JOIN planets p ON p.ownstatus = u.id 
                                       INNER JOIN userstatus us ON us.id = u.status
                                       LEFT JOIN planet_building bui ON bui.planet = p.id
                                       
                           WHERE u.id = {$userId}
                              AND us.descr = 'active'";
                           
       $result = mysql_query($query) or die("Anfrage fehlgeschlagen: " . mysql_error());
       
       $user = array();
       
       while ($row = mysql_fetch_array($result)) {
          
          $user["name"] = $row["user_name"];
          $user["planet_name"] = $row["planet_name"];
          $user["planet_position"] = $row["planet_position"];
       }
       
       return $user;
    }
}