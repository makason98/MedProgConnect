<!DOCTYPE html>
<html lang="<?=$CCpu->lang?>" class="page">

<head>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>

<body class="page__body" id="body">
	<div class="wrapper">
        <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
	<main class="main">

			<?$doctor = $Db -> getone("SELECT * FROM ws_doctors WHERE id = ".$pageData['elem_id']." ");
              $patient_type = $Db -> getone("SELECT * FROM ws_patient_type WHERE id = ".$doctor['patient_type_id']." ");
              $patient_type_icons = $Db -> getall("SELECT id,image FROM ws_patient_type WHERE id IN(3,4)");
              $office = $Db -> getone("SELECT city_".$CCpu -> lang." as city, address_".$CCpu -> lang." as address,client_system_id FROM ws_offices 
              INNER JOIN ws_doc_offices_link ON ws_offices.id = ws_doc_offices_link.office_id 
              INNER JOIN ws_doctors ON ws_doc_offices_link.doctor_id = ws_doctors.id WHERE ws_doctors.id = ".$doctor['id']." ");
              $category = $Db -> getone("SELECT * FROM ws_category WHERE id = ".$doctor['section_id']." ");
              $services = $Db -> getall("SELECT * FROM ws_doc_services WHERE doctor_id = ".$doctor['id']." ORDER BY sort DESC")?>

        <?$post = array('task'=>'get_times','filial_id'=>$office['client_system_id'],'doc_login'=>$doctor['doc_login']);
        $ReqString = json_encode($post);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://87.255.69.40:7100/alfalab_api/alfalab.svc/getMedicFreeTimeByMedicId/'.$doctor['doc_login'].'/'.$office['client_system_id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => $ReqString,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic aHR0cDpxd2UxMjM=',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        $array = json_decode(json_encode((array)simplexml_load_string($response)),true);
        $responseData = json_decode($array[0],true);
        /* тут пересобираем массив в нужный формат */

        foreach ($responseData AS $k => $row) {
            $date[$k] = strtotime($row['Date']);
        }
        array_multisort($date, SORT_ASC, $responseData);

        $freeTimes = array();
        foreach ($responseData AS $k=>$resval){
            $restructureArr[$resval['Date']]['doc'] = $resval['MedicId'];
            $restructureArr[$resval['Date']]['venue'] = $resval['VenueId'];
            $restructureArr[$resval['Date']]['date'] = $resval['Date'];
            $restructureArr[$resval['Date']]['time'][] = $resval['Time'].'-'.$resval['isFreeTime'];
            $dateArr = explode('.',$resval['Date']);
            $monthYear = $dateArr[1].'.'.$dateArr[2];
            $monthsYears[] = $monthYear;
            if ($resval['isFreeTime'] == '1'){
                $freeTimes[] = $resval['Date'].';'.$resval['Time'];
            }
        }

        ?>
				
            <section class="crumbs">
                <div class="container">
                    <div class="crumbs__wrapper">
                        <a class="crumbs__wrapper__item" href="<?=$CCpu -> writelink(1)?>"><?=$CCpu -> writetitle(1)?></a>
                        <div class="crumbs__wrapper__separator"><img src="/icons/arrow-crumbs.svg" alt=""></div>
                        <a class="crumbs__wrapper__item" href="<?=$CCpu -> writelink(74)?>"><?=$CCpu -> writetitle(74)?></a>
                        <div class="crumbs__wrapper__separator"><img src="/icons/arrow-crumbs.svg" alt=""></div>
                        <a class="crumbs__wrapper__item crumbs-active" href=""><?=$doctor['last_name_'.$CCpu->lang]." ".$doctor['first_name_'.$CCpu->lang]?></a>
                    </div>
                </div>
            </section>
            
            <section class="infodoc">
                <div class="container">
                	
                    <div class="infodoc__wrapper">
                        <div class="infodoc__wrapper__box">
                            <div class="infodoc__wrapper__box__img">
                                <img src="<?=$lozad?>" class="lozad" data-src="/upload/doctors/<?=$doctor['image']?>" alt="<?=$doctor['last_name_'.$CCpu->lang]." ".$doctor['first_name_'.$CCpu->lang]?>">
                            </div>
                        </div>
                        <div class="infodoc__wrapper__box">
                            <div class="infodoc__wrapper__box__item">
                                <div class="infodoc__wrapper__box__item__content"><?if($patient_type['id'] == 5){
                                	foreach($patient_type_icons as $key => $icons){?>
                                		<span>
                                			<img src="<?=$lozad?>" class="lozad" data-src="/upload/patient_type/<?=$icons['image']?>" alt="<?=$icons['image']?>">
                                		</span>
                                	<?}
                                }else{?>
                                	<span>
                                		<img src="/upload/patient_type/<?=$patient_type['image']?>" alt=""><?}?>
                                	</span><?=$patient_type['title_'.$CCpu -> lang]?></div>
                                <a class="infodoc__wrapper__box__item__content" href="<?=$CCpu -> writelink(74)."?category=".$category['id']?>"><?=$category['title_plural_'.$CCpu -> lang]?><span><img
                                            src="/upload/category/<?=$category['doc_block_icon']?>" alt=""></span></a>
                            </div>
                            <div class="infodoc__wrapper__box__item">
                                <div class="infodoc__wrapper__box__item__name"><?=$doctor['last_name_'.$CCpu->lang]." ".$doctor['first_name_'.$CCpu->lang]?></div>
                                <div class="infodoc__wrapper__box__item__info">
                                    <div class="infodoc__wrapper__box__item__info__speciality">
                                        <?=$category['title_'.$CCpu -> lang]?>
                                    </div>
                                </div>
                            </div>
                            <div class="infodoc__wrapper__box__item">
                                <div class="infodoc__wrapper__box__item__about">
                                    <div class="infodoc__wrapper__box__item__about__experience"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_STAJ']?> <?=$doctor['experience_'.$CCpu->lang]?>
                                        <span></span> <?=$doctor['education_'.$CCpu->lang]?> <span></span> <?=$doctor['academic_degree_'.$CCpu->lang]?> </div>
                                    <div class="infodoc__wrapper__box__item__info__share">
                                        <?=$GLOBALS['ar_define_langterms']['MSG_ALL_PODELITSA']?> <span><img src="/icons/share.svg" alt="share"></span>
                                        <span class="social_links"><img id="details__page__facebook" src="/icons/facebook.svg" alt="facebook"></span>
		                                <span class="social_links"><img id="details__page__twitter" src="/icons/twitter.svg" alt="twitter"></span>
		                                <span class="social_links"><img id="details__page__linked-in" style="max-height: 20px; max-width: 20px;" src="/icons/linked-in.svg" alt="linked-in"></span>
		                                <span class="social_links"><img id="details__page__vk" src="/icons/vk.png" alt="vk"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="cost">
                <div class="container">
                    <div class="cost__wrapper">
                        <div class="cost__wrapper__box">
                            <div class="cost__wrapper__box__menu">
                                <div class="cost__wrapper__box__menu__item"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_O_VRACHE']?></div>
                                <div class="cost__wrapper__box__menu__item cost-item-active"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_USLUGI_I_TSENI']?></div>
                                <div class="cost__wrapper__box__menu__item"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_PUBLIKATII']?></div>
                            </div>
                            <div class="cost__wrapper__box__services">
                                <div class="cost__wrapper__box__services__about">
                                    <?=$doctor['description_'.$CCpu -> lang]?>
                                </div>
                            </div>
                            <div class="cost__wrapper__box__services cost-services-show">
                                <ul class="cost__wrapper__box__services__menu">
                                	<?foreach($services as $k => $service){?>
                                    <li class="cost__wrapper__box__services__menu__item"><?=$service['title_'.$CCpu -> lang]?>
                                        <span <?if ($service['price_color'] != ''){?>style="color:<?=$service['price_color']?>"<?}?>><?if(strpos($service['price'],"mdl") != 0){?><?=$service['price']?><?}else{?> <?=$service['price']?> mdl<?}?></span></li>
                                        <?}?>
                                </ul>
                            </div>
                            <div class="cost__wrapper__box__services">
                                <div class="cost__wrapper__box__services__publications">
                                    <?=$doctor['publications_'.$CCpu -> lang]?>
                                </div>
                            </div>
                        </div>
                        <div class="cost__wrapper__box">
                            <div class="cost__wrapper__box__accept">
                                <?=$GLOBALS['ar_define_langterms']['MSG_ALL_VRACHI_PRINIMAET_V']?>
                            </div>
                            <div class="cost__wrapper__box__street">
                                <?=$office['city'].", ".$office['address']?>
                            </div>
                            <div class="cost__wrapper__box__hours">
                                <div class="cost__wrapper__box__hours__box">
                                    <div class="cost__wrapper__box__hours__box__work">
                                        <span><img src="/icons/attention.svg" alt=""></span>
                                        <?=$GLOBALS['ar_define_langterms']['MSG_ALL_CHASY_PRIEMA']?>:
                                    </div>
                                    <?foreach (explode(';',$doctor['appointment_hours_'.$CCpu->lang]) AS $k=>$val){?>
                                        <div class="cost__wrapper__box__hours__box__days">
                                            <?=$val?>
                                        </div>
                                    <?}?>
                                </div>
                                <div class="cost__wrapper__box__hours__box">
                                    <div class="cost__wrapper__box__hours__box__work">
                                        <?=$GLOBALS['ar_define_langterms']['MSG_ALL_BLIZHAJSHEE_SVOBODNOE_VREMYA']?>
                                    </div>
                                    <div class="cost__wrapper__box__hours__box__days days_red">
                                        <?$firstDay = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_days WHERE day_code = '".date('D',strtotime(explode(';',$freeTimes[0])[0]))."'");
                                        $firstMonth = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_months WHERE id = ".explode('.',$freeTimes[0])[1]." ")?>
                                        <?=$firstDay['title'].', '.explode('.',$freeTimes[0])[0].' '.$firstMonth['title'].', '.explode(';',$freeTimes[0])[1]?>
                                    </div>
                                    <div class="cost__wrapper__box__hours__box__days days_red">
                                        <?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATISYA_NA_ETO_VREMYA']?>
                                    </div>
                                    <a class="cost__arrow__right" href="javascript:void(0)" onclick="first_time_appointment('<?=implode('_',explode('.',$responseData[0]['Date']))?>','<?=implode('_',explode(':',$responseData[0]['Time']))?>','<?=$responseData[0]['VenueId']?>')">
                                        <img src="/icons/cost-arrow-right.svg" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="closest_time">
                            </div>
                            <div class="cost__wrapper__box__months">
                                <div class="swiper cost-carousel-months">
                                    <div class="swiper-wrapper">
                                        <?foreach(array_unique($monthsYears) AS $k=>$monthSlide){
                                            $monthSlideData = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_months WHERE id = ".explode('.',$monthSlide)[0]." ")?>
                                            <div class="swiper-slide"><div class="slide_month"><?=$monthSlideData['title']." ".explode('.',$monthSlide)[1]?></div></div>
                                        <?}?>
                                    </div>

                                    <div class="swiper-button-prev prev6"></div>
                                    <div class="swiper-button-next next6"></div>

                                  </div>
                            </div>
                            <div class="cost__wrapper__box__days">
                                <? $c = 0;
                                foreach (array_unique($monthsYears) AS $k=>$monthSlide_2) {
                                    $monthSlideData_2 = $Db -> getone("SELECT id,title_".$CCpu -> lang." as title FROM ws_months WHERE id = ".explode('.',$monthSlide_2)[0]." ");
                                    if(mb_strlen($monthSlideData_2['title'],'UTF-8') > 4){ $monthSlideData_2['title'] = mb_substr($monthSlideData_2['title'],0,3,'UTF-8').".";}?>
				                    <div class="swiper cost-carousel-days" <?if($c == 0){?>style="display: block;" <?}?>>
                                        <div class="swiper-wrapper">
                                            <?for($j = explode('.',$responseData[$k]['Date'])[0]; $j <= cal_days_in_month(CAL_GREGORIAN, explode('.',$monthSlide_2)[0], explode('.',$monthSlide_2)[1]); $j++ ){
                                                $full_date = strtotime($j."-".explode('.',$monthSlide_2)[0]."-".explode('.',$monthSlide_2)[1]);
                                                $day = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_days WHERE day_code = '".date('D',$full_date)."'")?>
                                                <div class="swiper-slide"><div class="slide_day slide_day_active" data-month-id="<?=$monthSlideData_2['id']?>"><?=$day['title']?> <span><?=(int)$j." ".$monthSlideData_2['title']?> </span></div></div>
                                            <?}?>
                                        </div>

				                        <div class="swiper-button-prev prev7"></div>
				                        <div class="swiper-button-next next7"></div>
				                    </div>


                                    <?for($j = explode('.',$responseData[$k]['Date'])[0]; $j <= cal_days_in_month(CAL_GREGORIAN, explode('.',$monthSlide_2)[0], explode('.',$monthSlide_2)[1]); $j++ ){

                                        $full_date = strtotime($j."-".explode('.',$monthSlide_2)[0]."-".explode('.',$monthSlide_2)[1]);?>
                                        <div class="modal__wrapper__days__hours">
                                            <? foreach ($restructureArr[date('d.m.Y',$full_date)]['time'] AS $k=>$t){
                                                $time = explode('-',$t)[0];
                                                $free = explode('-',$t)[1];?>
                                                <div class="modal__wrapper__days__hours__item <?if ((int)$free == 1){?>modal_hours_free<?}?>"
                                                     data-venue="<?=$restructureArr[date('d.m.Y',$full_date)]['venue']?>"
                                                     data-date="<?=date('Y_m_d',$full_date)?>"
                                                     data-time="<?=date('H_i',strtotime($time))?>">
                                                    <?=date('H:i',strtotime($time))?>
                                                </div>
                                            <?}?>
                                        </div>
                                    <?}
                                $c ++;}?>
                            </div>
                            <div class="cost__wrapper__box__timezone">
                                <?=$GLOBALS['ar_define_langterms']['MSG_ALL_CEASOVOI_POIAS']?>
                            </div>
                            
                            <div class="modal__wrap">
                            	
                            	
				            </div>
                        </div>
                    </div>
                </div>
            </section>
    </div>
    </section>


    </main>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
</div>


<script>

    function first_time_appointment(date,time,venue){
        $('.modal__wrap *').remove();
        $('.modal__wrap').removeClass('modal-wrap-active');
        $('.modal_hours_free').removeClass('modal-hour-active');
        $.ajax({
            type:'post',
            url:'<?=$CCpu->writelink(3)?>',
            data:{
                'task':'first_time_appointment_form',
                'doctor_id':'<?=$doctor['id']?>',
                'time':time,
                'date':date,
                'venue':venue,
            },
            success:function(msg){
                if ($.trim(msg) != ''){
                    $('.closest_time').html(msg);
                }else{
                    show('<?=$GLOBALS['ar_define_langterms']['MSG_ALL_CTOTO_POSHLO_NE_TAK']?>');
                }
            }
        })
    };
    
    $(".infodoc__wrapper__box__item__info__share").click( function() {
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
    	
		let day = document.querySelectorAll('.slide_day_active');
		for(let i = 0; i < day.length; i++){
		    day[i].addEventListener('click', function(){
		        for(let j = 0; j < day.length; j++){
		            day[j].classList.remove('slide-day-show');
		            $('.modal__wrapper__days__hours').eq(j).hide();
		        }
		        day[i].classList.add('slide-day-show');
		        $('.modal__wrapper__days__hours').eq(i).css('display', 'flex');
		    });
		};
		
		
		let modalForm = document.querySelector('.modal__wrap');
    	let costHour = document.querySelectorAll('.modal_hours_free');
	    for(let i = 0; i < costHour.length; i++){
	        costHour[i].addEventListener('click', function(){
	            for(let j = 0; j < costHour.length; j++){
	                costHour[j].classList.remove('modal-hour-active');
	                $('.closest_time *').remove();
	            }
	            costHour[i].classList.add('modal-hour-active');
	            modalForm.classList.add('modal-wrap-active');
	            
	            appTime = $('.modal-hour-active').text();
	            appDate = $('.slide-day-show').text();
	            appMonthId = $('.slide-day-show').data('month-id');
	            
		            $.ajax({
					type:'post',
					url:'<?=$CCpu->writelink(3)?>',
					data:"task=appointment_form&doctor_id="+<?=$doctor['id']?> + "&time=" + appTime + "&date=" + appDate + "&month_id=" + appMonthId,
					success:function(msg){
						if (msg !=''){
							$('.modal-wrap-active').html(msg);
						}else{
							show('<?=$GLOBALS['ar_define_langterms']['MSG_ALL_CTOTO_POSHLO_NE_TAK']?>');
						}
					}
				})
	            
	        });
	        
	    }
	    
	    costSliderMonth.on('slideChange', function() {
	    	$('.swiper.cost-carousel-days').each(function(index){
	    		$(this).hide();
	    	});
	    	$('.swiper.cost-carousel-days').eq(costSliderMonth.realIndex).show();
	    	$('.modal__wrapper__days__hours').hide();
	    });
    
</script>



</body>	
				
	
		
</html>