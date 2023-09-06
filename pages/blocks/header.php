<header class="header" id="scrolltoheader">

      <div class="mob_logo">
      	<a href="<?=$CCpu->writelink(1)?>">
      		<img class="logo lozad" src="<?=$lozad?>" data-src="/images/logo.svg" alt="logo">
      	</a>
      </div>
      <nav class="nav__wrapper">
      <div class="container__header">
          <div class="nav__wrapper__box">
            <div class="nav__wrapper__box__pretitle"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_MNOGOPROFILINAIA_KLINIKA']?></div>
          
            <div class="nav__wrapper__box__menu">
              <div class="nav__wrapper__box__menu__item">
                <a class="nav__wrapper__box__menu__item__link" href="<?=$CCpu -> writelink(73)?>"><?=$CCpu -> writetitle(73)?> </a>
              </div>
              <div class="nav__wrapper__box__menu__item">
                <a class="nav__wrapper__box__menu__item__link" href="<?=$CCpu -> writelink(80)?>"><?=$CCpu -> writetitle(80)?> </a>
              </div>
              <div class="nav__wrapper__box__menu__item">
                <a class="nav__wrapper__box__menu__item__link" href="<?=$CCpu -> writelink(83)?>"><?=$CCpu -> writetitle(83)?> </a>
              </div>
            </div>
          </div>
          <?$LangUrls = $CCpu->getURLs($pageData['page_id'], $pageData['elem_id']);?>
          <div class="nav__wrapper__box">
          	<a href="<?=$LangUrls['ro']?>">
          		<div class="nav__wrapper__box__lang <?if($pageData['lang'] == "ro"){echo "lang-active";}?>">Ro</div>
          	</a>
          	<a href="<?=$LangUrls['ru']?>">
          		<div class="nav__wrapper__box__lang <?if($pageData['lang'] == "ru"){echo "lang-active";}?>">Рус</div>
          	</a>
          </div>
      </div>
      
      <div class="header__mini">
        <div class="menu-btn">
          <i class="fa fa-bars"></i>
        </div>
        <div class="menu">
          <div class="header__wrapper__box">
            <a class="header__wrapper__box__logo" href="<?=$CCpu -> writelink(1)?>">
              <img class="logo lozad" data-src="/images/logo.svg" src="<?=$lozad?>" alt="logo">
            </a>
          </div>
          <div class="header__wrapper__box">
            <div class="header__wrapper__box__btns">
            	<a href="<?=$CCpu -> writelink(74);?>">
              		<div class="header__wrapper__box__btns__select white"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_VIBRATI_VRACIA']?></div>
              	</a>
	              <div class="header__wrapper__box__btns__search">
	                <form action="<?=$CCpu -> writelink(74);?>">
	                <input class="search search_inp" id="search_input_mobile" type="text" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_ALL_POISK_PO_SPECIALINOSTI']?>" name="search">
	                <button type="submit" class="header__search__btn__mobile"><span><img style="top: 27px;" class="search_icons lozad" src="<?=$lozad?>" data-src="/icons/Search.svg" alt="search"></span></button>
	                	<div class="autocomplete_mobile">
					        <ul class="search-list_mobile">
													
																					
							</ul>
					    </div>
				</form>
	              </div>
              </div>
          </div>
          <div class="header__wrapper__box nav-show-call">
            <a class="header__wrapper__box__call red" href="javascript:void(0)" onclick="show_popup('request_call_popup')"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAKAZATI_ZVONOK']?></a>
          </div>
          <a class="header__wrapper__box__phone" href="tel:<?=$GLOBALS['ar_define_settings']['TEL_CONTACT']?>">
            <span><img class="phone lozad" src="<?=$lozad?>" data-src="/icons/phone.svg" alt="phone"></span> <span><?=$GLOBALS['ar_define_settings']['TEL_CONTACT']?></span>
          </a>
          <div class="header__wrapper__box__messenger"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_MESENGERI']?> <span><img class="arrow lozad" src="<?=$lozad?>" data-src="/icons/arrow-white.svg" alt=""></span>
          	
          </div>
          <div class="header__wrapper__box__messenger__items__list__mobile" style="display: none;">
          			<a class="contacts__wrapper__box__socials__item__mobile" href="<?=$GLOBALS['ar_define_settings']['VIBER']?>">
                     	<img src="<?=$lozad?>" class="lozad" data-src="/icons/viber.svg" alt="viber" >
                    </a>
                    <a class="contacts__wrapper__box__socials__item__mobile" href="<?=$GLOBALS['ar_define_settings']['WHATSAPP']?>">
                       <img src="<?=$lozad?>" class="lozad" data-src="/icons/whatsapp.svg" alt="whatsapp" >
					</a>
                    <a class="contacts__wrapper__box__socials__item__mobile" href="<?=$GLOBALS['ar_define_settings']['TELEGRAM']?>">
                       <img src="<?=$lozad?>" class="lozad" data-src="/icons/telegram.svg" alt="telegram" >
                    </a>
          </div>
          <div class="nav__wrapper__box lang_box_mini">
            <div class="nav__wrapper__box__lang">Ro</div>
            <div class="nav__wrapper__box__lang lang-active">Рус</div>
          </div>
        </div>
       
      </div>
    </nav>

      <div class="header__wrapper">
      <div class="container__header">
          <div class="header__wrapper__box">
            <a class="header__wrapper__box__logo" href="<?=$CCpu -> writelink(1)?>">
              <img class="logo lozad" src="<?=$lozad?>" data-src="/images/logo.svg" alt="logo">
            </a>
          </div>
          <div class="header__wrapper__box">
            <div class="header__wrapper__box__btns">
            <a href="<?=$CCpu -> writelink(74)?>">
              	<div class="header__wrapper__box__btns__select white"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_VIBRATI_VRACIA']?></div>
              </a>
              <div class="header__wrapper__box__btns__search">
              	<form action="<?=$CCpu -> writelink(74);?>">
	                <input class="search search_inp" id="search_input" type="text" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_ALL_POISK_PO_SPECIALINOSTI']?>" name="search">
	                <button type="submit" class="header__search__btn"><span><img style="top: 27px;" class="search_icons lozad" src="<?=$lozad?>" data-src="/icons/Search.svg" alt="search"></span></button>
	                	<div class="autocomplete" id="header-autocomplete">
					        <ul class="search-list">
													
																					
							</ul>
					    </div>
				</form>
              </div>
              </div>
          </div>
          <div class="header__wrapper__box">
            <a class="header__wrapper__box__phone" href="tel:<?=$GLOBALS['ar_define_settings']['TEL_CONTACT']?>">
              <span><img class="phone lozad" src="<?=$lozad?>" data-src="/icons/phone.svg" alt="phone"></span> <span><?=$GLOBALS['ar_define_settings']['TEL_CONTACT']?></span>
            </a>
            <div class="header__wrapper__box__messenger"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_MESENGERI']?> <span><img class="arrow lozad" src="<?=$lozad?>" data-src="/icons/arrow-down.svg" alt=""></span>
            	<div class="header__wrapper__box__messenger__items__list" style="display: none;">
          			<a class="contacts__wrapper__box__socials__item" href="<?=$GLOBALS['ar_define_settings']['VIBER']?>">
                     	<img class="lozad" src="<?=$lozad?>" data-src="/icons/viber.svg" alt="viber">
                    </a>
                    <a class="contacts__wrapper__box__socials__item" href="<?=$GLOBALS['ar_define_settings']['WHATSAPP']?>">
                       <img class="lozad" src="<?=$lozad?>" data-src="/icons/whatsapp.svg" alt="whatsapp">
					</a>
                    <a class="contacts__wrapper__box__socials__item" href="<?=$GLOBALS['ar_define_settings']['TELEGRAM']?>">
                       <img class="lozad" src="<?=$lozad?>" data-src="/icons/telegram.svg" alt="telegram">
                    </a>
          		</div>
            </div>
          </div>
          <div class="header__wrapper__box">
            <a class="header__wrapper__box__call red" href="javascript:void(0)" onclick="show_popup('request_call_popup')"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAKAZATI_ZVONOK']?></a>
          </div>
        </div>
      </div>
    </header>