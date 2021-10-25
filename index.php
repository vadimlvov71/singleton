<?php
ini_set('display_errors', 1);
use Classes\Person;
use Classes\Mankind;
use Classes\Template;
include_once "./classes/Mankind.php";
include_once "./classes/Template.php";
$mankind = Mankind::getInstance();
$people = Mankind::getPeople();
Template::html("start");
    foreach ($people as $key => $person){
            $row_i = 1;
            if(!isset($_GET["id"]) || (isset($_GET["id"]) && $key != $_GET["id"])){
                Template::div("start");
                    foreach ($person as $personItem){
                        if($row_i == 1){
                            echo "aaaaaa";
                            echo Template::items($personItem, "href");
                        }else{
                            echo "bbb";
                            echo Template::items($personItem, "str");
                        }
                    $row_i++;
                    }
                Template::div("end");
            }else{
                $id = (int)$_GET["id"];
                $person = Mankind::getPerson($id);
                Template::div("start_id");
                    foreach ($person as $personItem){   
                        echo Template::items($personItem, "id");
                    }
                    $birth_date = Mankind::$people[$id]->birth_date;
                    Template::div("start");
                        echo "age in days: ".Mankind::getPersonAgeInDays($birth_date);
                    Template::div("end");
                Template::div("end");
            }
    
    }
    echo Mankind::getMenPercentage();
    Template::items("percentage of Men:", "id");
    Template::items(Mankind::getMenPercentage(), "id");
    Template::items("%", "id");
Template::html("end");
?>
