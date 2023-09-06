<?
$ar_clean = filter_input_array( INPUT_POST , FILTER_SANITIZE_SPECIAL_CHARS);
if ( !isset( $_POST ) || empty( $_POST ) || !isset( $_POST['task'] ) ) { exit; }



/* авторизация на сайте */
if($ar_clean['task'] === 'authorization'){
    $user = $User->auth( $ar_clean['login'], $ar_clean['password'] );
    if($user){
        echo "ok";
    }else{
        echo "Неверные данные";
    }
}

/* регитрация */
if($ar_clean['task'] === "registration"){
    
    if( !filter_var($ar_clean['email'], FILTER_VALIDATE_EMAIL) ){
        exit("Неверный e-mail");
    }
    
    $getemail = $Db->getone("SELECT id FROM ws_clients WHERE email = '".$ar_clean['email']."' LIMIT 1");
    if($getemail){
        exit("Этот e-mail уже занят");
    }

    $arFields = array('name','email');
    $arData = array("'".$ar_clean['name']."'", "'".$ar_clean['email']."'");

    if( $User->register($arFields, $arData, $ar_clean['email'], $ar_clean['password'])  ){
        echo "ok";
    }else{
        echo "Не удалось зарегистрироваться. Попробуйте еще раз";
    }
    
}

if($ar_clean['task'] === "headersearch"){
	
	$KEY = trim(strip_tags($ar_clean['search']));
   	 	$KEY = strtolower(filter_var($KEY, FILTER_SANITIZE_SPECIAL_CHARS));
   		$KEY = str_replace("%", "", $KEY);
    	$KEY = str_replace("`", "", $KEY);
    	$KEY = str_replace("concat", "", $KEY); 
	
	
	if(!isset($ar_clean['search']) || empty($ar_clean['search']) || strlen($ar_clean['search'])<6){
	   exit("");
	}
	

	//////////////////////////////// products ////////////////////////////////
	
	$categories = $Db->getall("SELECT * FROM ws_category WHERE title_".$CCpu->lang." LIKE '%" . $KEY . "%' AND active=1");
	$doctors = $Db->getall("SELECT id,first_name,last_name FROM ws_doctors WHERE last_name LIKE '%" . $KEY . "%' OR first_name LIKE '%" . $KEY . "%' AND active=1");
	$services = $Db->getall("SELECT id,doctor_id,title_".$CCpu -> lang." FROM ws_doc_services WHERE title_".$CCpu->lang." LIKE '%" . $KEY . "%' AND active=1 GROUP BY title_".$CCpu->lang." ");
	
	
	$cat_list = array();
	foreach ($categories as $k => $category) {
		$cat_list[$k]['link'] = $CCpu->writelink( 74)."?category=".$category['id'];
		$cat_list[$k]['title'] = $category['title_'.$CCpu->lang];
		
	}
	unset( $category ); unset( $categories );
	
	$doc_list = array();
	foreach ($doctors as $k2 => $doctor) {
		$doc_list[$k2]['link'] = $CCpu->writelink(84,$doctor['id']);
		$doc_list[$k2]['title'] = $doctor['first_name']." ".$doctor['last_name'];
		
	}
	unset( $doctors ); unset( $doctor );
	
	$service_list = array();
	foreach ($services as $k3 => $service) {
		$service_list[$k3]['link'] = $CCpu->writelink(1)."?#uzi";
		$service_list[$k3]['title'] = $service['title_'.$CCpu->lang];
		
	}
	unset( $services ); unset( $service );
	
	

if(empty($cat_list) && empty($doc_list) && empty($service_list)){
	exit("");
}else{?>

	<ul class="search-list">
		<?if(!empty($cat_list)){
		foreach ($cat_list as $k4 => $cat_result ) {?>
			<li class="autocomplete__search-list__listitem col-sm-12" style="margin-bottom: 5px;">
				<a href="<?=$cat_result['link']?>" class="text-title"><?=$cat_result['title']?></a>
			</li>
		<?}}?>
		<?if(!empty($doc_list)){
		foreach ($doc_list as $k5 => $doc_result ) {?>
			<li class="autocomplete__search-list__listitem col-sm-12" style="margin-bottom: 5px;">
				<a href="<?=$doc_result['link']?>" class="text-title"><?=$doc_result['title']?></a>
			</li>
		<?}}?>
		
		<?if(!empty($service_list)){
		foreach ($service_list as $k6 => $service_result ) {?>
			<li class="autocomplete__search-list__listitem col-sm-12" style="margin-bottom: 5px;">
				<a href="<?=$service_result['link']?>" class="text-title"><?=$service_result['title']?></a>
			</li>
		<?}}?>
		
		
	</ul>
	<?}
	
}

