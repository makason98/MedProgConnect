newsLinkBtn=document.querySelectorAll(".news__wrapper__box__link");for(let i=0;i<newsTab.length;i++)newsTab[i].addEventListener("click",function(){for(let t=0;t<newsTab.length;t++)newsLinkBtn[t].classList.remove("link-button-active");newsLinkBtn[i].classList.add("link-button-active")});var article_block=document.querySelectorAll(".news__slider"),detail_links=document.querySelectorAll(".details__page__link"),fb_button=document.querySelectorAll("#news__slider__box__content__social__item__facebook"),twitter_button=document.querySelectorAll("#news__slider__box__content__social__item__twitter");for(let i=0;i<article_block.length;i++)fb_button[i].addEventListener("click",function(){var t=detail_links[i].href;return window.open("https://www.facebook.com/sharer/sharer.php?u="+t,"facebook-share-dialog","width=800,height=600"),!1}),twitter_button[i].addEventListener("click",function(){var t=detail_links[i].href;return window.open("http://twitter.com/share?url="+t),!1});$(".consulting__wrapper__box__card__item").each(function(t){$(this).hover(function(){$(this).css("background","#B90D06"),$(this).css("color","white"),$(this).find("img").attr("src",$(this).data("hover"))},function(){$(this).css("background","inherit"),$(this).css("color","black"),$(this).find("img").attr("src",$(this).data("src"))})}),$(".det__wrapper__img").each(function(t){$(this).hover(function(){0==$(this).hasClass("det-active")&&($(this).find("img.hover").addClass("hover-active"),$(this).find("img.hover_off").addClass("hover-off-active"),$(this).next().addClass("det-active-title"))},function(){0==$(this).hasClass("det-active")&&($(this).find("img.hover").removeClass("hover-active"),$(this).find("img.hover_off").removeClass("hover-off-active"),$(this).next().removeClass("det-active-title"))})}),$(".det__wrapper__title").each(function(t){$(this).hover(function(){0==$(this).prev().hasClass("det-active")&&($(this).prev().find("img.hover").addClass("hover-active"),$(this).prev().find("img.hover_off").addClass("hover-off-active"),$(this).addClass("det-active-title"))},function(){0==$(this).prev().hasClass("det-active")&&($(this).prev().find("img.hover").removeClass("hover-active"),$(this).prev().find("img.hover_off").removeClass("hover-off-active"),$(this).removeClass("det-active-title"))})});