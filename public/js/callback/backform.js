!function(){var e="[style]",t="[html]",o="[url]",n="[key]",c="[color]",l=document.body,s=document.documentElement,i=Math.max(l.scrollHeight,l.offsetHeight,s.clientHeight,s.scrollHeight,s.offsetHeight),u={cursorSetEnd:function(e){if(e.createTextRange){var t=e.createTextRange();t.moveStart("character",e.value.length),t.collapse(),t.select()}else{e.focus();var o=e.value.length;e.setSelectionRange(o,o)}},log:function(e){p&&console.log(e)}},p=!1,a={canPopupShow:function(e){return"client-click"==e?!0:localStorage.hasOwnProperty("client_count_show")&&localStorage.getItem("client_count_show")>=client_count_show?(u.log("canPopupShow: Выключен так как уже был показан: "+localStorage.getItem("client_count_show")+" раз."),!1):"start-page-time"==e&&sessionStorage.hasOwnProperty("ccPopupShow")&&0==sessionStorage.getItem("ccPopupShow")?(u.log("canPopupShow: Выключен так как уже был показан: при загрузке страницы (1 раз, больше не показываем)"),!1):!0},setPopupShowOn:function(){sessionStorage.setItem("ccPopupShow",1)},setPopupShowOff:function(){sessionStorage.setItem("ccPopupShow",0)},setPopupInitiator:function(e){document.getElementById("cc-popup").dataset.initiator=e},getPopupInitiator:function(){return document.getElementById("cc-popup").getAttribute("data-initiator")},popupOpen:function(e){if(u.log("popupOpen: инициатор:"+e),this.setPopupInitiator(e),!this.canPopupShow(e))return!1;if("undefined"!=typeof client_count_show&&"client-click"!=e){var t=localStorage.hasOwnProperty("client_count_show")?parseInt(localStorage.getItem("client_count_show")):0;localStorage.setItem("client_count_show",t+1)}"start-page-time"==e&&this.setPopupShowOff(),document.getElementById("cc-popup").style.display="block",document.getElementById("cc-popup-shadow").style.display="block",document.getElementById("cc-phone").focus(),u.cursorSetEnd(document.getElementById("cc-phone"))},popupClose:function(){document.getElementById("cc-popup").style.display="none",document.getElementById("cc-popup-shadow").style.display="none"},sendCall:function(){document.getElementById("cc-error").style.visibility="hidden";var e=document.getElementById("cc-phone").value,t=document.getElementById("cc-time").value;if(!/^\+7[0-9]{10}$/.test(e))return document.getElementById("cc-error").style.visibility="visible",!1;document.getElementsByClassName("cc-content")[0].innerHTML="Спасибо за обращение, нащи менеджеры свяжутся с вами",document.getElementsByClassName("cc-content")[0].style.lineHeight="259px",document.getElementsByClassName("cc-content")[0].style.fontSize="20px",document.getElementsByClassName("cc-content")[0].style.textAlign="center";var c=new XMLHttpRequest;c.open("GET",o+"?key="+n+"&phone="+e+"&time="+t,!0),c.onreadystatechange=function(){if(4==c.readyState&&200==c.status)try{var e=c.responseText;e=JSON.parse(e),1==e.error&&alert(e.message)}catch(t){console.log(t)}},c.send()},timerDown:function(){document.getElementById("cc-timer").style.color=c;var e=parseInt(document.getElementById("cc-timer").innerHTML);document.getElementById("cc-timer").innerHTML=e-1,e>1&&setTimeout(a.cTimerDown,1e3)}};document.body.insertAdjacentHTML("beforeend",e+t),document.getElementById("cc-popup-shadow").style.height=i,document.getElementById("cc-phone-button").onclick=function(){a.popupOpen("client-click")},document.getElementById("cc-close").onclick=a.popupClose,document.getElementById("cc-call").onclick=a.sendCall}();