if($ar_clean['task'] === "headersearchmobile"){
	
	$KEY = trim(strip_tags($ar_clean['search']));
   	 	$KEY = strtolower(filter_var($KEY, FILTER_SANITIZE_SPECIAL_CHARS));
   		$KEY = str_replace("%", "", $KEY);
    	$KEY = str_replace("`", "", $KEY);
    	$KEY = str_replace("concat", "", $KEY); 
	
	
	if(!isset($ar_clean['search']) || empty($ar_clean['search']) || strlen($ar_clean['search'])<6){
	   exit("");
	}
	

	//////////////////////////////// products ////////////////////////////////
	
	$categories = $Db->getall("SELECT * FROM ws_category WHERE title_".$CCpu->lang." LIKE '%" . $KEY . "%' AND active=1");
	$doctors = $Db->getall("SELECT id,first_name,last_name FROM ws_doctors WHERE last_name LIKE '%" . $KEY . "%' OR first_name LIKE '%" . $KEY . "%' AND active=1");
	$services = $Db->getall("SELECT id,doctor_id,title_".$CCpu -> lang." FROM ws_doc_services WHERE title_".$CCpu->lang." LIKE '%" . $KEY . "%' AND active=1 GROUP BY title_".$CCpu->lang." ");
			

	$cat_list = array();
	foreach ($categories as $k => $category) {
		$cat_list[$k]['link'] = $CCpu->writelink( 74)."?category=".$category['id'];
		$cat_list[$k]['title'] = $category['title_'.$CCpu->lang];
		
	}
	unset( $category ); unset( $categories );
	
	$doc_list = array();
	foreach ($doctors as $k2 => $doctor) {
		$doc_list[$k2]['link'] = $CCpu->writelink(84,$doctor['id']);
		$doc_list[$k2]['title'] = $doctor['first_name']." ".$doctor['last_name'];
		
	}
	unset( $doctors ); unset( $doctor );
	
	$service_list = array();
	foreach ($services as $k3 => $service) {
		$service_list[$k3]['link'] = $CCpu->writelink(1)."?#uzi";
		$service_list[$k3]['title'] = $service['title_'.$CCpu->lang];
		
	}
	unset( $services ); unset( $service );
	
	
	
	

if(empty($cat_list) && empty($doc_list) && empty($service_list)){
	exit("");
}else{?>

	<ul class="search-list_mobile">
		<?if(!empty($cat_list)){
		foreach ($cat_list as $k4 => $cat_result ) {?>
			<li class="autocomplete__search-list__listitem__mobile col-sm-12" style="margin-bottom: 5px;">
				<a href="<?=$cat_result['link']?>" class="text-title"><?=$cat_result['title']?></a>
			</li>
		<?}}?>
		<?if(!empty($doc_list)){
		foreach ($doc_list as $k5 => $doc_result ) {?>
			<li class="autocomplete__search-list__listitem__mobile col-sm-12" style="margin-bottom: 5px;">
				<a href="<?=$doc_result['link']?>" class="text-title"><?=$doc_result['title']?></a>
			</li>
		<?}}?>
		
		<?if(!empty($service_list)){
		foreach ($service_list as $k6 => $service_result ) {?>
			<li class="autocomplete__search-list__listitem__mobile col-sm-12" style="margin-bottom: 5px;">
				<a href="<?=$service_result['link']?>" class="text-title"><?=$service_result['title']?></a>
			</li>
		<?}}?>
		
		
	</ul>
	<?}
	
}

if ($ar_clean['task'] === 'feedback_popup'){?>
<div class="popup_block">
    <div class="feedback_form_title"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_OBRATNAYA_SVYAZI']?></div>
    <div class="feedback_form">
        <input type="text" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_ALL_IMYA']?>" pattern="[a-zA-ZА-Яа-яёЁ ]+$" class="feedback_input popup_input" id="feedback_form_name"  />
        <input type="text" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_ALL_EMAIL']?>" class="feedback_input popup_input" id="feedback_form_email" />
        <input type="text" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_ALL_NOMER_TELEFONA']?>" class="feedback_input popup_input" id="feedback_form_phone" pattern="[0-9-+]+$"/>
        <textarea class="feedback_input feedback_textarea popup_input" id="feedback_form_message"
            placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_ALL_SOOBSCHENIYA']?>"></textarea>
        <button class="popup_btn" id="feedback_btn" onclick="contact_us()"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_OTPRAVITI']?></button>
    </div>
    <div class="close_popup">&#10006;</div>
    <script>
		
        function contact_us() {
            var name = $.trim($('#feedback_form_name').val());
            var email = $.trim($('#feedback_form_email').val());
            var phone = $.trim($('#feedback_form_phone').val());
            var message = $.trim($('#feedback_form_message').val());
            var errors = false;
            
            if (email == '') {
                    accent($("#feedback_form_email"));
                    errors = true;
                }

            if (!isEmail(email) && email.length > 0) {
                accent($('#feedback_form_email'));
                show("<?=$GLOBALS['ar_define_langterms']['MSG_ALL_VVEDITE_PRAVELINII_EMAIL']?>");
                errors = true;
            }
            if (!validatePhone(phone) && phone.length > 0) {
                accent($('#feedback_form_phone'));
                show("<?=$GLOBALS['ar_define_langterms']['MSG_ALL_VVEDITE_PRAVELINII_NOMER_TELEFONA']?>");
                errors = true;
            }
            
            if(!name.match( /^[a-zA-ZА-Яа-яёЁ ]+$/) && name.length > 0){
            	accent($('#feedback_form_name'));
                show("<?=$GLOBALS['ar_define_langterms']['MSG_ALL_V_IMENI_TOLIKO_BUKVI']?>");
                errors = true;
            }
            
            
            if (errors == true) {
                return false;
            } else {
                loader();
                $.ajax({
                    type: "POST",
                    url: "<?=$CCpu->writelink(3)?>",
                    data: {
                        'task': 'contact_us',
                        'name': name,
                        'email': email,
                        'phone': phone,
                        'message': message
                    },
                    success: function (msg) {
                        loader_destroy();
                        if ($.trim(msg) == 'ok') {
                            $('.feedback_form').find('input').val('');
                            $('.feedback_form').find('textarea').val('');
                            $('.popup_place').html('');
                            $('.popup_shadow').hide();
                            show('<?=$GLOBALS['ar_define_langterms']['MSG_ALL_VASHE_SOOBSHENIE_OTPRAVLENO']?>')
                        } else {
                            show('<?=$GLOBALS['ar_define_langterms']['MSG_ALL_PROIZOSHLA_OSHIBKA']?>');
                        }
                    }
                });
            }
        };
        $('.close_popup').on('click', function () {
            $('.popup_place').html('');
            $('.popup_shadow').hide();
        });
        
        let prevVal = "";
		document.querySelector('#feedback_form_name').addEventListener('input', function(e){
		  if(this.checkValidity()){
		    prevVal = this.value;
		  } else {
		    this.value = prevVal;
		  }
	});
	
		document.querySelector('#feedback_form_phone').addEventListener('input', function(e){
		  if(this.checkValidity()){
		    prevVal = this.value;
		  } else {
		    this.value = prevVal;
		  }
	});
    </script>
</div>
<?}


