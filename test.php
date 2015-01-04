<?php
/**
 * Created by IntelliJ IDEA.
 * User: amir
 * Date: 1/2/15
 * Time: 5:48 PM
 */
define('BUYSTATE_JUST_REQUESED',1);
//print BUYSTATE_JUST_REQUESED;
$i = $_GET[i];
session_id("salam".$i);
session_start();

$ROF = 3500;
$price_array=array(
    '7720,1,1'=>array('price'=>(10*$ROF*1.07)+(17*$ROF),'code'=>19654258,'title'=>'Visa 10$'),
    '7720,1,2'=>array('price'=>(20*$ROF*1.07)+(17*$ROF),'code'=>19654258,'title'=>'Visa 20$'),
    '7720,1,3'=>array('price'=>(25*$ROF*1.07)+(17*$ROF),'code'=>19654258,'title'=>'Visa 25$'),
    '7720,1,4'=>array('price'=>(50*$ROF*1.07)+(17*$ROF),'code'=>19654258,'title'=>'Visa 50$'),
    '7720,1,5'=>array('price'=>(100*$ROF*1.07)+(17*$ROF),'code'=>19654258,'title'=>'Visa 100$'),

    '7720,2,1'=>array('price'=>10*$ROF*1.084,'code'=>19654258,'title'=>'iTunes 10$'),
    '7720,2,2'=>array('price'=>15*$ROF*1.078,'code'=>19654258,'title'=>'iTunes 15$'),
    '7720,2,3'=>array('price'=>25*$ROF*1.070,'code'=>19654258,'title'=>'iTunes 25$'),
    '7720,2,4'=>array('price'=>50*$ROF*1.059,'code'=>19654258,'title'=>'iTunes 50$'),
    '7720,2,5'=>array('price'=>100*$ROF*1.044,'code'=>19654258,'title'=>'iTunes 100$'),

    '7720,3,1'=>array('price'=>10*$ROF*1.14,'code'=>19654258,'title'=>'Amazon 10$'),
    '7720,3,2'=>array('price'=>15*$ROF*1.114,'code'=>19654258,'title'=>'Amazon 15$'),
    '7720,3,3'=>array('price'=>25*$ROF*1.114,'code'=>19654258,'title'=>'Amazon 25$'),
    '7720,3,4'=>array('price'=>50*$ROF*1.068,'code'=>19654258,'title'=>'Amazon 50$'),
    '7720,3,5'=>array('price'=>100*$ROF*1.056,'code'=>19654258,'title'=>'Amazon 100$'),

    '7720,4,1'=>array('price'=>10*$ROF*1.109,'code'=>19654258,'title'=>'Google Play 10$'),
    '7720,4,2'=>array('price'=>15*$ROF*1.101,'code'=>19654258,'title'=>'Google Play 15$'),
    '7720,4,3'=>array('price'=>25*$ROF*1.166,'code'=>19654258,'title'=>'Google Play 25$'),
    '7720,4,4'=>array('price'=>50*$ROF*1.105,'code'=>19654258,'title'=>'Google Play 50$'),
    '7720,4,5'=>array('price'=>100*$ROF*1.01,'code'=>19654258,'title'=>'Google Play 100$'),

    '7720,5,1'=>array('price'=>10*$ROF*1.104,'code'=>19654258,'title'=>'Xbox 10$'),
    '7720,5,2'=>array('price'=>15*$ROF*1.061,'code'=>19654258,'title'=>'Xbox 15$'),
    '7720,5,3'=>array('price'=>25*$ROF*1.084,'code'=>19654258,'title'=>'Xbox 25$'),
    '7720,5,4'=>array('price'=>50*$ROF*1.033,'code'=>19654258,'title'=>'Xbox 50$'),
    '7720,5,5'=>array('price'=>100*$ROF*1.018,'code'=>19654258,'title'=>'Xbox 100$'),

    '7720,6,1'=>array('price'=>10*$ROF*1.108,'code'=>19654258,'title'=>'PlayStation 10$'),
    '7720,6,2'=>array('price'=>20*$ROF*1.128,'code'=>19654258,'title'=>'PlayStation 20$'),
    '7720,6,3'=>array('price'=>50*$ROF*1.81,'code'=>19654258,'title'=>'PlayStation 50$'),

    '7720,7,1'=>array('price'=>10*$ROF*1.14,'code'=>19654258,'title'=>'Microsoft 10$'),
    '7720,7,2'=>array('price'=>15*$ROF*1.114,'code'=>19654258,'title'=>'Microsoft 15$'),
    '7720,7,3'=>array('price'=>25*$ROF*1.114,'code'=>19654258,'title'=>'Microsoft 25$'),
    '7720,7,4'=>array('price'=>50*$ROF*1.068,'code'=>19654258,'title'=>'Microsoft 50$'),
    '7720,7,5'=>array('price'=>100*$ROF*1.056,'code'=>19654258,'title'=>'Microsoft 100$')


);
function getProductName($path){
  return $GLOBALS['price_array']['7720,7,5']['title'];
}

print getProductName('k');

print_r($_SESSION);
if($i==1){

$_SESSION['i']=10;
  session_destroy();
}  else{

  $_SESSION['i']=20;
}

//$i = 0;
//$i = $_SESSION['i'];
//if($i ==0){
//  $_SESSION['a']='salam';
//  $_SESSION['i']=1;
//  print_r($_SESSION);
//
//
//}  else{
//  $_SESSION['a']='khoobi?';
//  $_SESSION['i']=0;
//  print_r($_SESSION);
//}
