<?php

              function getip()
              {
               global $_SERVER;

                      if (isset($_SERVER['HTTP_CLIENT_IP']))
                      {
                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                      }
                      else if($_SERVER['HTTP_X_FORWARDED_FOR'])
                      {
                         if(preg_match_all("#[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}#s", $_SERVER['HTTP_X_FORWARDED_FOR'], $ips))
                         {
                              while(list($key, $val) = each($ips[0]))
                              {
                                   if(!preg_match("#^(10|172\.16|192\.168)\.#", $val))
                                   {
                                         $ip = $val;
                                         break;
                                   }
                              }
                         }
                      }
                      else if (isset($_SERVER['REMOTE_ADDR']))
                      {
                       $ip = $_SERVER['REMOTE_ADDR'];
                      }

                return $ip;
              }


              function smilies($text)
              {
                $replacearray = array('/images/smilies/biggrin.gif',
                                      '/images/smilies/confused.gif',
                                      '/images/smilies/cool.gif',
                                      '/images/smilies/cool2.gif',
                                      '/images/smilies/dozingoff.gif',
                                      '/images/smilies/dry.gif',
                                      '/images/smilies/huh.gif',
                                      '/images/smilies/inlove.gif',
                                      '/images/smilies/laugh.gif',
                                      '/images/smilies/lookaround.gif',
                                      '/images/smilies/mad.gif',
                                      '/images/smilies/notify.gif',
                                      '/images/smilies/ohmy.gif',
                                      '/images/smilies/rolleyes.gif',
                                      '/images/smilies/sad.gif',
                                      '/images/smilies/smile.gif',
                                      '/images/smilies/thumbs.gif',
                                      '/images/smilies/tounge.gif',
                                      '/images/smilies/wink.gif',
                                      '/images/smilies/wub.gif');

                $textarray = array(':D',':confused:',':cool:',':cool2:',':dozingoff:',':dry:',':huh:',':inlove:',':laugh:',':lookaround:'
                                  ,':mad:',':notify:',':ohmy:',':rolleyes:',':(',':)',':thumbs:',':p',';)',':wub:');

                                  $array1=array('):','(:','(;');
                                  $array2=array(':(',':)',';)');
                                  $text=str_replace($array1,$array2,$text);
                                  foreach($replacearray as $key => $val)
                                  {
                                   $replacearray[$key]='<img src="'.$val.'">';
                                  }

                 return str_replace($textarray,$replacearray,$text);
              }

              function redirect($message,$link,$titleetc="")
              {
              GLOBAL $TP;
              $titleetc=($titleetc)?$titleetc:"ArBB";
              $GLOBALS['url']=$url;
              $GLOBALS['message']=$message;
              $GLOBALS['titleetc']=$titleetc;

                  $GLOBALS['message'] = $message;
                  $GLOBALS['url']              = $link;

                      Echo $TP->GetTemp("redirection");
                      exit;
              }

                  function sendmail($to_email, $subject, $message, $from = '', $username = '')
                  {

                      $to_email = trim($to_email);

                      if ($to_email != '')
                      {
                              $subject = trim($subject);
                              $message = preg_replace("/(\r\n|\r|\n)/s", "\r\n", trim($message));
                              $from = trim($from);
                              $username = trim($username);

                             $headers = 'From: "' . "$username @ ArBB". "\" <$from>\r\n" . $headers;


                              $headers.='Date: '.date('r')."\r\n"
                                        .'MIME-Version: 1.0'."\r\n"
                                        .'Content-transfer-encoding: 8bit'."\r\n"
                                        .'Content-type: text/plain; charset=iso-8859-1'."\r\n"
                                        .'X-Mailer: ArBB Mailer Via PHP';
                              mail($to_email, $subject, $message, trim($headers));
                              return true;

                      }
                      else
                      {
                              return false;
                      }

                  }

              function error_message($error)
              {
                GLOBAL $TP;
                 extract($GLOBALS);
                $errormessage=$error;
                $GLOBALS['errormessage']=$error;
                 extract($GLOBALS);
                $posts=$TP->GetTemp('error');
                $GLOBALS['posts']=$posts;
                   $TP->print_page();
                   exit;
              }

              function random_string($length="8")
              {
                      $set = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9');
                      $str = '';
                      $i=1;
                      while($i <= $length)
                      {
                            $i++;
                              $ch = rand(0, count($set)-1);
                              $str .= $set[$ch];
                      }
                      return $str;
              }

              function get_extension($file)
              {
                return strtolower(substr(strrchr($file, '.'), 1));
              }

              function bbcode($text)
              {
                  $text = preg_replace("/\[B\](.*)\[\/B\]/isU","<b>$1</b>", $text);
                  $text = preg_replace("/\[I\](.*)\[\/I\]/isU","<i>$1</i>", $text);
                  $text = preg_replace("/\[U\](.*)\[\/U\]/isU","<u>$1</u>", $text);
                  $text = preg_replace("/\[CENTER\](.*?)\[\/CENTER\]/isU","<center>$1</center>", $text);
                  $text = preg_replace("/\[url=(.*)\](.*)\[\/URL\]/isU", "<a href=\"$1\" target=\"_blank\">$2</a>", $text);
                  $text = preg_replace("/\[URL\](.*)\[\/URL\]/isU", "<a href=\"$1\" target=\"_blank\">$1</a>", $text);
                  $text = preg_replace("/\[EMAIL\](.*)\[\/EMAIL\]/isU", "<a href=\"mailto:$1\">$1</a>", $text);
                  $text = preg_replace("/\[img\](.*)\[\/img\]/isU", "<img src=\"$1\" />", $text);
                  $text = preg_replace("/\[code\](.*)\[\/code\]/isU", "<pre>$1</pre>", $text);
                  $text = preg_replace("/\[COLOR=(.*)\](.*)\[\/COLOR\]/isU", "<font color=\"$1\">$2</font>", $text);
                  $text = preg_replace("/\[SIZE=(.*)\](.*)\[\/SIZE\]/isU", "<font size=\"$1\">$2</font>", $text);
                  $text = preg_replace("/\[font=(.*)\](.*)\[\/FONT\]/isU", "<font face=\"$1\">$2</font>", $text);
                  $text = preg_replace("/\[list=(.*)\](.*)\[\/LIST\]/isU", "<ol start=\"1\" type=\"$1\">$2</ol>", $text);
                  $text = preg_replace("/\[*\](.*)/isU", "<li>$1", $text);

                  /* Smilies */


                  $text = smilies($text);
                  $text = nl2br($text);
                  return $text;
              }

              function getsmilies_foreditor()
              {

                 $replacearray = array('/images/smilies/biggrin.gif',
                        '/images/smilies/confused.gif',
                        '/images/smilies/cool.gif',
                        '/images/smilies/cool2.gif',
                        '/images/smilies/dozingoff.gif',
                        '/images/smilies/dry.gif',
                        '/images/smilies/huh.gif',
                        '/images/smilies/inlove.gif',
                        '/images/smilies/laugh.gif',
                        '/images/smilies/lookaround.gif',
                        '/images/smilies/mad.gif',
                        '/images/smilies/notify.gif',
                        '/images/smilies/ohmy.gif',
                        '/images/smilies/rolleyes.gif',
                        '/images/smilies/sad.gif',
                        '/images/smilies/smile.gif',
                        '/images/smilies/thumbs.gif',
                        '/images/smilies/tounge.gif',
                        '/images/smilies/wink.gif',
                        '/images/smilies/wub.gif');

                  $textarray = array(':D',':confused:',':cool:',':cool2:',':dozingoff:',':dry:',':huh:',':inlove:',':laugh:',':lookaround:'
                                    ,':mad:',':notify:',':ohmy:',':rolleyes:',':(',':)',':thumbs:',':p',';)',':wub:');

                  $smilies="";

                foreach($replacearray as $key => $val)
                {
                 $smilies.="<img src=\"".$replacearray[$key]."\" onclick=\"javascript:smilie('".$textarray[$key]."')\">";
                }

                return $smilies;

              }



              function mydate($timestring='now',$type='normal')
              {
              if($timestring=='now')
              {
                 $timestring=time();
              }

              $date=@getdate($timestring);

              if($type=='normal')
              {
                  $datee = $date;
                      }
                      elseif($type=='last')
                      {

                          $date2=getdate(time());
                          $datee='';
                          if(($date['year']==$date2['year'])&&($date['month']==$date2['month']))
                          {
                              if($date['mday']==$date2['mday'])
                              {
                                  $datee='Today';
                                      }
                                      elseif($date2['mday']==$date['mday']+1)
                                      {
                                          $datee='Yesterday';
                                              }
                                              else
                                              {
                                                  $datee=$date['mday'].'-'.$date['mon'].'-'.$date['year'];
                                                      }

                                  }
                                  else
                                  {
                                      $datee=$date['mday'].'-'.$date['mon'].'-'.$date['year'];
                                          }
                                           $pmam=$lang['am'];

                                          if($date['hours']==12)
                                          {
                                               $pmam=$lang['pm'];
                                          }
                                          elseif($date['hours']==24)
                                          {
                                           $pmam=$lang['am'];
                                           $date['hours']='00';
                                          }
                                          elseif($date['hours']>12)
                                          {
                                           $date['hours']=$date['hours']-12;
                                           $pmam=$lang['pm'];
                                          }
                                      $datee.= ' ,'.$lang['at'].'&nbsp;'.$date['hours'].':'.$date['minutes'].'&nbsp;'.$pmam;

                              }
                              elseif($type=='time')
                              {
                                   $datee = time();
                                      }
                                      elseif($type=='hour')
                                      {
                                      $pmam=$lang['am'];

                                          if($date['hours']==12)
                                          {
                                               $pmam=$lang['pm'];
                                          }
                                          elseif($date['hours']==24)
                                          {
                                           $pmam=$lang['am'];
                                           $date['hours']='00';
                                          }
                                          elseif($date['hours']>12)
                                          {
                                           $date['hours']=$date['hours']-12;
                                           $pmam=$lang['pm'];
                                          }
                                      $datee= $date['hours'].':'.$date['minutes'].'&nbsp;'.$pmam;
                                              }
                                              elseif($type='date')
                                              {
                                                  $datee=$date['mday'].'-'.$date['mon'].'-'.$date['year'];
                                                      }
                         return $datee;
              }
?>