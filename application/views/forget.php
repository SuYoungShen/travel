<?php if($this->session->flashdata('news')){?>
  <div class="p-t-31 p-b-9">
    <span class="txt1">
      新密碼
    </span>
  </div>
  <div class="wrap-input100 validate-input" data-validate="密碼必填">
    <input class="input100" type="password" name="password">
    <input type="hidden" name="rule" value='news'>
    <input type="hidden" name="id" value="<?=$this->session->flashdata('news');?>">
    <span class="focus-input100"></span>
  </div>
  <div class="p-t-31 p-b-9">
    <span class="txt1">
      再次輸入新密碼
    </span>
  </div>
  <div class="wrap-input100 validate-input" data-validate="重複密碼必填">
    <input class="input100" type="password" name="re-password">
    <span class="focus-input100"></span>
  </div>
<?php }else { ?>
<div class="p-t-31 p-b-9">
  <span class="txt1">
    信箱
  </span>
</div>
<div class="wrap-input100 validate-input" data-validate="信箱必填">
  <input class="input100" type="email" name="email">
  <input type="hidden" name="rule" value='forget'>
  <span class="focus-input100"></span>
</div>
<div class="p-t-31 p-b-9">
  <span class="txt1">
    手機
  </span>
</div>
<div class="wrap-input100 validate-input" data-validate="手機必填">
  <input class="input100" type="text" name="phone">
  <span class="focus-input100"></span>
</div>
<?php } ?>
<script type="text/javascript">
$(document).ready(function() {
  <?php
    if(isset($sys_code)){
      if($sys_code == 200){ ?>
          swal(
            'Good job!',
            '<?=$sys_msg;?>',
            'success'
          ).then(function (){
          });

    <?php }else if($sys_code == 404 || $sys_code == 500){ ?>
        swal(
          'Good job!',
          '<?=$sys_msg;?>',
          'error'
        );
    <?php
  }else if($sys_code == "ok"){
    ?>
        swal(
          'Good job!',
          '<?=$sys_msg;?>',
          'success'
        ).then(function (){
          location.href = '<?=base_url('login');?>';
        });
    <?php
        }
      }
    ?>
});
</script>
