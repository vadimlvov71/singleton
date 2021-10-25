<?php
namespace Classes;
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
    public static function HTML($type){
        if($type == "start"){
            ?>
            <!DOCTYPE html>
            <html lang="en-US">
            <head>
                <title>Singleton</title>
                <meta charset="UTF-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
                <link rel="stylesheet" href="./css/style.css" >
            </head>
            <body>
            <div class='form center'>
            <?php
        }else{
            ?>
            </div>
            </body>
            </html>
            <?php
        }
    }
}