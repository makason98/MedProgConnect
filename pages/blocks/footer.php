
            <footer class="footer">

      <div class="wrapper first_footer">

        <div class="container">
        	
          <div class="first_footer__wrapper">
            <div class="wrapper__box">
              <div class="wrapper__box__logo"><img class="lozad" src="<?=$lozad?>" data-src="/images/logo.svg" alt="logo"></div>
              <div class="wrapper__box__descr"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_SETI_KLINIK']?></div>
            </div>
            <div class="wrapper__box">
              <ul class="wrapper__box__list">
                <li class="wrapper__box__list__item"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_MENIU']?></li>
                <li class="wrapper__box__list__item"><a href="<?=$CCpu -> writelink(73)?>"><?=$CCpu -> writetitle(73)?></a></li>
                <li class="wrapper__box__list__item"><a href="<?=$CCpu -> writelink(74)?>"><?=$CCpu -> writetitle(74)?></a></li>
                <li class="wrapper__box__list__item"><a href="<?=$CCpu -> writelink(80)?>"><?=$CCpu -> writetitle(80)?></a></li>
                <li class="wrapper__box__list__item"><a href="<?=$CCpu -> writelink(83)?>"><?=$CCpu -> writetitle(83)?></a></li>
                <li class="wrapper__box__list__item"><a href="<?=$CCpu -> writelink(86)?>"><?=$CCpu -> writetitle(86)?></a></li>
              </ul>
              <ul class="wrapper__box__list">
                <li class="wrapper__box__list__item"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_INFORTMATSIA']?></li>
                <li class="wrapper__box__list__item"><a href="<?=$CCpu -> writelink(78)?>"><?=$CCpu -> writetitle(78)?></a></li>
                <li class="wrapper__box__list__item"><a href="<?=$CCpu -> writelink(79)?>"><?=$CCpu -> writetitle(79)?></a></li>
                <li class="wrapper__box__list__item"><a href="<?=$CCpu -> writelink(87)?>"><?=$CCpu -> writetitle(87)?></a></li>
              </ul>
              <div class="wrapper__box__contacts">
                <div class="wrapper__box__contacts__contact"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_KONTAKTI']?>
                </div>
                <div class="wrapper__box__contacts__phone">
                  <a href="tel:<?=$GLOBALS['ar_define_settings']['TEL_CONTACT']?>"><?=$GLOBALS['ar_define_settings']['TEL_CONTACT']?></a>
                </div>
                <div class="wrapper__box__contacts__social">
                  <?=$GLOBALS['ar_define_langterms']['MSG_ALL_SOTS_SETI']?>
                </div>
                <div class="wrapper__box__contacts__icons">
                  <a  href="<?=$GLOBALS['ar_define_settings']['INSTAGRAM_LINK']?>" target="_blank"><img class="lozad" src="<?=$lozad?>" data-src="/icons/instagram-black.svg" alt="instagram"></a>
                  <a  href="<?=$GLOBALS['ar_define_settings']['FACEBOOK_LINK']?>" target="_blank"><img class="lozad" src="<?=$lozad?>" data-src="/icons/facebook-black.svg" alt="facebook"></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="second_footer">

        <div class="container">
          <div class="wrapper wrapper_footer">
            <div class="wrapper__descr"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_MNENIE_O_KACESTVE']?></div>
           <a href="javascript:void(0)" onclick="show_popup('feedback_popup')"> 
           	<div class="wrapper__btn red">
            		<?=$GLOBALS['ar_define_langterms']['MSG_ALL_NAPISATI_NAM']?>
            	</div>
            	</a>
          </div>
	          <div class="popup_place"></div>
			<div class="popup_shadow"></div>
			<button id="scroll_up"><img src="<?=$lozad?>" data-src="/icons/scroll-up.svg" class="lozad"></button>
			<?if($_COOKIE['cookie_alert'] == 0){?>
			<div class="cookie__popup">
				<div class="cookie__popup__title">
					<?=$GLOBALS['ar_define_langterms']['MSG_ALL_COOKIE_TITLE']?>
				</div>
				<div class="cookie__popup__text">
					<?=$Main->GetPageIncData('TEXT_COOKIE' , $CCpu->lang)?>
				</div>
				<div class="cookie__popup__btns">
					<div class="cookie__popup__btn__accept white">
						<?=$GLOBALS['ar_define_langterms']['MSG_ALL_PRINIMAIU']?>
					</div>
					<div class="cookie__popup__btn__decline white">
						<?=$GLOBALS['ar_define_langterms']['MSG_ALL_NE_PRINIMAIU']?>
					</div>
				</div>
			</div>
			<?}?>
        </div>
      </div>
      <div class="third_footer">
        
        <div class="container">
          <div class="wrapper wrapper_footer">
            <div class="wrapper__copyright"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_COPYRIGHT']?>
            </div>
           <a <?if($pageData['page_id'] == 1){?>onclick="window.open(this.href,'_blank'); return false;" href="https://webmaster.md/"<?}?>>
           	<div class="wrapper__author">
              <div class="wrapper__author__develop">develop by </div>
              <div class="wrapper__author__studio">Studio WebMaster, 2022</div>
              <img src="<?=$lozad?>" class="lozad" data-src="/images/copyright.svg" alt="webmaster_studio">
            </div>
           </a>
          </div>
      </div>
			
    </footer>
        </div>

            <script>
                <?include($_SERVER['DOCUMENT_ROOT'].'/lib/jquery/jquery.2.2.2.js')?>
                <?include($_SERVER['DOCUMENT_ROOT'].'/js/blocks.js')?>
                <?include($_SERVER['DOCUMENT_ROOT'].'/js/l-load.js')?>
            </script>
            <link rel="preload" as="script" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.min.js">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.min.js"></script>
            <script>
                var ajax_path = '<?=$CCpu->writelink(3)?>';
                var err_msg = '<?=$GLOBALS['ar_define_langterms']['MSG_ALL_CTOTO_POSHLO_NE_TAK']?>';
                <?include($_SERVER['DOCUMENT_ROOT'].'/js/main.js')?>
                <?include($_SERVER['DOCUMENT_ROOT'].'/js/footer.js')?>
            </script>



    

