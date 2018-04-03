<div class="p-t-31 p-b-9">
  <span class="txt1">
    信箱
  </span>
</div>
<div class="wrap-input100 validate-input" data-validate="信箱必填">
  <input class="input100" type="email" name="email">
  <input type="hidden" name="rule" value='login'>
  <span class="focus-input100"></span>
</div>

<div class="p-t-13 p-b-9">
  <span class="txt1">
    密碼
  </span>

  <a href="forget" class="txt2 bo1 m-l-5">
    忘記密碼
  </a>
</div>
<div class="wrap-input100 validate-input" data-validate="密碼必填">
  <input class="input100" type="password" name="pass">
  <span class="focus-input100"></span>
</div>
<script type="text/javascript">
$(document).ready(function() {
  <?php if(isset($sys_code)){?>
  <?php if($sys_code == 200){?>

        window.setTimeout(function(){
          location.reload();
        }, 100);
      <?php } ?>
      <?php if($sys_code == 404 || $sys_code == 500){?>
        swal(
          '錯誤',
          '<?=$sys_msg;?>',
          'error'
        );
      <?php } ?>
      <?php } ?>
});
</script>
