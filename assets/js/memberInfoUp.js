
$("#update").click(function(event) {
  var user_name = $("input[name=user_name]").val();
  var type = $("input[name=type]").val();
  var user_email = $("input[name=user_email]").val();
  var user_phone = $("input[name=user_phone]").val();
  var password = $("input[name=password]").val();
  var repassword = $("input[name=repassword]").val();

  if(type == "normal"){
    if(user_name != "" && user_email != "" &&
    password != ""){
      if(password == repassword){
        var data = {
          nickname:user_name,
          email:user_email,
          phone:user_phone,
          password:password,
          type:type
        };

      }else{
        swalls('密碼輸入不一致','請輸入正確','error');
      }
    }else{
      if(password == ""){
        swalls('資料請填寫完整','如要更新資料，請密碼也填寫','error');
      }else{
        swalls('資料請填寫完整','姓名與Email必填，如要更新資料，請密碼也填寫','error');
      }
    }
  }else{
    if(user_name != "" && user_email != ""){
      var data = {
        nickname:user_name,
        email:user_email,
        phone:user_phone,
        type:type
      };

    }else{
      swalls('資料請填寫完整','姓名或email不得為空','error');
    }
  }
  memberInfoUp(data);
});

function swalls(instruction, instructions, status){
  swal(
    instruction,
    instructions,
    status
  ).then(function (){
    location.reload();
  });
}
function memberInfoUp(datas){
  var rule = $("input[name=rule]").val();
  $.ajax({
    type: 'POST',
    dataType: 'json',
    data: {rule: rule, datas: datas}
  })
  .done(function(res) {
    
    swalls(res.sys_title, res.sys_msg, res.sys_status);
  });
}
