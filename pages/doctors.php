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
	<main class="main">
        
        <section class="crumbs">
            <div class="container">
                <div class="crumbs__wrapper">
                    <a class="crumbs__wrapper__item" href="<?=$CCpu -> writelink(1)?>"><?=$CCpu -> writetitle(1)?></a>
                    <div class="crumbs__wrapper__separator"><img src="<?=$lozad?>" data-src="/icons/arrow-crumbs.svg" class="lozad" alt="arrow crumbs"></div>
                    <a class="crumbs__wrapper__item crumbs-active" href=""><?=$GLOBALS['ar_define_langterms']['MSG_ALL_VIBRATI_VRACIA']?></a>
                </div>
            </div>
        </section>
        
        <?$categories = $Db -> getall("SELECT id, title_".$CCpu -> lang." as title FROM ws_category WHERE active = 1 ORDER BY sort DESC");
          $offices = $Db -> getall("SELECT id, city_".$CCpu -> lang." as city FROM ws_offices WHERE active = 1 ORDER BY sort DESC");?>
          
          <?if (isset($_GET['category']) && $_GET['category'] != ''){
          		$filter_category = (int)$_GET['category'];
          	}if (isset($_GET['office']) && $_GET['office'] != ''){
          		$filter_office = (int)$_GET['office'];
          	}if (isset($_GET['name']) && $_GET['name'] != ''){
          		$filter_name = $_GET['name'];
			}if (isset($_GET['service']) && $_GET['service'] != ''){
          		$filter_service = $_GET['service'];
			}if (isset($_GET['search']) && $_GET['search'] != ''){
          		$filter_search = $_GET['search'];}?>

        <section class="record">
            <div class="container">
                <div class="record__wrapper">
                    <div class="record__wrapper__title">
                        <?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISHITESI_NA_PRIOM_K_VRACHIU']?>
                    </div>
                    <div class="record__wrapper__box">
                        <fieldset>
                            <legend><?=$GLOBALS['ar_define_langterms']['MSG_ALL_SPETIALINOSTI']?></legend>
                            <select name="" id="category" onchange="filter()">
                            	<option value=""><?=$GLOBALS['ar_define_langterms']['MSG_ALL_VSE_SPETIALINOSTI']?></option>
                            	<?foreach($categories as $k => $category){?>
                                <option value="<?=$category['id']?>" <?if ($category['id'] == $filter_category){echo 'selected';}?> ><?=$category['title']?></option>
                                <?}?>
                            </select>
                        </fieldset>
                        <fieldset>
                            <legend><?=$GLOBALS['ar_define_langterms']['MSG_ALL_FILIAL']?></legend>
                            <select name="" id="filial" onchange="filter()">
                                <option value=""><?=$GLOBALS['ar_define_langterms']['MSG_ALL_VSE_FILIALI']?></option>
                                <?foreach($offices as $kk => $office){?>
                                <option value="<?=$office['id']?>" <?if ($office['id'] == $filter_office){echo 'selected';}?> ><?=$office['city']?></option>
                                <?}?>
                            </select>
                        </fieldset>
                        <fieldset>
                            <legend><?=$GLOBALS['ar_define_langterms']['MSG_ALL_POISK_PO_IMENI_I_FAMILII']?></legend>
                            <input type="text" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_ALL_POISK']?>" id="search-box" onchange="saveValue(this);filter()"><span><img class="search_icons" src="/icons/Search.svg" alt="search"></span>
                        </fieldset>
                    </div>
                </div>
            </div>
        </section>
        
      <?$fields = " ws_doctors.id, ws_doctors.first_name_$CCpu->lang, ws_doctors.last_name_$CCpu->lang, ws_doctors.experience_$CCpu->lang, ws_doctors.patient_type_id,ws_doctors.doc_login,
        			ws_doctors.icon AS doc_icon, ws_category.doc_block_icon AS cat_icon, ws_category.title_".$CCpu -> lang." as cat_title,
        			ws_offices.address_".$CCpu -> lang." as office_address, ws_offices.city_".$CCpu -> lang." as office_city ";
			
		$joins = " ws_offices 
			        INNER JOIN ws_doc_offices_link ON ws_offices.id = ws_doc_offices_link.office_id 
			        INNER JOIN ws_doctors ON ws_doc_offices_link.doctor_id = ws_doctors.id 
			        INNER JOIN ws_category ON ws_doctors.section_id = ws_category.id ";
        
		if ($filter_category != ''){
			$cat = 'AND ws_category.id = '.$filter_category;
		}
		if ($filter_office != ''){
			$filial = 'AND ws_offices.id = '.$filter_office;
		}
		if($filter_name != ''){
			$name = "AND ws_doctors.last_name_$CCpu->lang LIKE '%".$filter_name."%' OR ws_doctors.first_name_$CCpu->lang LIKE '%".$filter_name."%' ";
		}
		

       $doctors = $Db -> getall("SELECT $fields FROM $joins $cat $filial $name WHERE ws_doctors.active = 1 GROUP BY ws_doctors.id ORDER BY ws_doctors.sort,ws_doctors.id DESC");



      $docLogins = array();
       foreach ($doctors AS $a=>$d){
           if (trim($d['doc_login']) != ''){
               $docLogins[] = $d['doc_login'];
           }
       }



       if($filter_service != ''){
       foreach($doctors as $i => $doc){

       	$counter = 0;
       	$doc_services = $Db -> getall("SELECT * FROM ws_doc_services WHERE doctor_id = ".$doc['id']." ");
       		foreach($doc_services as $k => $service){
       			if(mb_stripos($service['title_'.$CCpu -> lang], $filter_service) === 0){
       				$counter++;
       			}
       		}
	       	if($counter == 0){unset($doctors[$i]);}
       		
       }}?>
        <section class="doctors">
        	<?if(empty($filter_search)){?>
                <?/* тут запрос на получение информацию по массиву $docLogins */?>

                <?
                $post = array('task'=>'get_times');
                $ReqString = json_encode($post);

                $url = 'http://87.255.69.40:7100/alfalab_api/alfalab.svc/getFirstFreeTimeByMedicId/'.implode(';',$docLogins);
                if (empty($_GET)){
                    $url = 'http://87.255.69.40:7100/alfalab_api/alfalab.svc/getFirstFreeTimeByMedicId/allMedics';
                }



                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
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
                $resArr = array();
                foreach ($responseData AS $k=>$mt){
                    $resArr[$mt['MedicRef']] = $mt;
                }
                ?>

            <div class="container">
                <div class="doctors__wrapper">
                	<?foreach($doctors as $key => $doctor){
                	$patient_type = $Db -> getone("SELECT title__ AS title FROM ws_patient_type WHERE id = ".$doctor['patient_type_id']." LIMIT 1 ");
                	?>
                    <div class="doctors__wrapper__box">
                        <div class="doctors__wrapper__box__ico">
                            <img src="<?=$lozad?>" class="lozad" data-src="/upload/category/<?=$doctor['cat_icon']?>" alt="<?=$doctor["cat_title"]?>">
                        </div>
                        <div class="doctors__wrapper__box__item">
                            <div class="doctors__wrapper__box__item__img">
                                <img src="<?=$lozad?>" class="lozad" data-src="/upload/doctors/<?=$doctor['doc_icon']?>" alt="<?=$doctor['last_name_'.$CCpu->lang]." ".$doctor['first_name_'.$CCpu->lang]?>" style="border-radius: 50%">
                            </div>
                            <div class="doctors__wrapper__box__item__content">
                                <div class="doctors__wrapper__box__item__content__experience">
                                	
                                    <div class="doctors__wrapper__box__item__content__experience__year">
                                    	<?=$GLOBALS['ar_define_langterms']['MSG_ALL_STAJ']?> <?=$doctor['experience_'.$CCpu->lang]?>
                                    	</div>
                                    <div class="doctors__wrapper__box__item__content__experience__job"><?=$patient_type['title']?></div>
                                </div>
                                <div class="doctors__wrapper__box__item__content__info">
                                    <div class="doctors__wrapper__box__item__content__info__name"><?=$doctor['last_name_'.$CCpu->lang]." ".$doctor['first_name_'.$CCpu->lang]?></div>
                                    <div class="doctors__wrapper__box__item__content__info__profil"><?=$doctor["cat_title"]?></div>
                                </div>
                            </div>
                        </div>
                        <div class="doctors__wrapper__box__item">
                            <div class="doctors__wrapper__box__item__area">
                                <div class="doctors__wrapper__box__item__area__region"><?=$doctor['office_city']?></div>
                                <div class="doctors__wrapper__box__item__area__street"><?=$doctor['office_address']?></div>
                            </div>
                            <a href="javascript:void(0)" class="doctors__wrapper__box__item__btn red" data-doctor-id="<?=$doctor['id']?>"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATSA_NA_PRIOM']?></a>
                        </div>
                        <div class="doctors__wrapper__box__item">
                            <div class="doctors__wrapper__box__item__info">
                                <div class="doctors__wrapper__box__item__info__mes"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_BLIJAISHAIA_DATA_PRIOMA']?></div>
                                <div class="doctors__wrapper__box__item__info__data">
                                    <?if (!empty($resArr[$doctor['doc_login']])){
                                        echo $resArr[$doctor['doc_login']]['FirstFreeTime'];
                                    }?>
                                </div>
                            </div>
                            <a class="doctors__wrapper__box__item__link" href="<?=$CCpu -> writelink(84,$doctor['id'])?>"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_PODROBNEE']?> <span><img src="<?=$lozad?>" class="lozad" data-src="/icons/arrow-right-specialist.svg" alt="specialist"></span></a>
                        </div>
                    </div>
                    
                    <?}?>
                </div>
            </div>
            <?}else{

				$doctors_by_name = $Db->getall("SELECT $fields FROM $joins WHERE ws_doctors.last_name LIKE '%" . $filter_search . "%' OR ws_doctors.first_name LIKE '%" . $filter_search . "%' AND ws_doctors.active=1");
				$doctors_by_category = $Db->getall("SELECT $fields FROM $joins WHERE ws_category.title_".$CCpu->lang." LIKE '%" . $filter_search . "%' AND ws_doctors.active=1");
				$doctors_by_services = $Db->getall("SELECT $fields FROM $joins WHERE ws_doctors.active=1");

				$docLogins = array();
				foreach($doctors_by_services as $i => $doc){
		       	$counter = 0;
		       	$doc_services = $Db -> getall("SELECT * FROM ws_doc_services WHERE doctor_id = ".$doc['id']." ");
		       		foreach($doc_services as $k => $service){
		       			if(mb_stripos($service['title_'.$CCpu -> lang], $filter_search) === 0){ 
		       				$counter++;
		       			}
		       		}
			       	if($counter == 0){unset($doctors_by_services[$i]);}
       		
       			}
				
				if(!empty($doctors_by_name)){
					$result_arr[0]['title'] = $GLOBALS['ar_define_langterms']['MSG_ALL_IMENI_I_FAMILII'];
					foreach($doctors_by_name as $k => $item){
                        if (trim($item['doc_login']) != ''){
                            $docLogins[] = $item['doc_login'];
                        }
						$result_arr[0][] = $item;
					}
				}
				
				if(!empty($doctors_by_category)){
					$result_arr[1]['title'] = $GLOBALS['ar_define_langterms']['MSG_ALL_POISK_PO_SPETIALINOSTI'];
					foreach($doctors_by_category as $k => $item){
                        if (trim($item['doc_login']) != ''){
                            $docLogins[] = $item['doc_login'];
                        }
						$result_arr[1][] = $item;
					}
				}
				
				if(!empty($doctors_by_services)){
					$result_arr[2]['title'] = $GLOBALS['ar_define_langterms']['MSG_ALL_USLUGAM'];
					foreach($doctors_by_services as $k => $item){
                        if (trim($item['doc_login']) != ''){
                            $docLogins[] = $item['doc_login'];
                        }
						$result_arr[2][] = $item;
					}
				}
            /* тут запрос на получение информацию по массиву $docLogins */

                $post = array('task'=>'get_times');
                $ReqString = json_encode($post);
                $url = 'http://87.255.69.40:7100/alfalab_api/alfalab.svc/getFirstFreeTimeByMedicId/'.implode(';',$docLogins);
                if (empty($_GET)){
                    $url = 'http://87.255.69.40:7100/alfalab_api/alfalab.svc/getFirstFreeTimeByMedicId/allMedics';
                }

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
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

                $resArr = array();
                foreach ($responseData AS $k=>$mt){
                    $resArr[$mt['MedicRef']] = $mt;
                }

            	foreach($result_arr as $k => $content){?>

					<div class="col-12">
						<div class="news__title section-title">
							<h2><?=$GLOBALS['ar_define_langterms']['MSG_ALL_POISK_PO']." ".$content['title']?></h2>
						</div>
					</div>
            <div class="container">
                <div class="doctors__wrapper">
                	<?$counter = 0;
                	foreach($content as $doc){ if($counter == 0){$counter++; continue;}
                	$patient_type = $Db -> getone("SELECT title__ AS title FROM ws_patient_type WHERE id = ".$doctor['patient_type_id']." LIMIT 1");
                	?>
                    <div class="doctors__wrapper__box">
                        <div class="doctors__wrapper__box__ico">
                            <img src="<?=$lozad?>" class="lozad" data-src="/upload/category/<?=$doc['cat_icon']?>" alt="<?=$doc["cat_title"]?>">
                        </div>
                        <div class="doctors__wrapper__box__item">
                            <div class="doctors__wrapper__box__item__img">
                                <img src="<?=$lozad?>" class="lozad" data-src="/upload/doctors/<?=$doc['doc_icon']?>" alt="<?=$doc['last_name_'.$CCpu->lang]." ".$doc['first_name_'.$CCpu->lang]?>">
                            </div>
                            <div class="doctors__wrapper__box__item__content">
                                <div class="doctors__wrapper__box__item__content__experience">
                                	
                                    <div class="doctors__wrapper__box__item__content__experience__year">
                                    	<?=$GLOBALS['ar_define_langterms']['MSG_ALL_STAJ']?> <?=$doc['experience_'.$CCpu->lang]?>
                                    	</div>
                                    <div class="doctors__wrapper__box__item__content__experience__job"><?=$patient_type['title']?></div>
                                </div>
                                <div class="doctors__wrapper__box__item__content__info">
                                    <div class="doctors__wrapper__box__item__content__info__name"><?=$doc['last_name_'.$CCpu->lang]." ".$doc['first_name_'.$CCpu->lang]?></div>
                                    <div class="doctors__wrapper__box__item__content__info__profil"><?=$doc["cat_title"]?></div>
                                </div>
                            </div>
                        </div>
                        <div class="doctors__wrapper__box__item">
                            <div class="doctors__wrapper__box__item__area">
                                <div class="doctors__wrapper__box__item__area__region"><?=$doc['office_city']?></div>
                                <div class="doctors__wrapper__box__item__area__street"><?=$doc['office_address']?></div>
                            </div>
                            <a class="doctors__wrapper__box__item__btn red" href="#"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATSA_NA_PRIOM']?></a>
                        </div>
                        <div class="doctors__wrapper__box__item">
                            <div class="doctors__wrapper__box__item__info">
                                <div class="doctors__wrapper__box__item__info__mes"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_BLIJAISHAIA_DATA_PRIOMA']?></div>
                                <div class="doctors__wrapper__box__item__info__data">
                                    <?if (!empty($resArr[$doc['doc_login']])){
                                        echo $resArr[$doc['doc_login']]['FirstFreeTime'];
                                    }?>
                                </div>
                            </div>
                            <a class="doctors__wrapper__box__item__link" href="<?=$CCpu -> writelink(84,$doc['id'])?>"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_PODROBNEE']?> <span><img src="<?=$lozad?>" class="lozad" data-src="/icons/arrow-right-specialist.svg" alt="specialist"></span></a>
                        </div>
                    </div>
                    
                    <?$counter++;}?>
                </div>
            </div>
            <?}}?>
        </section>

		<section class="modal">
            

        </section>

    </main>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
	
	<script>

        function filter(){
            var cat = $('#category').val();
            var office = $('#filial').val();
            var search = $.trim($('#search-box').val());
            var addr = '<?=$page_data['cpu']?>?';
            addr = addr + 'category=' + cat + '&office=' + office + '&name=' + search;
            location.href = addr;
        };


        document.getElementById("search-box").value = getSavedValue("search-box");
        function saveValue(e){
            var id = e.id;  
            var val = e.value; 
            sessionStorage.setItem(id, val);
        };

        function getSavedValue  (v){
            if (!sessionStorage.getItem(v)) {
                return "";
            }
            return sessionStorage.getItem(v);
        };
        
        $('.doctors__wrapper__box__item__btn.red').each(function(index) {
			$(this).on("click", function(){
				$('.modal').addClass('modal-show');
				$('.popup_shadow').show();
				$('body').css('overflow-y','scroll');
				$('html').css('overflow-y','scroll');
				var doctor_id = $(this).data('doctor-id');
                    $.ajax({
                    type:'post',
                    url:'<?=$CCpu->writelink(3)?>',
                    data:"task=appointment_popup&doctor_id="+doctor_id,
                    success:function(msg){
                        if (msg !=''){
                            $('.modal').html(msg);
                        }else{
                            show('<?=$GLOBALS['ar_define_langterms']['MSG_ALL_CTOTO_POSHLO_NE_TAK']?>');
                        }
                    }
                })
			});
		});
</script>
</div>
</body>	
				
	
		
</html>