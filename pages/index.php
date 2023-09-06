<!DOCTYPE html>
<html lang="<?=$CCpu->lang?>">
	<head>
		<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
	</head>
	<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PMZGTD4"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
		<div class="wrapper">
            <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
            <? include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php") ?>
            <?$slider_video = $Db -> getone("SELECT video FROM ws_slider_video WHERE active = 1");?>
            <main class="main">
                <section class="promo">
                    <div class="swiper slider-bg">
                        <?if($slider_video){?>
                            <video width="1440px" height="550px;" autoplay muted loop>
                                <source src="/upload/slider/video/<?=$slider_video['video']?>" type="video/mp4">
                                    Your browser does not support the video tag.
                            </video>
                        <?}else{?>
                            <div class="swiper-wrapper">
                            <?$sliderInfo = $Db->getall( "SELECT title__ AS title, subtitle__ AS subtitle,image__ AS image FROM `ws_slider` WHERE `active` = 1 ORDER BY sort DESC ");
                            $slidecounter = 1;
                                foreach($sliderInfo as $key => $slider){?>
                                <div class="swiper-slide lozad" data-background-image="/upload/slider/<?=$slider['image']?>">
                                    <div class="slide__wrapper">
                                        <div class="slide__wrapper__title">
                                          <?=$slider['title']?>
                                        </div>
                                        <div class="slide__wrapper__subtitle"><?=$slider['subtitle']?></div>
                                        <div class="slide__wrapper__btns">
                                            <a class="desktop__button" href="<?=$CCpu -> writelink(74)?>">
                                                <div class="slide__wrapper__btns__appoiment red"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATSA_NA_PRIOM']?></div>
                                            </a>
                                            <a class="mobile__button" href="tel:<?=$GLOBALS['ar_define_settings']['TEL_CONTACT']?>">
                                                <div class="slide__wrapper__btns__appoiment red "><?=$GLOBALS['ar_define_langterms']['MSG_ALL_POZVONITI']?></div>
                                            </a>
                                        </div>
                                        <div class="swiper-pagination pag1"></div>
                                    </div>
                                </div>
                                <?$slidecounter++;?>
                          <?}?>
                            </div>
                            <div class="swiper-button-prev prev1"></div>
                            <div class="swiper-button-next next1"></div>
                        <?}?>
                    </div>
                </section>
                <section class="about">
                    <div class="container">
                      <div class="about__wrapper">
                        <?=$page_data['text']?>
                      </div>
                    </div>
                  </section>
                <ahref="/pages/index.php" id="clinics-index"><section class="clinics"></a>
                    <?$officeInfo = $Db->getall( "SELECT id,city__ AS city, address__ AS adress,google_maps_link,work_hours,email,saturday_hours,analysis_saturday,analysis,phone,image
                                                             FROM `ws_offices` WHERE `active` = 1	ORDER BY sort DESC  ");?>
                <div class="container">
                  <div class="clinics__wrapper">
                    <h3 class="clinics__wrapper__title blue_h3">
                      <?=$GLOBALS['ar_define_langterms']['MSG_ALL_VIBERITE_KLINIKU']?>
                    </h3>
                    <div class="clinics__wrapper__subtitle"><?=count($officeInfo)?> <?=$GLOBALS['ar_define_langterms']['MSG_ALL_FILIALOV']?></div>
                    <div class="tab_streets">
                    <div class="swiper streets" style="padding: 0px 1%;">
                      <div class="swiper-wrapper">
                        <?$i = 1;
                        foreach($officeInfo as $key => $office){?>
                        <div class="swiper-slide">
                            <?$getStyles = $Db->getone("SELECT text_default,text_hover,text_active FROM ws_index_tabs_settings LIMIT 1 ")?>
                            <div class="street_wrapper <?if ($i == '1'){echo 'street-active';}?>">
                                <?
                                $office['city'] = str_replace('&#13;&#10;', '</br>', $office['city']);
                                ?>
                                <div class="street">
                                    <?=str_replace('Example',$office['city'],$getStyles['text_default'])?>
                                </div>
                                <div class="street_hover">
                                    <?=str_replace('Example',$office['city'],$getStyles['text_hover'])?>
                                </div>
                                <div class="street_active">
                                    <?=str_replace('Example',$office['city'],$getStyles['text_active'])?>
                                </div>
                            </div>
                        </div>
                        <?$i++; }?>
                      </div>
                    </div>
                    <?foreach($officeInfo as $key => $office){
                    $office_gallery = $Db -> getone("SELECT image FROM ws_photogallery WHERE page_id = 73 AND elem_id = ".$office['id']." ");?>
                    <div class="tab__info <?if($key == 0){?> tab-active <?}?>">
                      <div class="tab__info__wrapper">
                        <div class="tab__info__wrapper__box">
                          <div class="tab__info__wrapper__box__img">
                            <?/* <img src="/upload/gallery/thumb/<?=$office_gallery['image']?>" alt="street"> */?>
                            <img src="<?=$lozad?>" class="lozad" data-src="/upload/offices/<?=$office['image']?>" alt="street">
                          </div>
                        </div>
                        <div class="tab__info__wrapper__box">
                          <div class="tab__info__wrapper__box__content">
                            <div class="tab__info__wrapper__box__content__item">
                              <div class="tab__info__wrapper__box__content__item__title"><?=$office['address']?></div>
                              <div class="tab__info__wrapper__box__content__item__subtitle"><?=$office['city']?></div>
                            </div>
                            <div class="tab__info__wrapper__box__content__item">
                             <a onclick="window.open(this.href,'_blank'); return false;" href="<?=$office['google_maps_link']?>">
                              <div class="tab__info__wrapper__box__content__item__btn"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_POSMOTRETI_NA_KARTE']?></div>
                             </a>
                            </div>
                          </div>
                          <div class="tab__info__wrapper__box__content">
                            <div class="tab__info__wrapper__box__content__item">
                              <div class="tab__info__wrapper__box__content__item__day"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_PONEDELNIK_PIATNITSA']?></div>
                              <div class="tab__info__wrapper__box__content__item__hours"><?=$office['work_hours']?></div>
                              <div class="tab__info__wrapper__box__content__item__analysis"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_SDACYA_ANALIZOV']?> <?=$office['analysis']?></div>
                            </div>
                            <div class="tab__info__wrapper__box__content__item">
                              <div class="tab__info__wrapper__box__content__item__day"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_SUBBOTA']?></div>
                              <div class="tab__info__wrapper__box__content__item__hours"><?=$office['saturday_hours']?></div>
                              <div class="tab__info__wrapper__box__content__item__analysis"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_SDACYA_ANALIZOV']?> <?=$office['analysis_saturday']?></div>
                            </div>
                            <div class="tab__info__wrapper__box__content__item">
                              <a class="tab__info__wrapper__box__content__item__phone" href="tel:<?=$office['phone']?>">
                                <span><img src="<?=$lozad?>" class="lozad" data-src="/icons/phone.svg" alt="phone"></span><div class="phone_number"><?=$office['phone']?></div>
                              </a>
                              <a class="tab__info__wrapper__box__content__item__mail" href="mailto:<?=$office['email']?>">
                                <?=$office['email']?></a>
                            </div>
                          </div>
                          <div class="tab__info__wrapper__box__content">
                            <a href="<?=$CCpu -> writelink(73)."?office=".$office['id']?>">
                                <div class="tab__info__wrapper__box__content__btn red"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATSA_NA_PRIOM']?></div>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?}?>
                    </div>
                  </div>
                </div>
              </section>
                <a href="/pages/index.php" id="consulting" aria-label="Consultatii"></a>
                <section class="consulting"></a>
                    <?$categories = $Db -> getall("SELECT id,image,image_hover,title_plural__ AS title_plural FROM ws_category WHERE active = 1 ORDER BY sort,id ASC");?>
                <div class="container">
                  <div class="consulting__wrapper">
                    <div class="consulting__wrapper__box">
                      <div class="consulting__wrapper__box__item">
                        <h3 class="consulting__wrapper__box__item__title blue_h3">
                            <?=$Main->GetPageIncData('CONSULT_TXT' , $CCpu->lang)?>
                        </h3>
                        <h3 class="consulting__wrapper__box__item__sutitle"><?=count($categories)?> <?=$GLOBALS['ar_define_langterms']['MSG_ALL_SPETSALINOSTEI']?></h3>
                      </div>
                      <div class="consulting__wrapper__box__descr"><?=$Main->GetPageIncData('TEXT_CATEGORIES' , $CCpu->lang)?>
                        </div>
                    </div>
                    <div class="consulting__wrapper__box__cards__container">
                      <div class="consulting__wrapper__box__card">
                        <?for($i = 0; $i < count($categories); $i+=3){?>
                        <a class="consulting__wrapper__box__card__item" data-src="/upload/category/<?=$categories[$i]['image']?>"
                            data-hover="/upload/category/<?=$categories[$i]['image_hover']?>" href="<?=$CCpu -> writelink(74)."?category=".$categories[$i]['id']?>">
                          <span class="icon"><img class="lozad" src="<?=$lozad?>" data-src="/upload/category/<?=$categories[$i]['image']?>" alt="<?=$categories[$i]['title_plural']?>" width="36" height="39"></span><span class="category"><?=$categories[$i]['title_plural']?></span>
                        </a>
                       <?}?>
                      </div>
                      <div class="consulting__wrapper__box__card">
                        <?for($i = 1; $i < count($categories); $i+=3){?>
                        <a class="consulting__wrapper__box__card__item" data-src="/upload/category/<?=$categories[$i]['image']?>"
                            data-hover="/upload/category/<?=$categories[$i]['image_hover']?>" href="<?=$CCpu -> writelink(74)."?category=".$categories[$i]['id']?>">
                          <span class="icon"><img class="lozad" src="<?=$lozad?>" data-src="/upload/category/<?=$categories[$i]['image']?>" alt="<?=$categories[$i]['title_plural']?>" width="36" height="39"></span><span class="category"><?=$categories[$i]['title_plural']?></span>
                        </a>
                       <?}?>
                      </div>
                      <div class="consulting__wrapper__box__card">
                        <?for($i = 2; $i < count($categories); $i+=3){?>
                        <a class="consulting__wrapper__box__card__item" data-src="/upload/category/<?=$categories[$i]['image']?>"
                            data-hover="/upload/category/<?=$categories[$i]['image_hover']?>" href="<?=$CCpu -> writelink(74)."?category=".$categories[$i]['id']?>">
                          <span class="icon"><img class="lozad" src="<?=$lozad?>" data-src="/upload/category/<?=$categories[$i]['image']?>" alt="<?=$categories[$i]['title_plural']?>" width="36" height="39"></span><span class="category"><?=$categories[$i]['title_plural']?></span>
                        </a>
                       <?}?>
                      </div>
                    </div>
                        <?//Different ordering system?>

                    <?/*<div class="consulting__wrapper__box">
                      <div class="consulting__wrapper__box__card">
                        <?for($i = 0; $i < $cat_per_card+$first_card_add; $i++){?>
                        <a class="consulting__wrapper__box__card__item" style="height: 40px;" href="<?=$CCpu -> writelink(74)."?category=".$categories[$i]['id']?>">
                          <span><img src="upload/category/<?=$categories[$i]['image']?>" alt=""></span><?=$categories[$i]['title_plural']?>
                        </a>
                       <?}?>
                      </div>
                      <div class="consulting__wrapper__box__card">
                        <?for($i = $cat_per_card+$first_card_add; $i < $cat_per_card*2+$first_card_add+$second_card_add; $i++){?>
                        <a class="consulting__wrapper__box__card__item" style="height: 40px;" href="<?=$CCpu -> writelink(74)."?category=".$categories[$i]['id']?>">
                          <span><img src="upload/category/<?=$categories[$i]['image']?>" alt=""></span><?=$categories[$i]['title_plural']?>
                        </a>
                       <?}?>
                      </div>
                      <div class="consulting__wrapper__box__card">
                        <?for($i = $cat_per_card*2+$first_card_add+$second_card_add; $i < $cat_per_card*3+$first_card_add+$second_card_add; $i++){?>
                        <a class="consulting__wrapper__box__card__item" style="height: 40px;" href="<?=$CCpu -> writelink(74)."?category=".$categories[$i]['id']?>">
                          <span><img src="upload/category/<?=$categories[$i]['image']?>" alt=""></span><?=$categories[$i]['title_plural']?>
                        </a>
                       <?}?>
                      </div>
                    </div>*/?>

                    <a href="<?=$CCpu -> writelink(74)?>">
                        <div class="consulting__wrapper__box">
                            <div class="consulting__wrapper__box__btn red">
                                <?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATSA_K_SPETIALISTU']?>
                            </div>
                        </div>
                    </a>
                  </div>
                </div>
              </section>
                <section class="diagnostic">
                	<a href="/pages/index.php" id="uzi" aria-label="UZI" ></a>
                    <?$ult_cat = $Db -> getall("SELECT id,active_image,non_active_image,title__ AS title FROM ws_ultrasound WHERE active = 1 ORDER BY sort,id DESC");?>
                <div class="container">
                  <div class="diagnostic__wrapper">
                    <div class="diagnostic__wrapper__box">
                      <div class="diagnostic__wrapper__box__item">
                        <div class="diagnostic__wrapper__box__item__title blue_h3"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_UZI_DIAGNOSTIKA']?></div>
                        <div class="diagnostic__wrapper__box__item__subtitle"><?=count($ult_cat)?> <?=$GLOBALS['ar_define_langterms']['MSG_ALL_VIDOV']?></div>
                      </div>
                      <div class="diagnostic__wrapper__box__item">
                        <div class="diagnostic__wrapper__box__item__descr"><?=$Main->GetPageIncData('TEXT_UZI' , $CCpu->lang)?></div>
                      </div>
                    </div>
                    <div class="diagnostic__det">
                      <div class="diagnostic__det__title"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_VIDI_UZI']?></div>
                      <div class="slider_btns">
                        <div class="swiper-button-prev prev2"></div>
                        <div class="swiper-pagination pag2"></div>
                        <div class="swiper-button-next next2"></div>
                      </div>
                    <?/* ----------------------------------------------------------------------------------------------------------------------------------------------------- */?>
                      <div class="swiper diagnostic_slider">
                        <div class="swiper-wrapper">
                            <?foreach($ult_cat as $key => $cat){?>
                          <div class="swiper-slide">
                            <div class="det__wrapper">
                              <div class="det__wrapper__img <?if($key == 0){?> det-active <?}?>">
                                <img class="hover_off lozad <?if($key == 0){?> hover-off-active  <?}?>" src="<?=$lozad?>" data-src="/upload/ultrasound/<?=$cat['non_active_image']?>" alt="">
                                <img class="hover lozad <?if($key == 0){?> hover-active  <?}?>" src="<?=$lozad?>" data-src="/upload/ultrasound/<?=$cat['active_image']?>" alt="">
                              </div>
                              <div class="det__wrapper__title <?if($key == 0){?> det-active-title<?}?>">
                                <?=$cat['title']?>
                              </div>
                            </div>
                          </div>
                          <?}?>
                        </div>
                      </div>
                    <!-- ----------------------------------------------------------------------------------------------------------------------------------------------------- -->
                    <?foreach($ult_cat as $key => $subcat){?>
                      <div class="diagnostic__info <?if ($key == 0){?> diagnostic-info-show <?}?> desktop_diagnostic" >
                        <div class="diagnostic__info__arrow">
                          <img src="<?=$lozad?>" data-src="/icons/arrow-details-up.svg" alt="arrow up" class="lozad">
                        </div>
                        <div class="diagnostic__info__box">
                          <ul class="diagnostic__info__box__menu">
                            <?$ult_sub_cat = $Db -> getall("SELECT id,title__ AS title,text__ AS text FROM ws_ultrasound_elements WHERE section_id = ".$subcat['id']." AND active = 1 ORDER BY sort,id DESC");
                            foreach ($ult_sub_cat AS $k=>$data){?>
                                <li class="diagnostic__info__box__menu__item <?if ($k == 0){?> diagnostic-item-active <?}?>"><?=$data['title']?><span class="arrow_diagnostic <?if ($k == 0){?> arrow-active-diagnostic <?}?>"><img src="/icons/arrow-detail-right.svg" alt=""></span></li>
                            <? } ?>
                          </ul>
                        </div>
                        <?foreach ($ult_sub_cat AS $k=>$subdata)  {?>
                            <div class="diagnostic__info__box tab_diagnostic <?if ($k == 0){?> diagnostic-show <?}?>">
                          <div class="diagnostic__info__box__title"><?=$subdata['title']?></div>
                          <div class="diagnostic__info__box__descr"><?=$subdata['text']?>
                          </div>
									<?php if ($subcat[id] =="29") { ?>
									
									<a href="<?=$CCpu -> writelink(74)."?category=53"?>">
                          	
                            <div class="diagnostic__info__box__btn red"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATSA_NA_PRIOM']?></div>
                          </a>
									<?php } else { ?>
									
									<a href="<?=$CCpu -> writelink(74)."?category=38"?>">
                          	
                            <div class="diagnostic__info__box__btn red"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATSA_NA_PRIOM']?></div>
                          </a>	
						<? } ?>
                        </div>
                        <?}?>
                      </div>
                      <?}?>
                      <?foreach($ult_cat as $key => $subcat){?>
                      <div class="diagnostic__info__mobile <?if ($key == 0){?> diagnostic-info-show <?}?>">
                        <div class="diagnostic__info__arrow">
                          <img class="lozad" src="<?=$lozad?>" data-src="/icons/arrow-details-up.svg" alt="arrow up">
                        </div>
                        <div class="diagnostic__info__box__mobile">
                          <ul class="diagnostic__info__box__menu__mobile">
                            <?$ult_sub_cat = $Db -> getall("SELECT id,title__ AS title,text__ AS text FROM ws_ultrasound_elements WHERE section_id = ".$subcat['id']." AND active = 1 ORDER BY sort,id DESC");
                            foreach ($ult_sub_cat AS $k=>$data){?>
                                <li class="diagnostic__info__box__menu__item__mobile"><?=$data['title']?><span><img src="<?=$lozad?>" class="lozad" data-src="/icons/arrow-detail-right.svg" alt="arrow right"></span></li>
                                <div class="diagnostic__info__details__box__mobile">
                                    <div class="diagnostic__info__box__descr"><?=$data['text']?></div>
                                    		<?php if ($subcat[id] =="29") { ?>
									<a href="<?=$CCpu -> writelink(74)."?category=53"?>">
                            <div class="diagnostic__info__box__btn red"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATSA_NA_PRIOM']?></div>
                          			</a>
									<?php } else { ?>
									<a href="<?=$CCpu -> writelink(74)."?category=38"?>">
                            <div class="diagnostic__info__box__btn red"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATSA_NA_PRIOM']?></div>
                          </a>
									<? } ?>
                                </div>
                            <? } ?>
                          </ul>
                        </div>
                      </div>
                      <?}?>
                    </div>
                  </div>
                </div>
              </section>
              <a href="/pages/index.php" id ="banner-med" aria-label="Banner"></a>
                <section  class="banners">
                    <?$first_banner = $Db -> getone("SELECT image,title__ AS title,text__ AS text FROM ws_banners WHERE id = 4");
                    $second_banner = $Db -> getone("SELECT image,title__ AS title,text__ AS text,pre_title__ AS pre_title FROM ws_banners WHERE id = 5");?>
                <div class="container">
                  <div class="banners__wrapper">
                    <div class="banners__wrapper__box">
                      <a onclick="window.open(this.href,'_blank'); return false;" href="https://alfalab.md/analize-medicale">
                        <div class="bg-hand">
                            <img src="<?=$lozad?>" class="lozad" data-src="/upload/banners/<?=$first_banner['image']?>" alt="hand">
                        </div>
                      <div class="banners__wrapper__box__logo">
                        <img src="<?=$lozad?>" class="lozad" data-src="/icons/log-diagnostic.svg" alt="diagnostic logo">
                      </div>
                      </a>
                      <div class="banners__wrapper__box__title"><?=$first_banner['title']?></div>
                      <div class="banners__wrapper__box__descr"><?=$first_banner['text']?></div>
                      <a href="https://alfalab.md/analize-medicale" target="_new">
                        <div class="banners__wrapper__box__btn white"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_PEREITI_NA_NASH_SAIT']?></div>
                      </a>
                    </div>
                   <div class="banners__wrapper__box">
                      <div class="bg-hand">
                        <img src="<?=$lozad?>" class="lozad" data-src="/upload/banners/<?=$second_banner['image']?>" alt="complex">
                      </div>
                      <div class="banners__wrapper__box__pretitle"><?=$second_banner['pre_title']?></div>
                      <div class="banners__wrapper__box__slogan"><?=$second_banner['title']?></div>
                      <div class="banners__wrapper__box__info"><?=$second_banner['text']?></div>
                      <a href="<?=$CCpu -> writelink(87)?>"><div class="banners__wrapper__box__button red"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_STATI_CORP_CLIENTOM']?></div></a>
                    </div>
                  </div>
                </div>
              </section>
                <aid ="services"><section class="service"></a>
                    <?$insurance_info = $Db->getone("SELECT title__ AS title,preview__ AS preview,text__ AS text FROM `ws_insurance` WHERE `active` = 1");
                    $insurance_photos = $Db -> getall("SELECT image,link FROM ws_insurance_photos WHERE active = 1");?>
                <div class="container">
                  <div class="service__wrapper">
                    <div class="service__wrapper__box">
                      <div class="service__wrapper__box__title">
                        <?=$insurance_info['title']?>
                      </div>
                      <div class="service__wrapper__box__subtitle">
                        <?=$insurance_info['preview']?>
                      </div>
                      <div class="service__wrapper__box__partners sus ">
                        <?foreach($insurance_photos as $k => $photo){?>
                            <a1 class="pad" onclick="window.open(this.href,'_blank'); return false;" href="<?=$photo['link']?>">
                            <div class="service__wrapper__box__partners__img">
                                <img src="<?=$lozad?>" class="lozad" data-src="/upload/insurance_photos/<?=$photo['image']?>" alt="grawe">
                            </div>
                          </a1>
                        <?}?>
                      </div>
                    </div>
                    <div class="service__wrapper__box">
                      <div class="service__wrapper__box__descr">
                        <?=$insurance_info['text']?>
                      </div>
                      <a href="<?=$CCpu -> writelink(74)?>">
                        <div class="service__wrapper__box__btn red"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATSA_NA_PRIOM']?></div>
                      </a>
                    </div>
                  </div>
                </div>
              </section>
                <ahref="/pages/index.php" id="news"><section class="news"></a>
                    <?$journals = $Db->getall( "SELECT id,image,`date`,title__ AS title,preview__ AS preview  FROM `ws_journals` WHERE `active` = 1 ORDER BY date DESC "); ?>
                    <?$news = $Db->getall( "SELECT id,image,`date`,title__ AS title,preview__ AS preview FROM `ws_news` WHERE `active` = 1 ORDER BY date DESC "); ?>
                    <div class="container">
                        <div class="news__wrapper">
                            <div class="news__wrapper__title">
                              <?=$GLOBALS['ar_define_langterms']['MSG_ALL_JURNAL']?> <?=$GLOBALS['ar_define_langterms']['MSG_ALL_AND']?> <?=$GLOBALS['ar_define_langterms']['MSG_ALL_NOVOSTI']?>
                            </div>
                            <div class="news__wrapper__box">
                                  <div class="news__wrapper__box__tabs">
                                        <div class="news__wrapper__box__tabs__item tab-news-active"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_JURNAL']?></div>
                                        <div class="news__wrapper__box__tabs__item"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_NOVOSTI']?></div>
                                  </div>
                                  <div class="slider_btns slider_btns_news journal_slider_btn journal-slider-active">
                                        <div class="swiper-button-prev prev13"></div>
                                        <div class="swiper-pagination pag13"></div>
                                        <div class="swiper-button-next next13"></div>
                                  </div>
                                  <div class="slider_btns slider_btns_news news_slider_btn">
                                        <div class="swiper-button-prev prev14"></div>
                                        <div class="swiper-pagination pag14"></div>
                                        <div class="swiper-button-next next14"></div>
                                  </div>
                            </div>
                            <div class="news__wrapper__box">
                                <div class="swiper news_carousel news_carousel1 news-active">
                                    <div class="swiper-wrapper">
                                    <?foreach($journals as $key => $journal){
                                        $day = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_days WHERE day_code = '".date('D',strtotime($journal['date']))."'");
                                        $month = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_months WHERE id = '".date('m',strtotime($journal['date']))."'"); ?>
                                          <div class="swiper-slide">
                                              <div class="news__slider">
                                                  <a href="<?=$CCpu -> writelink(82,$journal['id'])?>">
                                                      <div class="news__slider__box">
                                                          <img src="<?=$lozad?>" data-src="/upload/journals/<?=$journal['image']?>" class="lozad" alt="<?=$journal['title']?>">
                                                      </div>
                                                      <div class="news__slider__box">
                                                          <div class="news__slider__box__content">
                                                              <div class="news__slider__box__content__data">
                                                                    <?=$day['title']?>,
                                                                    <?=date('d',strtotime($journal['date']))?>
                                                                    <?=$month['title']?>
                                                                    <?=date('Y',strtotime($journal['date']))?>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </a>
                                                  <div class="news__slider__box__content__social">
                                                      <div id="news__slider__box__content__social__item__facebook">
                                                          <img src="<?=$lozad?>" class="lozad" data-src="/icons/facebook.svg" alt="facebook">
                                                      </div>
                                                      <div id="news__slider__box__content__social__item__twitter">
                                                          <img src="<?=$lozad?>" class="lozad" data-src="/icons/twitter.svg" alt="twitter">
                                                      </div>
                                                  </div>
                                              </div>
                                              <a class="details__page__link" href="<?=$CCpu -> writelink(82,$journal['id'])?>">
                                                  <div class="news__slider__box">
                                                      <h3><?=$journal['title']?></h3>
                                                      <?=$journal['preview']?>
                                                  </div>
                                              </a>
                                        </div>
                                    <?}?>
                                    </div>
                                </div>
                                <div class="swiper news_carousel news_carousel2">
                                    <div class="swiper-wrapper">
                                        <?foreach($news as $key => $news_article){
                                        $day = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_days WHERE day_code = '".date('D',strtotime($news_article['date']))."'");
                                        $month = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_months WHERE id = '".date('m',strtotime($news_article['date']))."'");
                                        ?>
                                        <div class="swiper-slide">
                                            <div class="news__slider">
                                                <a href="<?=$CCpu -> writelink(81,$news_article['id'])?>">
                                                    <div class="news__slider__box">
                                                        <img src="<?=$lozad?>" class="lozad" data-src="/upload/news/<?=$news_article['image']?>" alt="<?=$news_article['title']?>">
                                                    </div>
                                                    <div class="news__slider__box">
                                                        <div class="news__slider__box__content">
                                                            <div class="news__slider__box__content__data">
                                                                <?=$day['title']?>,
                                                                <?=date('d',strtotime($news_article['date']))?>
                                                                <?=$month['title']?>
                                                                <?=date('Y',strtotime($news_article['date']))?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="news__slider__box__content__social">
                                                    <div id="news__slider__box__content__social__item__facebook"
                                                         onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + location.href + <?=$CCpu -> writelink(81,$news_article['id'])?>,
                                                                 'facebook-share-dialog',
                                                                 'width=800,height=600');return false;" >
                                                        <img class="lozad" src="<?=$lozad?>" data-src="/icons/facebook.svg" alt="facebook">
                                                    </div>
                                                    <div id="news__slider__box__content__social__item__twitter"
                                                         onclick="window.open('http://twitter.com/share?url=' + location.href + <?=$CCpu -> writelink(81,$news_article['id'])?>,);return false;">
                                                        <img class="lozad" src="<?=$lozad?>" data-src="/icons/twitter.svg" alt="twitter">
                                                    </div>
                                                </div>
                                            </div>
                                            <a class="details__page__link" href="<?=$CCpu -> writelink(81,$news_article['id'])?>">
                                                <div class="news__slider__box">
                                                    <h3><?=$news_article['title']?></h3>
                                                    <?=$news_article['preview']?>
                                                </div>
                                            </a>
                                        </div>
                                    <?}?>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="news__wrapper__box">
                            <a class="news__wrapper__box__link link-button-active" href="<?=$CCpu -> writelink(85)?>">
                                <?=$GLOBALS['ar_define_langterms']['MSG_ALL_PEREITI_K_JURNALAM']?> <span><img src="<?=$lozad?>" class="lozad" data-src="/icons/big-arrow-right.svg" alt="arrow right"></span>
                            </a>
                            <a class="news__wrapper__box__link" href="<?=$CCpu -> writelink(86)?>">
                                <?=$GLOBALS['ar_define_langterms']['MSG_ALL_PEREITI_K_NOVOSTEAM']?> <span><img src="<?=$lozad?>" class="lozad" data-src="/icons/big-arrow-right.svg" alt="arrow right"></span>
                            </a>
                        </div>
                    </div>
              </section>
            </main>
                <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
        </div>
    <script>
        <?include($_SERVER['DOCUMENT_ROOT'].'/js/index.js')?>
    </script>
	</body>
</html>