if ($ar_clean['task'] === 'contact_us'){
    $ArrTitle = $ArrVal = array();
    $ArrTitle[] = " date ";
    $ArrVal[] = " NOW() ";
    $ArrTitle[] = " name ";
    $ArrVal[] = " '". $ar_clean['name'] ."' ";
	$ArrTitle[] = " email ";
    $ArrVal[] = " '". $ar_clean['email'] ."' ";
	$ArrTitle[] = " phone ";
    $ArrVal[] = " '". $ar_clean['phone'] ."' ";
    $ArrTitle[] = " message ";
    $ArrVal[] = " '". $ar_clean['message'] ."' ";

    $r = mysqli_query($db,"INSERT INTO ws_messages (". implode( ',' , $ArrTitle ) .") VALUES (". implode( ',' , $ArrVal ) .") ");
    if( $r ) {
    	
	$mailto = $GLOBALS['ar_define_settings']['EMAIL'];
	$name = $ar_clean['name'];
	$fromEmail = $ar_clean['email'];
	$phone = $ar_clean['phone'];
	
	
	$message = "Имя клиента: " . $name . "\n"
	. "Номер Телефона: " . $phone . "\n"
 	. "Email клиента: " . $fromEmail . "\n\n"
 	. "Коментарий клиента: " . "\n" . $ar_clean['message'];
	
	$subject = "Сообщение от клиента";
	
	include_once ($_SERVER['DOCUMENT_ROOT'].'/lib/libmail/libmail.php');
	
	$getSettings = mysqli_query($db, "SELECT `code`,`value` FROM ws_settings ");
    $Settings = mysqli_fetch_all($getSettings, MYSQLI_ASSOC);
    $Settings = array_column($Settings, 'value','code' );


    $m= new Mail();  
    $m->From('info@alfamed.md' );
    $m->ReplyTo( $fromEmail );
    $m->To( $mailto );   // кому, в этом поле так же разрешено указывать имя
    $m->Subject( $subject );
    $m->Body($message);
    $m->Priority(4);
    $m->smtp_on($Settings['SMTP_SERVER'], $Settings['SMTP_MAIL'], $Settings['SMTP_PASS'], $Settings['SMTP_PORT']);
    $m->log_on(true); // включаем лог, чтобы посмотреть служебную информацию
    $a = $m->Send();

        echo 'ok';
    } else {
        echo $GLOBALS['ar_define_langterms']['MSG_ALL_PROIZOSHLA_OSHIBKA'];
    }
	
	
	
	
}

if ($ar_clean['task'] === 'request_call_popup'){?>
<div class="popup_block">
    <div class="feedback_form_title"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAKAZATI_ZVONOK']?></div>
    <div class="feedback_form">
        <input type="text" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_ALL_IMYA']?>" class="feedback_input popup_input" pattern="[a-zA-ZА-Яа-яёЁ ]+$" id="feedback_form_name" />
        <input type="text" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_ALL_NOMER_TELEFONA']?>" class="feedback_input popup_input" pattern="[0-9-+]+$" id="feedback_form_phone" />
        <button class="popup_btn" id="feedback_btn" onclick="contact_us()"><?=$GLOBALS['ar_define_langterms']['MSG_ALL_OTPRAVITI']?></button>
    </div>
    <div class="close_popup">&#10006;</div>
    <script>
    
    	
    
        function contact_us() {
            var name = $.trim($('#feedback_form_name').val());
            var phone = $.trim($('#feedback_form_phone').val());
            var errors = false;
            $('.feedback_input').each(function () {
                if ($(this).val() == '') {
                    accent($(this));
                    errors = true;
                }
            });
            
            if (!validatePhone(phone) && phone.length > 0) {
                accent($('#feedback_form_phone'));
                show("<?=$GLOBALS['ar_define_langterms']['MSG_ALL_VVEDITE_PRAVELINII_NOMER_TELEFONA']?>");
                errors = true;
            }
            
            if(!name.match( /^[a-zA-ZА-Яа-яёЁ ]+$/) && name.length > 0){
            	accent($('#feedback_form_name'));
                show("<?=$GLOBALS['ar_define_langterms']['MSG_ALL_V_IMENI_TOLIKO_BUKVI']?>");
                errors = true;
            }
            
            if (errors == true) {
                return false;
            } else {
                loader();
                $.ajax({
                    type: "POST",
                    url: "<?=$CCpu->writelink(3)?>",
                    data: {
                        'task': 'request_call',
                        'name': name,
                        'phone': phone
                    },
                    success: function (msg) {
                        loader_destroy();
                        if ($.trim(msg) == 'ok') {
                            $('.feedback_form').find('input').val('');
                            $('.feedback_form').find('textarea').val('');
                            $('.popup_place').html('');
                            $('.popup_shadow').hide();
                            show('<?=$GLOBALS['ar_define_langterms']['MSG_ALL_VASHE_SOOBSHENIE_OTPRAVLENO']?>');
                        } else {
                            show('<?=$GLOBALS['ar_define_langterms']['MSG_ALL_PROIZOSHLA_OSHIBKA']?>');
                        }
                    }
                });
            }
        };
        $('.close_popup').on('click', function () {
            $('.popup_place').html('');
            $('.popup_shadow').hide();
        });
        
        
        
        let prevVal = "";
		document.querySelector('#feedback_form_name').addEventListener('input', function(e){
		  if(this.checkValidity()){
		    prevVal = this.value;
		  } else {
		    this.value = prevVal;
		  }
	});
	
		document.querySelector('#feedback_form_phone').addEventListener('input', function(e){
		  if(this.checkValidity()){
		    prevVal = this.value;
		  } else {
		    this.value = prevVal;
		  }
	});
	
	
	
    </script>
</div>
<?}


