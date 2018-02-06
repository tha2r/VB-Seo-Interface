<?php
$usedtemplates='right_side_forum';
require ('global.php');

$title='Mr7a World Of Fun | „—Õ« ° ⁄«·„ „‰ «·„—Õ';

$action=($_GET['act'])?$_GET['act']:'home';

if($action == 'thread')
{
$id=$_GET['id'];

header('location:/cc/showthread.php?t='.$id);
die();

}
elseif($action == 'rss')
{
Echo "<?xml version=\"1.0\" encoding=\"windows-1256\"?>
<rss version=\"2.0\">
<channel>
        <title>:: Mr7a World Of Fun | „—Õ« ° ⁄«·„ „‰ «·„—Õ ::</title>
        <description>√›·«„ «€«‰Ì »—«„Ã „”·”·«  „Ê«÷Ì⁄ Àﬁ«›…  —›ÌÂ „ﬁ«ÿ⁄ «·⁄«» ÃÊ«·«  movies songs programs video games</description>
        <link>http://www.mr7a.com/</link>
        <pubDate>".date("D, d M Y h:m:s",time())."</pubDate>
        <ttl>20</ttl>

        <image>
                <title>:: Mr7a World Of Fun | „—Õ« ° ⁄«·„ „‰ «·„—Õ ::</title>
                <url>http://www.mr7a.com/MR-logo.png</url>
                <link>http://www.mr7a.com/index.html</link>
        </image>
        ";
$query=$DB->query("select * from forum where parentid != '-1'");

       while($forum=$DB->fetch_array($query))
       {
Echo "        <item>

                <title>".$forum['title_clean']."</title>
                <link>http://www.mr7a.com/ff$forum[forumid]/".str_replace($fnd,$rpl,$forum['title_clean']).".html</link>
                <description><![CDATA[ $forum[description_clean] ]]></description>
                <pubDate>".date("D, d M Y h:m:s",$forum['lastpost'])." GMT</pubDate>
                <guid>http://www.mr7a.com/ff$forum[forumid]/".str_replace($fnd,$rpl,$forum['title_clean']).".html</guid>
        </item>";             $forums[$fetchf[parentid]][$fetchf[displayorder]][$fetchf[forumid]]=$fetchf;
       }

Echo "
</channel>
</rss>";
die();
}
elseif($action == 'home')
{

  $left_bits='';

$query=$DB->query("select * from thread where 1=1 order by lastpost desc limit 0,20");
while($row = $DB->fetch_array($query))
{
//$row['url']='/tt'.$row['threadid'].'/'.cleartitle($row['title']).'.html';
$row['url']='/cc/threads/'.$row['threadid'].'-'.cleartitle($row['title']);
$row['desc']="By : $row[postusername] -
  Replies : $row[replycount]  -
  Views: $row[views]  -
  Last Post By: $row[lastposter]";

$link=array( 'title'  =>  $row['title'],
             'url'    =>  $row['url'],
             'desc'   =>  $row['desc']);
    $TP->ass('art',$link);
    $left_bits.=$TP->GetTemp('right_side_bit');
}
 $TP->ass('right_last_bits',$left_bits);

   $left_bits='';

$query=$DB->query("select * from thread where 1=1 order by rand() desc limit 0,10");
while($row = $DB->fetch_array($query))
{
$row['url']='/cc/threads/'.$row['threadid'].'-'.cleartitle($row['title']);
//$row['url']='/tt'.$row['threadid'].'/'.cleartitle($row['title']).'.html';
$row['desc']="By : $row[postusername]  -
  Replies : $row[replycount]  -
  Views: $row[views]  -
  Last Post By: $row[lastposter]";

$link=array( 'title'  =>  $row['title'],
             'url'    =>  $row['url'],
             'desc'   =>  $row['desc']);
    $TP->ass('art',$link);
    $left_bits.=$TP->GetTemp('right_side_bit');
}
 $TP->ass('right_rand_bits',$left_bits);


 $TP->ass('right_contents',$TP->GetTemp('right_side'));

}
elseif($action == 'forum')
{
   $id=intval($_GET['id']);
$q=$DB->query('select * from forum where forumid='."'$id'");
$forum=$DB->fetch_array($q);

$TP->ass('forum',$forum);

  $right_bits='';

  $page=($_GET['page'])?$_GET['page']:1;
  if($page > 1){ $etc = ' - Page '.$page; }
$title=$forum['title_clean'].$etc;
  $start=($page*20)-20;

$query=$DB->query("select * from thread where forumid='$forum[forumid]' order by lastpost desc limit $start,20");
while($row = $DB->fetch_array($query))
{
//$row['url']='/tt'.$row['threadid'].'/'.cleartitle($row['title']).'.html';
$row['url']='/cc/threads/'.$row['threadid'].'-'.cleartitle($row['title']);
$row['desc']="By : $row[postusername]  -
  Replies : $row[replycount]  -
  Views: $row[views]  -
  Last Post By: $row[lastposter]";

$link=array( 'title'  =>  $row['title'],
             'url'    =>  $row['url'],
             'desc'   =>  $row['desc']);
    $TP->ass('art',$link);
    $right_bits.=$TP->GetTemp('right_side_bit');
}
 $TP->ass('right_bits',$right_bits);

$quu=$DB->query('select threadid from thread where forumid=\''.$forum['forumid'].'\'');
$num = $DB->num_rows($quu);
$pages = ceil($num / 20);
$right_pages='';
if($pages < 20)
{
for($i=1;$i<=$pages;$i++)
{
 if($page != $i)
 {
    $right_pages.=" <a href='/ff$forum[forumid]-$i/".str_replace($fnd,$rpl,$forum['title_clean']).".html'>[ $i ]</a> ";
 }
 else
 {
    $right_pages.=" [ $i ] ";
 }
}
}
else
{
for($i=1;$i<=5;$i++)
{
 if($page != $i)
 {
    $right_pages.=" <a href='/ff$forum[forumid]-$i/".str_replace($fnd,$rpl,$forum['title_clean']).".html'>[ $i ]</a> ";
 }
 else
 {
    $right_pages.=" [ $i ] ";
 }
}
if(($page > 5 ) && ($page < ($pages-5)))
{
if($page > 8){    $right_pages.=" <a href='/ff$forum[forumid]-8/".str_replace($fnd,$rpl,$forum['title_clean']).".html'> [ ..... ] </a> "; }
for($i=($page-3);$i<=($page+3);$i++)
{
if(($i > 5 ) && ($i < ($pages-5)))
{
 if($page != $i)
 {
    $right_pages.=" <a href='/ff$forum[forumid]-$i/".str_replace($fnd,$rpl,$forum['title_clean']).".html'>[ $i ]</a> ";
 }
 else
 {
    $right_pages.=" [ $i ] ";
 }
 }
}
    $right_pages.=" <a href='/ff$forum[forumid]-".($page+6)."/".str_replace($fnd,$rpl,$forum['title_clean']).".html'> [ ..... ] </a> ";
}
else
{
    $right_pages.=" <a href='/ff$forum[forumid]-".ceil($pages/2)."/".str_replace($fnd,$rpl,$forum['title_clean']).".html'> [ ..... ] </a> ";
}
for($i=($pages-5);$i<=$pages;$i++)
{
 if($page != $i)
 {
    $right_pages.=" <a href='/ff$forum[forumid]-$i/".str_replace($fnd,$rpl,$forum['title_clean']).".html'>[ $i ]</a> ";
 }
 else
 {
    $right_pages.=" [ $i ] ";
 }
}
}
 $TP->ass('right_pages',$right_pages);
 $TP->ass('right_contents',$TP->GetTemp('right_side_forum'));

}

$TP->ass('title',$title);
$TP->WebTemp("main");
$TP->print_page();

?>