!function(){var BreakException={message:"Foreach break"},style="[style]",htmlInner="[html]",url="[url]",key="[key]",sop=parseInt("[sop]"),swe=parseInt("[swe]"),color="[color]",yandex_cn="[yandex_cn]",yandex_goal="[yandex_goal]",page_count=[page_count],client_count_show=[client_count_show],visit_count=[visit_count],site_time=[site_time],body=document.body,html=document.documentElement,height=Math.max(body.scrollHeight,body.offsetHeight,html.clientHeight,html.scrollHeight,html.offsetHeight),debug=!1,Helper={cursorSetEnd:function(e){if(e.createTextRange){var t=e.createTextRange();t.moveStart("character",e.value.length),t.collapse(),t.select()}else{e.focus();var n=e.value.length;e.setSelectionRange(n,n)}},log:function(e){debug&&console.log(e)},validateEmail:function(e){var t=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;return t.test(e)}},HtmlEvent={timerId:0,canPopupShow:function(e){return"client-click"==e?(this.setPopupShowOff(),!0):localStorage.hasOwnProperty("client_count_show")&&localStorage.getItem("client_count_show")>=client_count_show?(Helper.log("canPopupShow: Выключен так как уже был показан: "+localStorage.getItem("client_count_show")+" раз."),!1):"start-page-time"!=e&&"no-event"!=e||!sessionStorage.hasOwnProperty("ccPopupShow")||0!=sessionStorage.getItem("ccPopupShow")?!0:(Helper.log("canPopupShow: Выключен так как уже был показан: при загрузке страницы (1 раз, больше не показываем)"),!1)},setPopupShowOn:function(){sessionStorage.setItem("ccPopupShow",1)},setPopupShowOff:function(){sessionStorage.setItem("ccPopupShow",0)},setPopupInitiator:function(e){document.getElementById("cc-popup").dataset.initiator=e},getPopupInitiator:function(){return document.getElementById("cc-popup").getAttribute("data-initiator")},popupOpen:function(e){if(Helper.log("popupOpen: инициатор:"+e),this.setPopupInitiator(e),!this.canPopupShow(e))return!1;if("undefined"!=typeof client_count_show&&"client-click"!=e){var t=localStorage.hasOwnProperty("client_count_show")?parseInt(localStorage.getItem("client_count_show")):0;localStorage.setItem("client_count_show",t+1)}"start-page-time"==e&&this.setPopupShowOff(),document.getElementById("cc-popup").style.display="block",document.getElementById("cc-popup-shadow").style.display="block",document.getElementById("cc-phone").focus(),Helper.cursorSetEnd(document.getElementById("cc-phone"))},popupClose:function(){document.getElementById("cc-popup").style.display="none",document.getElementById("cc-popup-shadow").style.display="none"},sendCall:function(){"undefined"!=eval("typeof yaCounter"+yandex_cn)&&eval("yaCounter"+yandex_cn).reachGoal(yandex_goal),document.getElementById("cc-error").innerHTML="";var phone=document.getElementById("cc-phone").value;if(!/^\+7[0-9]{10}$/.test(phone))return document.getElementById("cc-error").innerHTML="Неверный формат телефона: Телефон должен начинаться с +7 и содержать только цифры",!1;document.getElementById("cc-call").style.display="none",document.getElementById("cc-call1").style.display="inline-block",this.timerId=setTimeout(HtmlEvent.timerDown,1e3);var r=new XMLHttpRequest;r.open("GET",url+"?phone="+phone+"&key="+key+"&initiator="+HtmlEvent.getPopupInitiator(),!0),r.onreadystatechange=function(){if(4==r.readyState&&200==r.status)try{var e=r.responseText;e=JSON.parse(e),console.log(e),console.log(e.result),"object"==typeof e.result}catch(t){Helper.log("Ошибка "+t.name+":"+t.message+"\n"+t.stack)}},r.send()},sendMessage:function(){document.getElementById("cc-message-error").innerHTML="";var e=document.getElementById("cc-name").value.trim(),t=document.getElementById("cc-email").value.trim(),n=document.getElementById("cc-message").value.trim();if(!Helper.validateEmail(t))return document.getElementById("cc-message-error").innerHTML="Неверный формат email.",!1;if(0==e.length||0==t.length||0==n.length)return document.getElementById("cc-message-error").innerHTML="Для отправки сообщения необходимо заполнить все поля.",!1;document.getElementById("cc-message-btn-send").style.display="none",this.timerId=setTimeout(HtmlEvent.timerDown,1e3);var o=new XMLHttpRequest,s="text="+n+"&name="+e+"&email="+t;o.open("POST",url+"?key="+key+"&initiator="+HtmlEvent.getPopupInitiator(),!0),o.onreadystatechange=function(){if(4==o.readyState&&200==o.status)try{var e=o.responseText;e=JSON.parse(e),console.log(e.success),"undefined"!=typeof e.success&&"y"==e.success&&(console.log(e),console.log(document.getElementsByClassName("cc-content-message")[0]),document.getElementsByClassName("cc-content-message")[0].innerHTML='<p class="success">Ваше сообщение оставлено. Спасибо за обращение.</p>')}catch(t){console.log(t),Helper.log("Ошибка "+t.name+":"+t.message+"\n"+t.stack)}},o.send(s)},timerDown:function(){document.getElementById("cc-timer").style.color=color;var e=parseInt(document.getElementById("cc-timer").innerHTML);document.getElementById("cc-timer").innerHTML=e-1,e>1&&(HtmlEvent.timerId=setTimeout(HtmlEvent.timerDown,1e3))}},CallCenterEvent={siteTime:function(){var e=null;clearTimeout(ssTimeVar),sessionStorage.hasOwnProperty("siteShowTimer")&&(e=parseInt(sessionStorage.getItem("siteShowTimer"))),e==parseInt(site_time)?(HtmlEvent.popupOpen("site-timer"),sessionStorage.setItem("siteShowTimer",e+1)):e<parseInt(site_time)&&(ssTimeVar=setTimeout(function(){e+=1,sessionStorage.setItem("siteShowTimer",e),CallCenterEvent.siteTime()},1e3))},noEvent:function(){clearTimeout(idleTimer),idleState=!1,idleTimer=setTimeout(function(){idleState=!0,HtmlEvent.popupOpen("no-event")},idleWait)},pageCountShow:function(){if(sessionStorage.hasOwnProperty("page_count")){var e=JSON.parse(sessionStorage.getItem("page_count")),t=!1;-1==e.indexOf(location.pathname)&&e.push(location.pathname),sessionStorage.setItem("page_count",JSON.stringify(e)),e.length==page_count&&t&&(Helper.log("Запустил функцию показа по числу просмотренных страниц"),HtmlEvent.popupOpen("page-count"))}else{var e=[];e.push(location.pathname),sessionStorage.setItem("page_count",JSON.stringify(e))}return!1},visitCountShow:function(){return localStorage.hasOwnProperty("visit_count")&&!sessionStorage.hasOwnProperty("visit_count")?(localStorage.setItem("visit_count",parseInt(localStorage.getItem("visit_count"))+1),sessionStorage.setItem("visit_count",1)):(localStorage.setItem("visit_count",1),sessionStorage.setItem("visit_count",1)),localStorage.getItem("visit_count")==visit_count&&(Helper.log("Запустил функцию показа по числу посещений"),HtmlEvent.popupOpen("visit-count")),!1}};document.body.insertAdjacentHTML("beforeend",style+htmlInner);var ssTimeVar=null,idleTimer=null,idleState=!1,idleWait=swe;"undefined"!=typeof site_time&&CallCenterEvent.siteTime(),document.addEventListener("mousemove",CallCenterEvent.noEvent),document.addEventListener("keydown",CallCenterEvent.noEvent),document.addEventListener("scroll",CallCenterEvent.noEvent),document.addEventListener("touchstart",CallCenterEvent.noEvent),"undefined"!=typeof page_count&&CallCenterEvent.pageCountShow(),"undefined"!=typeof visit_count&&CallCenterEvent.visitCountShow(),document.getElementsByTagName("body")[0].addEventListener("click",function(e){try{var t=(e.path,!0);"none"==document.getElementById("cc-popup").style.display&&(t=!1);for(var n=e.target.parentElement;null!=n.parentElement;){if("cc-popup"==n.id){t=!1;break}if("cc-phone-button-wrap"==n.id){t=!1;break}n=n.parentElement}t&&HtmlEvent.popupClose()}catch(e){Helper.log(e)}}),document.getElementById("cc-popup-shadow").style.height=height,document.getElementById("cc-phone-button").onclick=function(){HtmlEvent.popupOpen("client-click")},document.getElementById("cc-close").onclick=HtmlEvent.popupClose,document.getElementById("cc-call").onclick=HtmlEvent.sendCall,document.getElementById("cc-message-btn-send").onclick=HtmlEvent.sendMessage,document.getElementById("cc-message-btn").addEventListener("click",function(e){console.log(e),e.target.parentNode.style.display="none",e.target.parentNode.nextElementSibling.style.display="block",document.getElementsByClassName("cc-content")[0].style.display="none",document.getElementsByClassName("cc-content-message")[0].style.display="block"}),document.getElementById("cc-phone-btn").addEventListener("click",function(e){console.log(e),e.target.parentNode.style.display="none",e.target.parentNode.previousElementSibling.style.display="block",document.getElementsByClassName("cc-content")[0].style.display="block",document.getElementsByClassName("cc-content-message")[0].style.display="none"}),"undefined"!=typeof sop&&window.setTimeout(function(){HtmlEvent.popupOpen("start-page-time")},sop)}();