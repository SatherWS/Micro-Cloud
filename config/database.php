<?php

    class Database {
        private $hostname = "localhost";
        private $user = "root";
        //private $database = "swoop_team";
        //private $password = "1m0r3_projde@th";
        private $database = "lhapps";
        private $password = "mysql";
        
        public function getConnection(){
            $curs = new mysqli($this->hostname, $this->user, $this->password, $this->database);

            if ($curs->connect_error) {
                die("Connection failed: " . $curs->connect_error);
            }
            return $curs;
        }
    }
?>
