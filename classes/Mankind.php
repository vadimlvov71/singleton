<?php
namespace Classes;
use Classes\Person;
include_once "Person.php";
class Mankind {	
    private static $instance = null;
    public static $people = array();
    public static $sex = array();
    /**/ 
    private function __construct() {
    }
    private function __clone(){
    }
    private function __wakeup(){
    }
     /**/
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
            self::$instance->getFileData();
        }
        return self::$instance;
    }
    
    public static function getFileData()
    {
        if (($handle = fopen("people.csv", "r")) !== FALSE) {
            if (FALSE === $handle) {
                exit("Не удалось открыть поток по url адресу");
            }
            while (!feof($handle)) {
                $arrayFile = array(fgets($handle, 50));
                $arrayTemp = explode(";",  $arrayFile[0]);
                $key = array_shift($arrayTemp);
                $sex[] = $arrayTemp[2];
                $people[$key] = new Person($key, $arrayTemp[0], $arrayTemp[1], $arrayTemp[2], $arrayTemp[3]);
            }
            fclose($handle);
            self::$sex = $sex;
            self::$people = $people;
        }
    } 
    
    public static function getPeople(){
       return self::$people;
    }
    public static function getPerson($id){
        return self::$people[$id];
    }
    public static function getMenPercentage(){
        $man = 0;
        foreach (self::$sex as $sex){
            if($sex == "M"){
                $man++;
            }
        }
        $total = count(self::$sex);
        $result = self::getPercentage($total, $man);
        return $result;
    }
    public static function getPercentage($total, $number){
        if ( $total > 0 ) {
            return round(($number * 100) / $total, 2);
        } else {
            return 0;
        }
    }
    public static function getPersonAgeInDays($birth_date){
        
        $dateFormatted = str_replace('.', '-', $birth_date);
            $origin = new \DateTime($dateFormatted);
        try {
            $now = new \DateTime();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit(1);
        }
        $interval = $origin->diff($now);
        $dayNums = $interval->format('%a');
        
        return $dayNums;
        
    }
}