if ($ar_clean['task'] === 'request_call'){
    $ArrTitle = $ArrVal = array();
    $ArrTitle[] = " date ";
    $ArrVal[] = " NOW() ";
    $ArrTitle[] = " name ";
    $ArrVal[] = " '". $ar_clean['name'] ."' ";
	$ArrTitle[] = " phone ";
    $ArrVal[] = " '". $ar_clean['phone'] ."' ";

    $r = mysqli_query($db,"INSERT INTO ws_call_requests (". implode( ',' , $ArrTitle ) .") VALUES (". implode( ',' , $ArrVal ) .") ");
    if( $r ) {


        $mailto = $GLOBALS['ar_define_settings']['EMAIL'];


        $name = $ar_clean['name'];
        $phone = $ar_clean['phone'];


        $message = "Имя клиента: " . $name . "\n"
            . "Номер Телефона: " . $phone . "\n"
            . "Коментарий клиента: " . "\n" . $ar_clean['message'];

        $subject = "Заказать звонок от клиента";

        include_once ($_SERVER['DOCUMENT_ROOT'].'/lib/libmail/libmail.php');

        $getSettings = mysqli_query($db, "SELECT `code`,`value` FROM ws_settings ");
        $Settings = mysqli_fetch_all($getSettings, MYSQLI_ASSOC);
        $Settings = array_column($Settings, 'value','code' );




        $m= new Mail();
        $m->From( "info@alfamed.md" );
        $m->ReplyTo( $fromEmail );
        $m->To( $mailto );   // кому, в этом поле так же разрешено указывать имя
        $m->Subject( $subject );
        $m->Body($message);
        $m->Priority(4);
        $m->smtp_on($Settings['SMTP_SERVER'], $Settings['SMTP_MAIL'], $Settings['SMTP_PASS'], $Settings['SMTP_PORT']);
        $m->log_on(true); // включаем лог, чтобы посмотреть служебную информацию
        $a = $m->Send();

        /*var_dump($a);
        dump($m->status_mail);
        show($mailto);*/



        echo 'ok';
    } else {
        echo $GLOBALS['ar_define_langterms']['MSG_ALL_PROIZOSHLA_OSHIBKA'];
    }
}

