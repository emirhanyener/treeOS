<?php
class Node{
    public $value;
    public $next;

    public function __construct($value){
        $this->next = null;
        $this->value = $value;
    }

    public function setValue($value){
        $this->value = $value;
    }
    public function getValue(){
        return $this->value;
    }

    public function setNext($next){
        $this->next = $next;
    }
    public function getNext(){
        return $this->next;
    }
}

class LinkedList{
    public $first;

    public function __construct(){
        $this->first = null;
    }

    public function add($value){
        $node = new Node($value);

        if($this->first == null){
            $this->first = $node;
        }
        else {
            $temp = $this->first;
            while($temp->getNext() != null){
                $temp = $temp->getNext();
            }
            $temp->setNext($node);
        }
    }
}
?>