<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


Route::get('/home',function(){
   return redirect('/');
});

Route::get('/',function(Request $request){
    if (Auth::guest())
    {
        if ($request::ajax())
        {
            return response('Unauthorized.', 401);
        }
        else
        {
            return redirect()->guest('auth/login');
        }
    }elseif(Auth::user()->role()->first()->code=="client")
    {
        return  redirect(url('/claim'));
    }else
    {
       return  redirect(url('/project'));
    }
});


Route::resource('project','ProjectController');

Route::resource('claim','ClaimController');
Route::post('claim/statuschange',function(Request $request){
    if (Auth::guest())
    {
        if ($request::ajax())
        {
            return response('Unauthorized.', 401);
        }
        else
        {
            return redirect()->guest('auth/login');
        }
    }

    $id  = Request::get('id');
    $claim =App\Claim::findOrFail($id);
    $claim->status = Request::get('status');
    $claim->note = Request::get('note');
    $claim->save();
    return redirect("claim/$id");

});


Route::resource('user','UserController');

Route::resource('property','PropertyController');

/**
 * Тестовая форма
 **/
Route::get('externform',function(){
    \Debugbar::disable();
    $style="
        <style>
            #cc-phone-button-wrap{
                width:70px;
                height:70px;
                border-radius: 100%;
                position: fixed;
                top:50%;
                right:10px;
                margin-top: -35px;
                text-align: center;
                vertical-align: middle;
                line-height: 70px;
                z-index: 1000;
            }


            #cc-phone-button{
                vertical-align: middle;
                display: inline-block;
                border-radius: 100%;
                width:60px;
                height:60px;
                cursor:pointer;
                background: #009321 url(\"http://".$_SERVER['SERVER_NAME']."/i/phone.png\") no-repeat center;
                animation: vibro 3s infinite ;
                -webkit-animation: vibro 3s infinite ;
                -moz-animation: vibro 3s infinite ;
                -ms-animation: vibro 3s infinite ;
                -o-animation: vibro 3s infinite ;
            }

            @keyframes vibro {
              0% {
                transform: rotate(0deg)
              }
              10% {
                transform: rotate(-15deg)
              }

              15% {
                transform: rotate(15deg)
              }
              16% {
                transform: rotate(0deg)
              }
              94% {
                transform: rotate(0deg)
              }
              95% {
                transform: rotate(-15deg)
              }
              100% {
                transform: rotate(20deg)
              }
            }

            @-webkit-keyframes vibro {
              0% {
                transform: rotate(0deg)
              }
              10% {
                transform: rotate(-15deg)
              }

              15% {
                transform: rotate(15deg)
              }
              16% {
                transform: rotate(0deg)
              }
              94% {
                transform: rotate(0deg)
              }
              95% {
                transform: rotate(-15deg)
              }
              100% {
                transform: rotate(20deg)
              }
            }

            @-moz-keyframes vibro {
              0% {
                transform: rotate(0deg)
              }
              10% {
                transform: rotate(-15deg)
              }

              15% {
                transform: rotate(15deg)
              }
              16% {
                transform: rotate(0deg)
              }
              94% {
                transform: rotate(0deg)
              }
              95% {
                transform: rotate(-15deg)
              }
              100% {
                transform: rotate(20deg)
              }
            }

            @-ms-keyframes vibro {
              0% {
                transform: rotate(0deg)
              }
              10% {
                transform: rotate(-15deg)
              }

              15% {
                transform: rotate(15deg)
              }
              16% {
                transform: rotate(0deg)
              }
              94% {
                transform: rotate(0deg)
              }
              95% {
                transform: rotate(-15deg)
              }
              100% {
                transform: rotate(20deg)
              }
            }

            @-o-keyframes vibro {
              0% {
                transform: rotate(0deg)
              }
              10% {
                transform: rotate(-15deg)
              }

              15% {
                transform: rotate(15deg)
              }
              16% {
                transform: rotate(0deg)
              }
              94% {
                transform: rotate(0deg)
              }
              95% {
                transform: rotate(-15deg)
              }
              100% {
                transform: rotate(20deg)
              }
            }

            #cc-popup-shadow{
                position: fixed;
                _position:absolute;
                left: 0;
                top: 0;
                _top:expression(eval(document.body.scrollTop));
                width: 100%;
                height: 100%;
                z-index: 10000;
                background: rgba(0, 0, 0, 0.8);
                display: none;
            }
            #cc-popup{
                width:700px;
                height:298px;
                border: 1px solid #ccc;
                border-radius: 5px;
                position: fixed;
                _position:absolute;
                z-index:10005;
                left: 50%;
                top:50%;
                _top:expression(eval(document.body.scrollTop));
                margin-top:-150px;
                margin-left: -351px;
                overflow: hidden;
                font-family: arial, Helvetica, sans-serif;
                line-height:normal;
                box-sizing: border-box;
                display: none;
            }
            #cc-popup .cc-content{
                position:relative;
                height:259px;
                background-color: #ededed;
            }

            #cc-popup .cc-close{
                position: absolute;
                right: 0;
                top: 0;
                width: 41px;
                height:41px;
                background: #566473 url(\"http://".$_SERVER['SERVER_NAME']."/i/close.png\") no-repeat center;
                cursor: pointer;
                z-index:2000;
            }

            #cc-popup .cc-close:hover{
                background-color:#009321;
            }

            #cc-popup .cc-content span.cc-head{
                position:relative;
                font-family: arial, Helvetica, sans-serif;
                margin: 0px;
                font-size: 24px;
                text-align: center;
                padding: 50px 0 ;
                color: #566473;
                font-weight: normal;
                display:block;
            }

            #cc-popup .cc-content .cc-head .cc-bold{
                font-weight: bold;
            }

            #cc-popup span#cc-call{
                font-family: arial, Helvetica, sans-serif;
                font-size: 18px;
                color: #fff;
                border: 1px solid #b2b2b2;
                background-color: #33a94d;
                text-decoration: none;
                border-radius: 3px;
                padding: 10px 0;
                width:188px;
                display: inline-block;
                vertical-align:top;
                cursor:pointer;
            }

            #cc-popup span#cc-call1{
                font-family: arial, Helvetica, sans-serif;
                font-size: 18px;
                color: #fff;
                border: 1px solid #b2b2b2;
                background-color: #566473;
                text-decoration: none;
                border-radius: 3px;
                padding: 10px 0;
                width:188px;
                display: none;
                vertical-align:top;
                cursor:pointer;
            }

            #cc-popup span#cc-call:hover{
                background-color: #009321;
            }


            #cc-popup input[type=\"text\"] {
                color:#566473;
                border-radius: 3px;
                padding: 10px;;
                font-size: 18px;
                border: 1px solid #b2b2b2;
                width:244px;
                line-height: inherit;
                letter-spacing: normal;
                word-spacing: normal;
                text-transform: none;
                text-indent: 0px;
                text-shadow: none;
                display: inline-block;
                text-align: start;
                box-sizing: border-box;
                vertical-align:top;
                position:relative;
            }

            #cc-popup .cc-wrapper{
                text-align: center;
                width:100%;
                position:relative;
            }

            #cc-error{
                margin-left:122px;
                text-align:left;
                color:red;
                padding:10px;
                width: 440px;
                font-size: 12px;
            }

            #cc-popup .cc-footer{
                font-family: arial, Helvetica, sans-serif;
                font-size: 14px;
                text-align: right;
                color: #566473;
                padding-top:8px;
                padding-right: 41px;
                background-color:#fff;
                height:37px;
                position:relative;
            }
        </style>
       ";

    $script = "
            var body = document.body;
            var html = document.documentElement;
            var height = Math.max( body.scrollHeight, body.offsetHeight,html.clientHeight, html.scrollHeight, html.offsetHeight );
            $(\"#cc-popup-shadow\").css(\"height\",height);
        ";

    $html = '
        <div id="cc-phone-button-wrap"><div onclick="cPopupOpen()" id="cc-phone-button"></div></div>
        <div id="cc-popup-shadow"></div>
        <div id="cc-popup">
        <div class="cc-close" onclick="cPopupClose()"></div>
        <div class="cc-content">
            <span class="cc-head">Оставьте свой номер и мы перезвоним Вам<br> в течение <span class="cc-bold" id="cc-timer">30</span> <span class="cc-bold">секунд</span>!</span>
            <div class="cc-wrapper">
                <input id="cc-phone" type = "text" value="+7"> <span id="cc-call" onClick="cSendCall()" href="#">Жду звонка</span><span id="cc-call1" href="#">Жду звонка</span>
                <div id="cc-error"></div>
            </div>
        </div>
        <div class="cc-footer">
            Call-центр №1
        </div>
    </div>
    ';


    $style = trim(preg_replace('/\s\s+/', '', $style));
    $html = trim(preg_replace('/\s\s+/', '', $html));
    $script = trim(preg_replace('/\s\s+/', '', $script));

    $result = "
            function cPopupClose(){
                document.getElementById(\"cc-popup\").style.display=\"none\";
                document.getElementById(\"cc-popup-shadow\").style.display=\"none\";
            }
            function cPopupOpen(){
                document.getElementById(\"cc-popup\").style.display=\"block\";
                document.getElementById(\"cc-popup-shadow\").style.display=\"block\";
                var focusC =  document.getElementById(\"cc-phone\").value;
                document.getElementById(\"cc-phone\").focus();
                cSetEnd(document.getElementById(\"cc-phone\"));

            }

            function cSetEnd(txt) {
                if (txt.createTextRange) {
                    var FieldRange = txt.createTextRange();
                    FieldRange.moveStart(\"character\", txt.value.length);
                    FieldRange.collapse();
                    FieldRange.select();
                }else{
                    txt.focus();
                    var length = txt.value.length;
                    txt.setSelectionRange(length, length);
                }
            }


            function cSendCall(){
                document.getElementById(\"cc-error\").innerHTML=\"\";
                var phone =document.getElementById(\"cc-phone\").value;
                if(!/^\\+7[0-9]{10}$/.test(phone)){
                    document.getElementById(\"cc-error\").innerHTML=\"Неверный формат телефона: Телефон должен начинаться с +7 и содержать только цифры\";
                    return false;
                }
                document.getElementById(\"cc-call\").style.display = \"none\";
                document.getElementById(\"cc-call1\").style.display = \"inline-block\";
                setTimeout(cTimerDown,1000);
                var r = new XMLHttpRequest();
                r.open(\"GET\",\"".url('externcall')."?phone=\"+phone, true);
                r.onreadystatechange = function () {
                    if (r.readyState != 4 || r.status != 200) return;
                };
                r.send();
            }

            function cTimerDown(){
                document.getElementById(\"cc-timer\").style.color = \"#009321\";
                var timer = parseInt(document.getElementById(\"cc-timer\").innerHTML);
                document.getElementById(\"cc-timer\").innerHTML = timer-1;
                if(timer>1) setTimeout(cTimerDown,1000);
            }
            ;(function(){
                document.body.insertAdjacentHTML('afterend','".$style.$html."');
                window.setTimeout(function(){
                    cPopupOpen();
                }, 30000);
                ".$script.";
            })();";
    $result = trim(preg_replace('/\s\s+/', '', $result));

    return response ($result)->header('Content-Type','text/javascript');
});

/**
 * Тестовая форма
 **/
Route::get('getform',function(){
    return view('home');
});

/**
 * Тестоввый звонок
 **/
Route::get('externcall',function(){
    \Debugbar::disable();
    $phone = Request::input('phone');
    if(!empty($phone))
    {
        $callerId = "101";
        $oSocket = fsockopen(env('Asterisk_host'), env('Asterisk_port'), $errnum, $errdesc,50) or die("Connection to host failed");

        fputs($oSocket, "Action: Login\r\n");
        fputs($oSocket, "Username: ".env('Asterisk_user')."\r\n");
        fputs($oSocket, "Secret: ".env('Asterisk_secret')."\r\n\r\n");


        fputs($oSocket, "Action: originate\r\n");
        fputs($oSocket, "Channel: ".env('Asterisk_channel')."\r\n");
        fputs($oSocket, "Timeout: ".env('Asterisk_timeout')."\r\n");
        fputs($oSocket, "CallerId: ".$callerId."\r\n");
        fputs($oSocket, "Exten: ".Request::input('phone')."\r\n");
        fputs($oSocket, "Context: ".env('Asterisk_context')."\r\n");
        fputs($oSocket, "Priority: ".env('Asterisk_priority')."\r\n\r\n");
        fputs($oSocket, "Action: Logoff\r\n\r\n");

        sleep (1);
        fclose($oSocket);
        return response(Request::input('phone'))->header('Access-Control-Allow-Origin', 'http://shop.goodline.ru');
        //return response()->header('Access-Control-Allow-Origin', 'http://shop.goodline.ru');
    }else{
        return response('Не введен номер')->header('Access-Control-Allow-Origin', 'http://shop.goodline.ru');
    }
});