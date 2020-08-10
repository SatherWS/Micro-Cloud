<?php
    class Database {
        // TODO: Use system variables instead
        private $server = "localhost";
        private $db = "lhapps";
        private $user = "root";
        private $pass = "mysql";
        
        // use when working on personal computer
        //private $pass = "root";
        //private $db = "note_web";
        
        public function getConnection(){
            $curs = new mysqli($this->server, $this->user, $this->pass, $this->db);
            if ($curs->connect_error) {
                die("Connection failed: " . $curs->connect_error);
            }
            return $curs;
        }
    }
?>