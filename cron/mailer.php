#!/usr/bin/php
<?

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

/*


include_once '../lib/libmail/libmail.php';
$Settings['SMTP_MAIL'] ='testsend@allananas.ru';
$User['email'] = 'paikwm@gmail.com';
$mailTheme['title'] = 'Title';
$Text = 'text';
$Settings['SMTP_SERVER'] = 'mail.istihost.ru';
$Settings['SMTP_PASS'] = 'iqhnupaEAw';
$Settings['SMTP_PORT'] = '587';

$m= new Mail();
$m->From($Settings['SMTP_MAIL']  );
$m->ReplyTo($Settings['SMTP_MAIL'] );
$m->To( $User['email'] );   // кому, в этом поле так же разрешено указывать имя
$m->Subject( $mailTheme['title'] );
$m->Body($Text, "html");
$m->Priority(4);
$m->smtp_on($Settings['SMTP_SERVER'], $Settings['SMTP_MAIL'], $Settings['SMTP_PASS'], $Settings['SMTP_PORT']);
$m->log_on(true); // включаем лог, чтобы посмотреть служебную информацию
$a = $m->Send();

var_dump($a);
var_dump($m->status_mail);

exit();
*/

    chdir( dirname(__FILE__) );
    
    include_once '../ws/config.php';
    include_once '../ws/include/functions.php';
    
    $db =  mysqli_connect($SERVER_NAME, $DB_LOGIN, $DB_PASS, $DB_NAME);
    mysqli_set_charset($db, "utf8");
    
    /*
     * ws_mailer_news - таблица с заданиями на рассылку
     * ws_subscribers - списог подписавшихся
     * 
     * */
    
    
    $getmailer = mysqli_query($db, "SELECT * FROM ws_mailer_news WHERE status < 2 ORDER BY id ASC LIMIT 1");
    if( mysqli_num_rows($getmailer)===0 ){
        exit;
    }
    $Mailer = mysqli_fetch_assoc($getmailer); 
    if( $Mailer['status'] == 0 ){
        mysqli_query($db, "UPDATE ws_mailer_news SET status = 1 WHERE id = ".$Mailer['id']);
    }
    

    
    $getnews = mysqli_query($db, "SELECT * FROM `ws_info_blog` WHERE id = ".$Mailer['news_id']. " AND active = 1");
    if( mysqli_num_rows($getnews)===0 ){
        exit;
    }
    $News = mysqli_fetch_assoc($getnews);
    
    
    $getlastUser = mysqli_query($db, " SELECT * FROM ws_subscribers WHERE id > ".(int)$Mailer['last_user_id']." ORDER BY id ASC LIMIT 1");
    if( mysqli_num_rows($getlastUser)===0 ){
        // Это задание на рассылку закончено 
        mysqli_query($db, "UPDATE ws_mailer_news SET status = 2 WHERE id = ".$Mailer['id']);
        exit;
    }
    $User = mysqli_fetch_assoc($getlastUser);
    
    // готовим текст
    $getTextFish = mysqli_query($db, " SELECT text_".$User['lang']." AS `text` FROM ws_pages_inc WHERE code = 'NEW_NEWS' LIMIT 1");
    $Text = mysqli_fetch_assoc($getTextFish);
    
    $getLink = mysqli_query($db, 
    "SELECT * FROM ws_cpu WHERE page_id = 18 AND elem_id = ".$Mailer['news_id']." AND lang = '".$User['lang']."' LIMIT 1 ");
    $pageLink = mysqli_fetch_assoc($getLink); 
    
    $arReplace = array($News['title_'.$User['lang']], $pageLink['cpu'] );
    
    $Text = str_replace(array('{title}','{link}'), $arReplace, $Text['text'] );
    
    $getTheme = mysqli_query($db, "SELECT title_".$User['lang']." AS title FROM ws_lang_dictionary WHERE code = 'MSG_ALL_MAILER_TITLE' ");
    $mailTheme = mysqli_fetch_assoc($getTheme);
    
    include_once '../lib/libmail/libmail.php';
    
    $getSettings = mysqli_query($db, "SELECT `code`,`value` FROM ws_settings ");
    $Settings = mysqli_fetch_all($getSettings, MYSQLI_ASSOC);
    $Settings = array_column($Settings, 'value','code' ); 
    
    
    $m= new Mail();  
    $m->From($Settings['SMTP_MAIL'] );
    $m->ReplyTo( $Settings['SMTP_MAIL'] );
    $m->To( $User['email'] );   // кому, в этом поле так же разрешено указывать имя
    $m->Subject( $mailTheme['title'] );
    $m->Body($Text, "html");
    $m->Priority(4); 
    $m->smtp_on($Settings['SMTP_SERVER'], $Settings['SMTP_MAIL'], $Settings['SMTP_PASS'], $Settings['SMTP_PORT']);
    $m->log_on(true); // включаем лог, чтобы посмотреть служебную информацию
    $a = $m->Send();

    var_dump($a); dump($m->status_mail);
    
    mysqli_query($db, "UPDATE ws_mailer_news SET last_user_id = ".$User['id']." WHERE id = ".$Mailer['id']);
    
    
    
    
    
