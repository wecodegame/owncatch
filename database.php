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
    
    
    function update() {

    }
    
    
    
    
    
    function getResults($tbl, $column = "", $where = "") {
       
        $ergebnis = mysql_query("SELECT * FROM " . $tbl);
        $users    = array();

        $i = 0;

        while($row = mysql_fetch_object($ergebnis)) {
            $users[$i][]  = $row->user;
            $users[$i][]  = $row->password;

            $i++;
        }

        return $users;
    }
}




?>