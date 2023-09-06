<?
$Lang = $Main->GetDefaultLanguage();
$lang = $Lang['code'];
if(isset($_SESSION['last_lang']) && in_array($_SESSION['last_lang'], $CCpu->langList)){
    $lang = $_SESSION['last_lang'];
}

$CCpu->lang = $Main->lang = $lang;

$GLOBALS['ar_define_langterms'] = $Main->GetDefineLangTerms( $lang );
$defaultLinks['index'] = $CCpu->writelinkOne(1);
$page_404 = 0 ;
?>
<!DOCTYPE html>
<html>
	<head>
		<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
	</head>
	<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PMZGTD4"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
		<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
		
		
		<div id="content" >
			<div id="page">

                <? include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php") ?>

				<div class="container">

                    <div style="text-align: center">
                        <img src="/images/404.png" alt="">
                    </div>
                    <div style="text-align: center">
                        <h3>
                            Page not found
                        </h3>
                    </div>

				</div>

			</div>	
		</div>
	
		
		<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
		
	</body>
</html>