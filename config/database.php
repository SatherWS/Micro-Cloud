<?php
    class Database {
        private $server = "localhost";
        //private $db = "note_web";
        private $db = "lhapps";
        private $user = "root";
        private $pass = "mysql";
        //private $pass = "root";
    
        public function getConnection(){
            $curs = new mysqli($this->server, $this->user, $this->pass, $this->db);
            if ($curs->connect_error) {
                die("Connection failed: " . $curs->connect_error);
            }
            return $curs;
        }
    }
?>