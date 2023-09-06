<!DOCTYPE html>
<html lang="<?=$CCpu->lang?>" class="page">

<head>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>

<body class="page__body" id="body">
	<div class="wrapper">
        <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
	
	<?$article = $Db -> getone("SELECT * FROM ws_news WHERE id = ".$pageData['elem_id']." ");
	$day = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_days WHERE day_code = '".date('D',strtotime($article['date']))."'");
	$month = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_months WHERE id = '".date('m',strtotime($article['date']))."'");
	$gallery = $Db -> getall("SELECT id, image FROM ws_photogallery WHERE page_id = ".$pageData["page_id"]." AND elem_id = ".$pageData['elem_id']." ORDER BY sort DESC");?>?>
	
	
	<main class="main">
            <section class="crumbs">
                <div class="container">
                    <div class="crumbs__wrapper">
                        <a class="crumbs__wrapper__item" href="<?=$CCpu -> writelink(1)?>"><?=$CCpu -> writetitle(1)?></a>
                        <div class="crumbs__wrapper__separator"><img src="/icons/arrow-crumbs.svg" alt=""></div>
                        <a class="crumbs__wrapper__item" href="<?=$CCpu -> writelink(86)?>"><?=$CCpu -> writetitle(86)?></a>
                        <div class="crumbs__wrapper__separator"><img src="/icons/arrow-crumbs.svg" alt=""></div>
                        <a class="crumbs__wrapper__item crumbs-active" href=""><?=$article['title_'.$CCpu -> lang]?></a>
                    </div>
                </div>
            </section>

            <section class="article">
                <div class="container">
                    <div class="article__wrapper">
                        <div class="article__wrapper__info">
                            <div class="article__wrapper__info__data">
                            <?=$day['title']?>, 
                          	<?=date('d',strtotime($article['date']))?> 
                          	<?=$month['title']?> 
                          	<?=date('Y',strtotime($article['date']))?>
                            </div>
                            <div class="article__wrapper__info__title">
                                <?=$article['title_'.$CCpu -> lang]?>

                            </div>
                        </div>

                        <div class="slider__container">
                            <div class="swiper-container slider article__carousel">
                                <div class="swiper-wrapper ">
                                	<div class="swiper-slide main-photo-fullscreen"><img
                                            src="/upload/news/<?=$article['image']?>" alt=""></div>
                                    <?foreach($gallery as $key => $photo){?>
                                    <div class="swiper-slide main-photo-fullscreen"><img
                                            src="/upload/gallery/thumb/<?=$photo['image']?>" alt=""></div>
                                            <?}?>
                                </div>
                            </div>

                            <div class="swiper-container slider-thumbnail article-slider">
                                <div class="swiper-wrapper ">
                                	<div class="swiper-slide"><img
                                            src="/upload/news/<?=$article['image']?>" alt=""></div>
                                    <?foreach($gallery as $key => $photo){?>
                                    <div class="swiper-slide"><img
                                            src="/upload/gallery/thumb/<?=$photo['image']?>" alt=""></div>
                                            <?}?>
                                </div>
                            </div>
                            <div class="article__btns">
                                <div class="swiper-button-next next5"></div>
                                <div class="swiper-button-prev prev5"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
									
            <section class="recomendation">
                <div class="container">
                    <div class="recomendation__wrapper">
                        <div class="recomendation__wrapper__info">
                        	<div class="floater"></div>
                            	<?=$article['text_'.$CCpu -> lang]?>
                            <div class="recomendation__wrapper__info__line"></div>
                            <div class="recomendation__wrapper__info__box">
                            	<a href="<?=$CCpu -> writelink(74)?>">
                            		<div class="recomendation__wrapper__info__box__btn red"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATSA_NA_PRIOM']?></div>
                            	</a>
                                <div class="recomendation__wrapper__info__box__share"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_PODELITSA']?><span><img src="/icons/share.svg" alt=""></span>
	                                <span class="social_links"><img id="details__page__facebook" src="/icons/facebook.svg" alt=""></span>
	                                <span class="social_links"><img id="details__page__twitter" src="/icons/twitter.svg" alt=""></span>
	                                <span class="social_links"><img id="details__page__linked-in" style="max-height: 20px; max-width: 20px;" src="/icons/linked-in.svg" alt=""></span>
	                                <span class="social_links"><img id="details__page__vk" src="/icons/vk.png" alt=""></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
</div>

<script>
    $(document).ready( function() {
        $(".main-photo-fullscreen").click( function() {
            this.requestFullscreen();
        });
    });
    
    $(".recomendation__wrapper__info__box__share").click( function() {
    	$('.social_links').toggle();
    });
    
    var url = location.href;
    
    fb_button = document.querySelector("#details__page__facebook");
    twitter_button = document.querySelector("#details__page__twitter");
    linkedIn_button = document.querySelector("#details__page__linked-in");
    vk_button = document.querySelector("#details__page__vk");
    
    fb_button.addEventListener('click', function() {
		    window.open('https://www.facebook.com/sharer/sharer.php?u=' + url,
		        'facebook-share-dialog',
		        'width=800,height=600'
    );
    return false;
});
    twitter_button.addEventListener('click', function() {
		    window.open('http://twitter.com/share?url=' + url,
			    );
    return false;
});
	linkedIn_button.addEventListener('click', function() {
			    window.open('https://www.linkedin.com/sharing/share-offsite/?url=' + url,
	    			);
	    return false;
	});
	vk_button.addEventListener('click', function() {
			    window.open('https://vk.com/share.php?url=' + url,
	    			);
	    return false;
	});
    
    
</script>

</body>	
				
	
		
</html>