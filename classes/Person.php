<?php
namespace Classes;
class Person {
    public $id;
    public $name;
    public $surname;
    public $sex;
    public $birth_date;
    public function __construct($id, $name, $surname, $sex, $birth_date) {
       $this->id = $id;
       $this->name = $name;
       $this->surname = $surname;
       $this->sex = $sex;
       $this->birth_date = $birth_date;
    }
}