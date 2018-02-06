<?php

if((@ini_get('register_globals') || !@ini_get('gpc_order')) && (isset($_POST) || isset($_GET) || isset($_COOKIE)))
{
        foreach(array_keys($_POST+$_GET+$_COOKIE+$_SERVER+$_FILES) as $key)
        {
                $$key='';
                unset($$key);
                $$key='';
        }
}
if(isset($_POST['GLOBALS'])||isset($_GET['GLOBALS'])||isset($_FILES['GLOBALS'])||isset($_COOKIE['GLOBALS'])||isset($_REQUEST['GLOBALS'])||isset($_ENV['GLOBALS']))
{
    die('Hacking attempt !!<br>you cant make your own global variables :)');
}
DEFINE("_PREFIX_",'',1);
require('./includes/functions.php');
require('./includes/class_db.php');
require('./includes/class_templates.php');

$TP = new templates;
$DB = new dbclass;
     /*
$dbconnect = $DB->connect('localhost','root','b7ebk*athoom');
if(!$dbconnect)
{
 Die('U OR P To DB');
}
$dbselect  = $DB->selectdb('vb',$dbconnect);
if(!$dbselect)
{
 Die('DB');
}
*/
$dbconnect = $DB->connect('localhost','mr7a_cc','L1M0kjN6uba');
if(!$dbconnect)
{
 Die('U OR P To DB');
}
$dbselect  = $DB->selectdb('mr7a_cc',$dbconnect);
if(!$dbselect)
{
 Die('DB');
}
$fnd=array(';','=','|','+','<','>','@','#','$','%','^','&','*',',','/','[',']',' ','\\','|','+','?',':',',','/','*',"'",'"','---','--','--','%');
//$fnd=array('=','|','+','<','>','!','@','#','$','%','^','&','*',',','/','[',']','&quot;',' ','.','\\','|','+','?',':',',','/','*','(',')',"'",'"','---','--','--','%');
$rpl="-";

function cleartitle($title)
{
  global $fnd,$rpl;

 $ret = str_replace($fnd,$rpl,$title);
 if(substr($ret,0,1) == "-")
 {
   $ret = substr($ret,1,(strlen($ret) - 1));
 }

 if(substr($ret,(strlen($ret) - 1),1) == "-")
 {
   $ret = substr($ret,0,(strlen($ret) - 1));
 }

 return $ret;
}
$tmps='page,main,right_side,right_side_bit,left_side,left_side_bit';
$usedtemplates=($usedtemplates)?$usedtemplates.','.$tmps:$tmps;
$TP->templatesused($usedtemplates);
$menublocks='';
$linksblocks='';
    $right_first='';
    $right_second='';

$query=$DB->query("select * from forum where 1=1");

       while($fetchf=$DB->fetch_array($query))
       {
             $forums[$fetchf[parentid]][$fetchf[displayorder]][$fetchf[forumid]]=$fetchf;
       }
while(list($forumidinfo,$foruminf) = each ($forums[-1]))
{
     foreach($foruminf as $forumidinfo => $foruminfo)
     {
         if(is_array($forums[$forumidinfo]))
         {
             foreach($forums[$forumidinfo] as $r => $t)
             {
                 foreach($t as $subforumid => $subforuminfo)
                 {
                    $row=$subforuminfo;
$row['url']='/ff'.$row['forumid'].'/'.str_replace($fnd,$rpl,$row['title_clean']).'.html';
$row['desc']="$row[description]  -
  Threads : $row[threadcount]  -
  Posts   : $row[replycount]";

$link=array( 'title'  =>  $row['title'],
             'url'    =>  $row['url'],
             'desc'   =>  $row['desc']);
    $TP->ass('link',$link);
    $right_bits.=$TP->GetTemp('left_side_bit');


                 }
             }
         }
             $TP->ass('left_bits',$right_bits);
             $TP->ass('left_title',$foruminfo['title']);
         $right_contents.=$TP->GetTemp('left_side');
         $right_bits='';

     }
}
    $TP->ass('left_contents',$right_contents);

?>