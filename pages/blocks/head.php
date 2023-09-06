
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?if(isset($page_data)){ echo $page_data['page_title']; }else{?> Page title <?}?></title>
    <meta name="description" content="<?if(isset($page_data)){ echo $page_data['meta_d']; }else{?>Page description<?}?>">
    <meta name="keywords" content="<?if(isset($page_data)){ echo $page_data['meta_k']; }else{?>Page keywords<?}?>">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="/css/style.min.css">
    <link rel="stylesheet" href="/css/style.min.css">


    <style>
        <?include($_SERVER['DOCUMENT_ROOT'].'/css/style.css')?>
    </style>

    <?/*<link rel="stylesheet" href="/css/style.css" />*/?>

    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.min.css"/>

    <script>
        var close__btn = '<?=$GLOBALS['ar_define_langterms']['MSG_ALL_ZAKRITI']?>';
    </script>

    <?/*
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-PMZGTD4');</script>
    <!-- End Google Tag Manager -->
*/?>
<?$lozad = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8DACgAECwEG1Nx7MQAAAABJRU5ErkJggg==';?>