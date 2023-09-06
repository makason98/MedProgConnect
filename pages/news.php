<!DOCTYPE html>
<html lang="<?=$CCpu->lang?>" class="page">

<head>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>

<body class="page__body" id="body">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PMZGTD4"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<div class="wrapper">
        <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
	
	<?$news_articles = $Db -> getall("SELECT id,image,date,title__ AS title,preview__ AS preview FROM ws_news WHERE active = 1 ORDER BY date DESC")?>
	
	<main class="main">
		
		<section class="crumbs">
                <div class="container">
                    <div class="crumbs__wrapper">
                        <a class="crumbs__wrapper__item" href="<?=$CCpu -> writelink(1)?>"><?=$CCpu -> writetitle(1)?></a>
                        <div class="crumbs__wrapper__separator"><img src="/icons/arrow-crumbs.svg" alt=""></div>
                        <a class="crumbs__wrapper__item crumbs-active" href=""><?=$CCpu -> writetitle(86)?></a>
                    </div>
                </div>
            </section>
            
			<div class="container" style="max-width: 1800px; width: 85%;">
				<div class="row">
					<div class="col-12">
						<div class="news__title section-title">
							<h2><?=$page_data['title']?></h2>
						</div>
					</div>
				</div>
				<div class="row">
					<?foreach($news_articles as $key => $article){
						$day = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_days WHERE day_code = '".date('D',strtotime($article['date']))."'");
						$month = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_months WHERE id = '".date('m',strtotime($article['date']))."'");
                				?>
					<div class="col-lg-20 col-sm-6 news-col">
						<div class="news__card">
							<div class="news__slider">
							 <a href="<?=$CCpu -> writelink(81,$article['id'])?>">
	                      <div class="news__slider__box">
	                        <img src="<?=$lozad?>" class="lozad" data-src="/upload/news/<?=$article['image']?>" alt="<?=$article['title']?>" decoding="async">
	                      </div>
                      	<div class="news__slider__box">
	                        <div class="news__slider__box__content">
	                          <div class="news__slider__box__content__data" style="font-weight: bold;">
	                          	<?=$day['title']?>, 
	                          	<?=date('d',strtotime($article['date']))?> 
	                          	<?=$month['title']?> 
	                          	<?=date('Y',strtotime($article['date']))?>
	                          </div>
	                         </a>
	                          <div class="news__slider__box__content__social">
	                            <div class="news__slider__box__content__social__item__facebook" 
	                            onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + location.href + <?=$CCpu -> writelink(81,$article['id'])?>,
						        'facebook-share-dialog',
						        'width=800,height=600');return false;">
			    				<img src="/icons/facebook.svg" alt=""></div>
	                            <div class="news__slider__box__content__social__item__twitter" 
	                            onclick="window.open('http://twitter.com/share?url=' + location.href + <?=$CCpu -> writelink(81,$article['id'])?>,);return false;">
	                            <img src="/icons/twitter.svg" alt=""></div>
                          </div>
	                       </div>
	                      </div>
	                     <a href="<?=$CCpu -> writelink(81,$article['id'])?>">
	                      <div class="news__slider__box">
	                        <h3><?=$article['title']?></h3>
	                        	<?=$article['preview']?>
	                      </div>
	                     </a>
	                    </div>
						</div>
					</div>
					<?}?>
				</div>
			</div>
	</main>
	
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
</div>
</body>	
				
	
		
</html>