<?php

require 'vendor\autoload.php';

use Symfony\Component\DomCrawler\Crawler;

require 'colections.php';
// require 'get_content.php';

require 'get_content2.php';
require 'calculate.php';



// $arr1 = array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5);
// file_put_contents("array.json",json_encode($arr1));
// # array.json => {"a":1,"b":2,"c":3,"d":4,"e":5}
// $arr2 = json_decode(file_get_contents('array.json'), true);
// $arr1 === $arr2 # => true

// this is get arrays with collection gradde
// $Consumer_Grade = get_content2($colections_links[0]['conection_links']['Consumer Grade']);
// $Industrial_Grade = get_content2($colections_links[0]['conection_links']['Industrial Grade']);
// $Mil_Spec_Grade = get_content2($colections_links[0]['conection_links']['Mil-Spec Grade']);
// $Restricted = get_content2($colections_links[0]['conection_links']['Restricted']);

// save array in file
// file_put_contents("array.json",json_encode($Consumer_Grade));
// file_put_contents("array2.json",json_encode($Industrial_Grade));
// file_put_contents("array3.json",json_encode($Mil_Spec_Grade));
// file_put_contents("array4.json",json_encode($Restricted));

 $Consumer_Grade = json_decode(file_get_contents('array.json'), true);
 $Industrial_Grade = json_decode(file_get_contents('array2.json'), true);
 $Mil_Spec_Grade = json_decode(file_get_contents('array3.json'), true);
 $Restricted = json_decode(file_get_contents('array4.json'), true);


echo '<pre>';
var_dump($Restricted);
echo '</pre>';



?>

