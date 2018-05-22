window.fbAsyncInit = function() {
  FB.init({
    appId      : '224427218323289',
    cookie     : true,
    xfbml      : true,
    version    : 'v2.12'
  });
  FB.AppEvents.logPageView();
};

(function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "https://connect.facebook.net/zh_TW/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));

$('.btn-face').click(function(event) {
  //如果用戶沒有登入您的應用程式，或是沒有登入 Facebook，
  // 則使用 FB.login() 以「登入」對話方塊提示用戶，或向用戶顯示「登入」按鈕。
  //教學https://developers.facebook.com/docs/facebook-login/web#redirecturl
  FB.login(function(response) {

    FB.getLoginStatus(function(response){
      //connected = 用戶已登入 Facebook，也已經登入您的應用程式。
      //如果有登入的話就可進行API呼叫
      if(response.status == 'connected'){
        //進行 API 呼叫
        //教學：https://developers.facebook.com/docs/facebook-login/web/accesstokens
        FB.api('/me?fields=id,name,email', function(phpInfo){
          var url = 'api/third_Fb_Login';
          $.post(url, phpInfo, function(res){
            if(res.sys_code == 200){

              window.setTimeout(function(){
                location.href = "https://localhost/travel/";//20180411 reload()->href
              }, 100);
            }else{
              swal(
                'Good job!',
                res.sys_msg,
                'error'
              );
            }
          }, 'json');//$.post
        });//End Api
      }else{
        console.log(response);
      }
    });//End getLoginStatus

  // 選用的 scope 參數可以和函式呼叫一起傳遞，
  // 函式呼叫是用來要求應用程式用戶授權的權限清單（以逗號分隔）。
  //權項清單：https://developers.facebook.com/docs/facebook-login/permissions
  }, {scope: 'public_profile,email'});
});
