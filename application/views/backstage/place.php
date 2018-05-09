<!-- add in 20180507 -->
<style media="screen">
  .text-muted{
    color: red !important;
  }
</style>
<!-- add in 20180507 -->
  <div class="breadcrumbs">
    <div class="col-sm-4">
      <div class="page-header float-left">
        <div class="page-title">
          <h1><?=$title;?></h1>
        </div>
      </div>
    </div>
    <div class="col-sm-8">
      <div class="page-header float-right">
        <div class="page-title">
          <ol class="breadcrumb text-right">
            <li><a href="#"><?=$breadcrumb_title;?></a></li>
            <li class="active"><?=$title;?></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="content mt-3">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <strong>新增</strong>地區名
            </div>
            <form  method="post" id="form" enctype="multipart/form-data" class="form-horizontal">
              <div class="card-body card-block">
                <div class="row form-group">
                  <div class="col col-md-3"><label for="ch_place" class=" form-control-label">中文地區名</label></div>
                  <input type="hidden" name="rule" value="New_place">
                  <div class="col-12 col-md-9">
                    <input type="text" id="ch_place" name="ch_place" placeholder="請輸入中文地區名" class="form-control">
                    <small class="form-text text-muted">*必填</small>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-3"><label for="en_place" class=" form-control-label">英文地區名</label></div>
                  <div class="col-12 col-md-9">
                    <input type="text" id="en_place" name="en_place" placeholder="請輸入英文地區名" class="form-control">
                    <small class="form-text text-muted">*必填</small>
                  </div>
                </div>
              </div><!-- card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">
                  <i class="fa fa-dot-circle-o"></i> 送出
                </button>
                <button type="reset" class="btn btn-danger btn-sm">
                  <i class="fa fa-ban"></i> 重填
                </button>
              </div><!-- card-footer -->
            </form>
          </div>
        </div><!-- col-lg-6 -->

      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <strong class="card-title">地區總攬</strong>
          </div>
          <div class="card-body">
            <table id="bootstrap-data-table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>中文地區名</th>
                  <th>英文地區名</th>
                  <th>最後日期</th>
                  <th>最後時間</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($place as $key => $value){ ?>
                  <tr data-id='<?=$value['id'];?>'>
                    <td><?=$value['ch_place'];?></td>
                    <td><?=$value['en_place'];?></td>
                    <td><?=$value['update_date'];?></td>
                    <td><?=$value['update_time'];?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div><!-- card-body -- >
        </div><!-- card -->
      </div><!-- col-lg-6 -->
    </div><!-- .row -->
  </div><!-- .animated -->
</div><!-- .content -->

<!-- add in 20180430 -->
<script type="text/javascript">
$(document).ready(function() {
  $("button[type='submit']").click(function(event) {
    var ch_place = $('#ch_place').val();
    var en_place = $('#en_place').val();
    if (ch_place == "" && en_place == "") {
      swals(
        '有錯誤!',
        '不能為空',
        'error'
      );
      return false;
    }
  });

  $('tr').click(function(event) {
    var id = $(this).data("id");
    var ch_place = $(this).find('td').eq(0).text().trim();
    var en_place = $(this).find('td').eq(1).text().trim();
    testSweetalert(id, ch_place, en_place);
  });

  <?php if (isset($sys_code) && !empty($sys_code)) { ?>
    swals(
      '<?=$sys_msg_title;?>',
      '<?=$sys_msg;?>',
      '<?=$status;?>'
    );
  <?php } ?>
});

function swals(sys_msg_title, sys_msg, status){
  swal(
    sys_msg_title,
    sys_msg,
    status
  ).then(function(){
    location.href = './place';
  });
}

async function testSweetalert(id, ch_place, en_place) {
  const {value: formValues} = await swal({
    title: '要修改還是刪除ㄋ?',
    html:
    "<input id='ed_ch_place' class='swal2-input' placeholder='請輸入中文地區名' value='"+ch_place+"'>" +
    "<input id='ed_en_place' class='swal2-input' placeholder='請輸入英文地區名' value='"+en_place+"'>",
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '<i class="fa fa-refresh"></i>更新資料',//20180506 加入icon
    cancelButtonText: '<i class="fa fa-times-circle"></i>刪除資料',//20180506 加入icon
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger',
    buttonsStyling: false,
    reverseButtons: true
  }).then((result) => {
    if (result.value) {//增加編輯地區功能 in 20180506
      var ed_ch_place = $('#ed_ch_place').val();
      var ed_en_place = $('#ed_en_place').val();

      $.ajax({
        url: '../do_place',
        type: 'POST',
        dataType: 'json',
        data: {
          rule: 'Edit',
          place_id: id,
          ed_ch_place: ed_ch_place,
          ed_en_place: ed_en_place
          }
      })
      .done(function(ResOk) {
        if(ResOk.sys_code != ""){
          swals(ResOk.sys_title, ResOk.sys_msg, ResOk.status);
        }
      })
      .fail(function(ResError) {
        console.log(ResError);
      });

    }else if(result.dismiss === swal.DismissReason.cancel) {//刪除

      $.ajax({
        url: '../do_place',
        type: 'POST',
        dataType: 'json',
        data: {
          rule: 'Delete',
          place_id: id
          }
      })
      .done(function(ResOk) {
        if(ResOk.sys_code != ""){
          swals(ResOk.sys_title, ResOk.sys_msg, ResOk.status);
        }
      })
      .fail(function(ResError) {
        console.log(ResError);
      });
    }
  });

}
</script>
<!-- add in 20180430 -->
