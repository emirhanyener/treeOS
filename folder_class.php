<?php
    class Folder {
        public $name;
        public $position_x;
        public $position_y;
        public $files;

        function __construct($name,$position_x,$position_y){
            $this->name = $name;
            $this->position_x = $position_x;
            $this->position_y = $position_y;
        }

        function get_name(){
            return $this->name;
        }
        function get_position_x(){
            return $this->position_x;
        }
        function get_position_y(){
            return $this->position_y;
        }
    }
?>