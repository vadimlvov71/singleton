<div class='form center'>
<?php
$mankind = Mankind::getInstance();

$people = Mankind::getPeople();
/*
echo "_______<pre>";                  
print_r($people);
echo "</pre>";
*/
/*
if(isset($_GET["id"])){
    $id = (int)$_GET["id"];
    $person = Mankind::getPerson($id);
    echo Template::div("start_id");
    foreach ($person as $personItem){   
        echo Template::items($personItem, "id");
    }
    $birth_date = Mankind::$people[$id]->birth_date;
    echo Mankind::getPersonAgeInDays($birth_date);
    Template::div("end");
}
*/
foreach ($people as $key => $person){
    
        $row_i = 1;
        if(!isset($_GET["id"]) || (isset($_GET["id"]) && $key != $_GET["id"])){
            Template::div("start");
                foreach ($person as $personItem){
                    if($row_i == 1){
                        echo Template::items($personItem, "href");
                    }else{
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
Template::items("percentage of Men:", "id");
Template::items(Mankind::getMenPercentage(), "id");
Template::items("%", "id");
/*echo "_______<pre>";
                    
                    print_r($mankind->getPerson(123));
                    echo "</pre>";*/
//echo "getPerson:".$mankind->getPerson(123);
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
           /*
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                for ($c=0; $c < $num; $c++) {
                    $arrayTemp = explode(";", $data[$c]);
                    $key = array_shift($arrayTemp);
                    $sex[] = $arrayTemp[2];
                    $people[$key] = new Person($key, $arrayTemp[0], $arrayTemp[1], $arrayTemp[2], $arrayTemp[3]);
                }   
            }
            */
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
            fclose($handle);
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
        $origin = new DateTime($dateFormatted);
        $now = new DateTime();
        $interval = $origin->diff($now);
        $dayNums = $interval->format('%a');
        return $dayNums;
    }
}
class Template{	
    public static function items($item, $type){
        if($type == "href"){
            echo "<a href='index.php?id=".$item."'>".$item."</a>";
        }else if($type == "id"){
            echo "<span >".$item."</span> ";
        }else{
            echo "<span>".$item."</span> ";
        }
    }
    public static function div($type){
        if($type == "start"){
            $result = "<div class='start'>";
        }else if($type == "start_id"){
            $result = "<div class='start_id'>";

        }else{
            $result = "</div>";
        }
        echo $result;
    }
   
}

?>
</div>
<style>
    .start{
        background: #fff;
        border-bottom: 1px solid #ccc;
        padding:5px 11px;
    }
    .start_id{
        background: #ecdaca;
        padding:5px 11px;
    }
    .center{
        margin-left:auto;
        margin-right:auto;
    }
    .form{
        border: 1px solid #ccc;
        border-radius: 6px;
        padding:4px 10px;
        text-align: left;
        width: 400px;
    }
</style>