if($ar_clean['task'] === 'appointment_popup'){
    $doctor = $Db -> getone("SELECT id,doc_login,section_id,image,last_name__ AS last_name,first_name__ AS first_name,appointment_hours__ AS appointment_hours FROM ws_doctors WHERE id = ".$ar_clean['doctor_id']." ");
    $category = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_category WHERE id = ".$doctor['section_id']." ");
    $office = $Db -> getone("SELECT city_".$CCpu -> lang." as city, address_".$CCpu -> lang." as address FROM ws_offices 
              INNER JOIN ws_doc_offices_link ON ws_offices.id = ws_doc_offices_link.office_id 
              INNER JOIN ws_doctors ON ws_doc_offices_link.doctor_id = ws_doctors.id WHERE ws_doctors.id = ".$doctor['id']." ");
    $officeId = $Db->getone("SELECT office_id FROM ws_doc_offices_link WHERE doctor_id = '".$doctor['id']."' ");

    $getFilialId = $Db->getone("SELECT client_system_id FROM ws_offices WHERE id = '".$officeId['office_id']."' ");
    ?>

    <div class="modal__close">
        <img src="/icons/close.svg" alt="">
    </div>
    <div class="modal__title">
        <?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISI_NA_PRIOM']?>
    </div>
    <div class="modal__box">
        <div class="modal__box__img">
            <img src="/upload/doctors/<?=$doctor['image']?>" alt="">
        </div>
        <div class="modal__box__info">
            <div class="modal__box__info__name"><?=$doctor['last_name']." ".$doctor['first_name']?></div>
            <div class="modal__box__info__speciality"><?=$category['title']?></div>
        </div>
    </div>

    <div class="modal__accept">
        <?/*Врач принимает в*/?>
    </div>

    <div class="modal__street">
        <?=$office['city']." ".$office['address']?>
    </div>

    <div class="modal__hours">
        <span><img src="/icons/attention.svg" alt=""></span>
        <?=$GLOBALS['ar_define_langterms']['MSG_ALL_CHASY_PRIEMA'].' '.implode(' | ',explode(';',$doctor['appointment_hours']))?>
    </div>

    <?
    $post = array('task'=>'get_times','filial_id'=>$getFilialId['client_system_id'],'doc_login'=>$doctor['doc_login']);
    $ReqString = json_encode($post);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://87.255.69.40:7100/alfalab_api/alfalab.svc/getMedicFreeTimeByMedicId/'.$doctor['doc_login'].'/'.$getFilialId['client_system_id'],
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
    foreach ($responseData AS $k=>$resval){
        $restructureArr[$resval['Date']]['doc'] = $resval['MedicId'];
        $restructureArr[$resval['Date']]['venue'] = $resval['VenueId'];
        $restructureArr[$resval['Date']]['date'] = $resval['Date'];
        $restructureArr[$resval['Date']]['time'][] = $resval['Time'].'-'.$resval['isFreeTime'];
        $dateArr = explode('.',$resval['Date']);
        $monthYear = $dateArr[1].'.'.$dateArr[2];
        $monthsYears[] = $monthYear;
    }

    //show($restructureArr);
    //show(array_unique($monthsYears));
    ?>


    <div class="modal__wrapper">
        <div class="modal__wrapper__months">
            <div class="swiper modal-carousel-months">
                <div class="swiper-wrapper">
                    <?foreach(array_unique($monthsYears) AS $k=>$monthSlide){
                        $monthSlideData = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_months WHERE id = ".explode('.',$monthSlide)[0]." ")?>
                        <div class="swiper-slide"><div class="slide_month"><?=$monthSlideData['title']." ".explode('.',$monthSlide)[1]?></div></div>
                    <?}?>
                </div>

                <div class="swiper-button-prev prev8"></div>
                <div class="swiper-button-next next8"></div>
            </div>
        </div>
        <div class="modal__wrapper__days">
            <?$c = 0;
            foreach (array_unique($monthsYears) AS $k=>$monthSlide_2) {
                $monthSlideData_2 = $Db -> getone("SELECT id,title_".$CCpu -> lang." as title FROM ws_months WHERE id = ".explode('.',$monthSlide_2)[0]." ");
                if(mb_strlen($monthSlideData_2['title'],'UTF-8') > 4){ $monthSlideData_2['title'] = mb_substr($monthSlideData_2['title'],0,3,'UTF-8').".";}?>
                <div class="swiper modal-carousel-days" <?if($c == 0){?>style="display: block;" <?}?>>
                    <div class="swiper-wrapper">
                        <?for($j = explode('.',$responseData[$k]['Date'])[0]; $j <= cal_days_in_month(CAL_GREGORIAN, explode('.',$monthSlide_2)[0], explode('.',$monthSlide_2)[1]); $j++ ){
                            $full_date = strtotime($j."-".explode('.',$monthSlide_2)[0]."-".explode('.',$monthSlide_2)[1]);
                            $day = $Db -> getone("SELECT title_".$CCpu -> lang." as title FROM ws_days WHERE day_code = '".date('D',$full_date)."'")?>
                            <div class="swiper-slide"><div class="slide_day slide_day_active" data-month-id="<?=$monthSlideData_2['id']?>"><?=$day['title']?> <span><?=(int)$j." ".$monthSlideData_2['title']?> </span></div></div>
                        <?}?>
                    </div>

                    <div class="swiper-button-prev prev9"></div>
                    <div class="swiper-button-next next9"></div>
                </div>

                <?for($j = explode('.',$responseData[$k]['Date'])[0]; $j <= cal_days_in_month(CAL_GREGORIAN, explode('.',$monthSlide_2)[0], explode('.',$monthSlide_2)[1]); $j++ ){
                    $full_date = strtotime($j."-".explode('.',$monthSlide_2)[0]."-".explode('.',$monthSlide_2)[1]);?>
                    <div class="modal__wrapper__days__hours">
                        <? foreach ($restructureArr[date('d.m.Y',$full_date)]['time'] AS $k=>$t){
                            $time = explode('-',$t)[0];
                            $free = explode('-',$t)[1];
                            ?>
                            <div class="modal__wrapper__days__hours__item <?if ((int)$free == 1){?>modal_hours_free<?}?>"
                                 data-venue="<?=$restructureArr[date('d.m.Y',$full_date)]['venue']?>"
                                data-date="<?=date('Y_m_d',$full_date)?>"
                            data-time="<?=date('H_i',strtotime($time))?>">
                                <?=date('H:i',strtotime($time))?>
                            </div>
                        <?}?>
                    </div>
                <?}
            $c++;}?>
        </div>
        <div class="modal__wrapper__timezone">
            <?=$GLOBALS['ar_define_langterms']['MSG_ALL_CEASOVOI_POIAS']?>
        </div>

    </div>

    <div class="modal__wrap">

    </div>


    <script>
        $('.modal__close').on("click", function() {
            $('.modal').html('');
            $('.modal').removeClass('modal-show');
            $('.popup_shadow').hide();
            $('body').css('overflow-y','visible');
            $('html').css('overflow-y','visible');
        });


        const modalSliderMonth = new Swiper('.modal-carousel-months', {
            direction: 'horizontal',
            slidesPerView: 1,
            navigation: {
                nextEl: '.next8',
                prevEl: '.prev8',
            },

        });

        const modalSliderDay = new Swiper('.modal-carousel-days', {
            direction: 'horizontal',
            slidesPerView: 7,
            navigation: {
                nextEl: '.next9',
                prevEl: '.prev9',
            },
            breakpoints: {
                280:{
                    slidesPerView: 4
                },
                340:{
                    slidesPerView: 5
                },
                410: {
                    slidesPerView: 7
                }
            }
        });


        let hourModal = document.querySelectorAll('.modal_hours_free');
        let day = document.querySelectorAll('.slide_day_active');
        let modalForm = document.querySelector('.modal__wrap');
        for(let i = 0; i < day.length; i++){
            day[i].addEventListener('click', function(){
                for(let j = 0; j < day.length; j++){
                    day[j].classList.remove('slide-day-show');
                    $('.modal__wrapper__days__hours').eq(j).hide();
                }
                day[i].classList.add('slide-day-show');
                $('.modal__wrapper__days__hours').eq(i).css('display', 'flex');
            });
        }
        for(let i = 0; i < hourModal.length; i++){
            hourModal[i].addEventListener('click', function(){
                for(let j = 0; j < hourModal.length; j++){
                    hourModal[j].classList.remove('modal-hour-active');
                }
                hourModal[i].classList.add('modal-hour-active');
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

        modalSliderMonth.on('slideChange', function() {
            $('.swiper.modal-carousel-days').each(function(index){
                $(this).hide();
            });
            $('.swiper.modal-carousel-days').eq(modalSliderMonth.realIndex).show();
            $('.modal__wrapper__days__hours').hide();
        });

    </script>


<?}

if($ar_clean['task'] === 'appointment_form'){

    $day_id = preg_replace('/[^0-9]/', '', $ar_clean['date']);
    $time = explode(":",$ar_clean['time']);
    $final_time = strtotime(date('m-d-Y H:i:s',mktime($time[0],$time[1],0,$day_id,$ar_clean['month_id'],date('Y'))));
    ?>

    <div class="modal__wrap__title">
        <?=$ar_clean['date']." ".date('Y')." ".$ar_clean['time']?>
    </div>
    <div class="modal__wrap__form">
        <div class="modal__wrap__form__input">
            <div class="modal__wrap__form__input__item">
                <fieldset class="required__info" id="name_input_box">
                    <legend><?=$GLOBALS['ar_define_langterms']['MSG_ALL_FAMILIA_IMIA']?></legend>
                    <input type="text" id="app_name">
                </fieldset>
                <fieldset id="email_input_box">
                    <legend>Email</legend>
                    <input type="text" id="app_email">
                </fieldset>
                <fieldset class="required__info" id="phone_input_box">
                    <legend><?=$GLOBALS['ar_define_langterms']['MSG_ALL_NOMER_TELEFONA']?></legend>
                    <input type="text" id="app_phone" pattern="[0-9-+]+$">
                </fieldset>
            </div>
            <div class="modal__wrap__form__input__item">
                <fieldset>
                    <legend><?=$GLOBALS['ar_define_langterms']['MSG_ALL_KOMENTARII']?></legend>
                    <input type="text" id="app_message">
                </fieldset>
            </div>
        </div>
    </div>
    <div class="modal__wrap__info">
        <?=$GLOBALS['ar_define_langterms']['MSG_ALL_INFORMACIYA_O_NAPOMINANII_O_ZAPISI_NA_PRIEM']?>
    </div>
    <div class="modal__wrap__btn red" onclick="request_appointment()">
        <?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATSA_NA_PRIOM']?>
    </div>

    <script>
        function request_appointment() {
            var fullName = $.trim($('#app_name').val());
            var email = $.trim($('#app_email').val());
            var phone = $.trim($('#app_phone').val());
            var message = $.trim($('#app_message').val());
            var venue = $('.modal-hour-active').attr('data-venue');
            var visitDate = $('.modal-hour-active').attr('data-date');
            var visitTime = $('.modal-hour-active').attr('data-time');
            errors = false;
            $('.required__info').each(function () {
                if ($(this).find('input').val() == '') {
                    accent($(this));
                    errors = true;
                }
            });
            if (!isEmail(email) && email.length > 0) {
                accent($('#email_input_box'));
                show("<?=$GLOBALS['ar_define_langterms']['MSG_ALL_VVEDITE_PRAVELINII_EMAIL']?>");
                errors = true;
            }
            if (!validatePhone(phone) && phone.length > 0) {
                accent($('#phone_input_box'));
                show("<?=$GLOBALS['ar_define_langterms']['MSG_ALL_VVEDITE_PRAVELINII_NOMER_TELEFONA']?>");
                errors = true;
            }
            if (errors == true) {
                return false;
            } else {
                loader();
                $.ajax({
                    type: "POST",
                    url: "<?=$CCpu->writelink(3)?>",
                    data: {
                        'task': 'setup_appointment',
                        'doctor_id': <?=$ar_clean['doctor_id']?>,
                        'name': fullName,
                        'email': email,
                        'phone': phone,
                        'message': message,
                        'appointment_date': <?=$final_time?>,
                        'venue':venue,
                        'visit_date':visitDate,
                        'visit_time':visitTime
                    },
                    success: function (msg) {
                        loader_destroy();
                        if ($.trim(msg) == 'ok') {
                            $('.modal__wrap__form__input').find('input').val('');
                            show('<?=$GLOBALS['ar_define_langterms']['MSG_ALL_VASHE_SOOBSHENIE_OTPRAVLENO']?>')
                        } else {
                            show('<?=$GLOBALS['ar_define_langterms']['MSG_ALL_PROIZOSHLA_OSHIBKA']?>');
                        }
                    }
                });
            }
        }

        $(".red").hover(
            function(){
                $(this).removeClass("red");
                $(this).addClass("white");
            }, function(){
                $(this).addClass("red");
                $(this).removeClass("white");
            }
        );

    </script>


<?}

if($ar_clean['task'] === 'first_time_appointment_form'){?>
    <div class="modal__wrap__form">
        <div class="modal__wrap__form__input">
            <div class="modal__wrap__form__input__item">
                <fieldset class="required__info" id="name_input_box">
                    <legend><?=$GLOBALS['ar_define_langterms']['MSG_ALL_FAMILIA_IMIA']?></legend>
                    <input type="text" id="app_name">
                </fieldset>
                <fieldset id="email_input_box">
                    <legend><?=$GLOBALS['ar_define_langterms']['MSG_ALL_EMAIL']?></legend>
                    <input type="text" id="app_email">
                </fieldset>
                <fieldset class="required__info" id="phone_input_box">
                    <legend><?=$GLOBALS['ar_define_langterms']['MSG_ALL_NOMER_TELEFONA']?></legend>
                    <input type="text" id="app_phone" pattern="[0-9-+]+$">
                </fieldset>
            </div>
            <div class="modal__wrap__form__input__item">
                <fieldset>
                    <legend><?=$GLOBALS['ar_define_langterms']['MSG_ALL_KOMENTARII']?></legend>
                    <input type="text" id="app_message">
                </fieldset>
            </div>
        </div>
    </div>
    <div class="modal__wrap__info">
        <?=$GLOBALS['ar_define_langterms']['MSG_ALL_INFORMACIYA_O_NAPOMINANII_O_ZAPISI_NA_PRIEM']?>
    </div>
    <div class="modal__wrap__btn red" onclick="request_appointment()">
        <?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAPISATSA_NA_PRIOM']?>
    </div>

    <script>
        function request_appointment() {
            var fullName = $.trim($('#app_name').val());
            var email = $.trim($('#app_email').val());
            var phone = $.trim($('#app_phone').val());
            var message = $.trim($('#app_message').val());
            errors = false;
            $('.required__info').each(function () {
                if ($(this).find('input').val() == '') {
                    accent($(this));
                    errors = true;
                }
            });
            if (!isEmail(email) && email.length > 0) {
                accent($('#email_input_box'));
                show("<?=$GLOBALS['ar_define_langterms']['MSG_ALL_VVEDITE_PRAVELINII_EMAIL']?>");
                errors = true;
            }
            if (!validatePhone(phone) && phone.length > 0) {
                accent($('#phone_input_box'));
                show("<?=$GLOBALS['ar_define_langterms']['MSG_ALL_VVEDITE_PRAVELINII_NOMER_TELEFONA']?>");
                errors = true;
            }
            if (errors == true) {
                return false;
            } else {
                loader();
                $.ajax({
                    type: "POST",
                    url: "<?=$CCpu->writelink(3)?>",
                    data: {
                        'task': 'setup_appointment',
                        'doctor_id': <?=$ar_clean['doctor_id']?>,
                        'name': fullName,
                        'email': email,
                        'phone': phone,
                        'message': message,
                        'venue':'<?=$ar_clean['venue']?>',
                        'visit_date':'<?=$ar_clean['date']?>',
                        'visit_time':'<?=$ar_clean['time']?>'
                    },
                    success: function (msg) {
                        loader_destroy();
                        if ($.trim(msg) == 'ok') {
                            $('.modal__wrap__form__input').find('input').val('');
                            show('<?=$GLOBALS['ar_define_langterms']['MSG_ALL_VASHE_SOOBSHENIE_OTPRAVLENO']?>')
                        } else {
                            show('<?=$GLOBALS['ar_define_langterms']['MSG_ALL_PROIZOSHLA_OSHIBKA']?>');
                        }
                    }
                });
            }
        }
    </script>


<?}


if ($ar_clean['task'] === 'setup_appointment'){
    /* перед отправкой письма запишемся на прием */

    $docLogin = $Db->getone("SELECT doc_login FROM ws_doctors WHERE id = '".$ar_clean['doctor_id']."' ");

    $d = explode('_',$ar_clean['visit_date'])[2];
    $m = explode('_',$ar_clean['visit_date'])[1];
    $y = explode('_',$ar_clean['visit_date'])[0];

    $appointment_date = $d.'.'.$m.'.'.$y.' '.implode(':',explode('_',$ar_clean['visit_time']));
    //2022-07-04 14:00:00
    //show($appointment_date);
    //show(date('Y-m-d H:i:s',strtotime($appointment_date)));
    //exit();
    $post = array('task'=>'request_appointment','doc_login'=>$docLogin['doc_login'],'date'=>$ar_clean['visit_date'],'time'=>$ar_clean['visit_time']);
    $ReqString = json_encode($post);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://87.255.69.40:7100/alfalab_api/alfalab.svc/setReservationTime/'.$docLogin['doc_login'].'/'.$ar_clean['venue'].'/'.$ar_clean['visit_date'].'/'.$ar_clean['visit_time'].'/'.implode('_',explode(' ',$ar_clean['name'])).'/'.str_replace('+','',$ar_clean['phone']).'/'.$ar_clean['email'].'',
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
    if ($responseData[0]['message'] == 'ok'){
        $ArrTitle = $ArrVal = array();
        $ArrTitle[] = " doctor_id ";
        $ArrVal[] = " '". $ar_clean['doctor_id'] ."' ";
        $ArrTitle[] = " name ";
        $ArrVal[] = " '". $ar_clean['name'] ."' ";
        $ArrTitle[] = " email ";
        $ArrVal[] = " '". $ar_clean['email'] ."' ";
        $ArrTitle[] = " phone ";
        $ArrVal[] = " '". $ar_clean['phone'] ."' ";
        $ArrTitle[] = " message ";
        $ArrVal[] = " '". $ar_clean['message'] ."' ";
        $ArrTitle[] = " appointment_date ";
        $ArrVal[] = " '". date('Y-m-d H:i:s',strtotime($appointment_date)) ."' ";
        $ArrTitle[] = " date ";
        $ArrVal[] = " NOW() ";

        $r = mysqli_query($db,"INSERT INTO ws_appointments (". implode( ',' , $ArrTitle ) .") VALUES (". implode( ',' , $ArrVal ) .") ");
        if( $r ) {

            /* отправим администратору сайта сообщение на почту о том что есть новая запись на прием к врачу */

            $mailto = $GLOBALS['ar_define_settings']['EMAIL'];
            $name = $ar_clean['name'];
            $fromEmail = $ar_clean['email'];
            $phone = $ar_clean['phone'];
            $doctor = $Db->getone("SELECT * FROM ws_doctors WHERE id = ".$ar_clean['doctor_id']." ");


            $message = "Имя клиента: " . $name . "\n"
                . "Номер Телефона: " . $phone . "\n"
                . "Email клиента: " . $fromEmail . "\n\n"
                . "Время подачи заявки: " . f_date(date('Y-m-d H:i:s'))  . "\n\n"
                . "Время приема: " . $appointment_date . "\n\n"
                . "Фамилия Имя Врача: " . $doctor['last_name_'.$CCpu->lang] . " ". $doctor['first_name_'.$CCpu->lang] . "\n\n"
                . "Коментарий клиента: " . "\n" . $ar_clean['message'];

            $subject = "Запись на прием к врачу";

            include_once ($_SERVER['DOCUMENT_ROOT'].'/lib/libmail/libmail.php');

            $getSettings = mysqli_query($db, "SELECT `code`,`value` FROM ws_settings ");
            $Settings = mysqli_fetch_all($getSettings, MYSQLI_ASSOC);
            $Settings = array_column($Settings, 'value','code' );


            $m= new Mail();
            $m->From( 'info@alfamed.md' );
            $m->ReplyTo( $fromEmail );
            $m->To( $mailto );   // кому, в этом поле так же разрешено указывать имя
            $m->Subject( $subject );
            $m->Body($message);
            $m->Priority(4);
            $m->smtp_on($Settings['SMTP_SERVER'], $Settings['SMTP_MAIL'], $Settings['SMTP_PASS'], $Settings['SMTP_PORT']);
            $m->log_on(true); // включаем лог, чтобы посмотреть служебную информацию
            $a = $m->Send();

            echo 'ok';
    }
    } elseif ($responseData[0]['message'] == 'error_date_busy'){
        echo $GLOBALS['ar_define_langterms']['MSG_ALL_DATE_BUSY'];
    } else {
        echo $GLOBALS['ar_define_langterms']['MSG_ALL_PROIZOSHLA_OSHIBKA'];
    }
}


if( $ar_clean['task'] == 'cookie_alert_close' ) {
		if( $_COOKIE['cookie_alert'] == 0 ) {
			setcookie ( "cookie_alert", '' , time()-3600, '/' );  
			
			sleep( 1 );
			
			 mysqli_query($db , " INSERT INTO `ws_cookie_accept` 
				 ( date , ip ) 
				VALUES 
				 ( NOW(), '". ip2long( $_SERVER['REMOTE_ADDR'] ) ."' ) ");
 			
			 $id = mysqli_insert_id( $db );
			 if( $id ) {
				setcookie( "cookie_alert" , $id , time()+60*60*24*1 , '/' );
				echo 'ok';
			 }
		 }else{
			 exit;
		}
	 }

/*if ($ar_clean['task'] === 'get_free_time'){
    $getFilialId = $Db->getone("SELECT client_system_id FROM ws_offices WHERE id = '".(int)$ar_clean['filial_id']."' ");
    $docLogin = $Db->getone("SELECT doc_login FROM ws_doctors WHERE id = '".(int)$ar_clean['doctor_id']."' ");
    $post = array('task'=>'get_times','filial_id'=>$getFilialId['client_system_id'],'doc_login'=>$docLogin['doc_login']);
    $ReqString = json_encode($post);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        //CURLOPT_URL => 'http://87.255.69.40:7100/alfalab_api/alfalab.svc/getFirstFreeTimeByFilialId/'.(int)$getFilialId['client_system_id'],
        CURLOPT_URL => 'http://87.255.69.40:7100/alfalab_api/alfalab.svc/getMedicFreeTimeByMedicId/'.$docLogin['doc_login'].'/'.$getFilialId['client_system_id'], // получение свободного времени врача по его id в системе клиента и по id филиала в котором он работает
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

    show($ReqString);

    $response = curl_exec($curl);
    show($response);
    $array = json_decode(json_encode((array)simplexml_load_string($response)),true);
    $responseData = json_decode($array[0],true);
    show($responseData);
    /* тут пересобираем массив в нужный формат на случай если их кодер не сможет переделать
    foreach ($responseData AS $k=>$resval){
        $restructureArr[$resval['date']]['doc'] = $resval['MedicId'];
        $restructureArr[$resval['date']]['venue'] = $resval['VenueId'];
        $restructureArr[$resval['date']]['date'] = $resval['Date'];
        $restructureArr[$resval['date']]['time'][] = $resval['Time'];
    }
    show($restructureArr);
}


if ($ar_clean['task'] === 'get_doctors'){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://87.255.69.40:7100/alfalab_api/alfalab.svc/getDoctorList',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic aHR0cDpxd2UxMjM=',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    show($response);
    $array = json_decode(json_encode((array)simplexml_load_string($response)),true);
    $responseData = json_decode($array[0],true);
    show($responseData);
}*/


?>


