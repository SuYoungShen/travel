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
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <strong class="card-title"><?=$title;?></strong>
                    </div>
                    <div class="col-md-2">

                      <select name="select" id="select" class="form-control btn btn-outline-primary btn-block">
                        <?php foreach ($place as $key => $value){ ?>
                          <option value="<?=$value['en_place'];?>"><?=$value['ch_place'];?></option>
                        <?php } ?>
                      </select>

                    </div>
                    <div class="card-body">
                      <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>名稱</th>
                            <th>開放時間</th>
                            <th>電話</th>
                            <th>地址</th>
                            <th>更新</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php  foreach ($attractions as $key => $value) { ?>
                            <tr data-id='<?=$value['id'];?>'>
                              <td><?=$value['Name'];?></td>
                              <td><?=$value['Opentime'];?></td>
                              <td><?=$value['Tel'];?></td>
                              <td><?=$value['Add'];?></td>
                              <td><?=$value['Update_Date'];?></td>
                            </tr>
                          <?php  } ?>

                        </tbody>
                      </table>
                    </div><!-- card-body -- >
                  </div><!-- card -->
                </div><!-- col-md-12 -->
              </div><!-- row -- >
          </div><!-- .animated -->
      </div><!-- .content -->
  </div><!-- /#right-panel -->
  <!-- Right Panel -->

<script type="text/javascript">
  $(document).ready(function() {

  

    //add 個別景點資訊 in 20180509
    $('tr').on('click', function (event) {
      var id = $(this).data('id');
      var place = $("#select").val();
      if (id == "") {
        swal(
          '有錯誤!',
          '不能為空',
          'error'
        );
        return false;
      }else {
        $.ajax({
          url: '../do_attractions',
          type: 'POST',
          dataType: 'json',
          data: {
            id: id,
            place: place
          }
        })
        .done(function(ResOk) {
          // console.log("success");
          // console.log(ResOk);
          swal({
            title: "景點-"+ResOk.one_att.Name,
            imageUrl: ResOk.one_att.Picture,
            html:"<p class='bg-info' style='font-size:20px;color:white'>"+ResOk.one_att.Description+"</p><p class='bg-danger text-left' style='color:white;'>開放時間："+ResOk.one_att.Opentime+"<br/>電話："+ResOk.one_att.Tel+"<br/>地址："+ResOk.one_att.Add+"</p>",
            imageAlt: 'Custom image',
            showCancelButton: true,
            cancelButtonText:　"關閉",
            cancelButtonColor: '#3085d6',
            confirmButtonText: '刪除景點',
            confirmButtonColor: '#d33'
          }).then((result) => {
            if (result.value) {
              // $.ajax({
              //   url: 'delete_UL',
              //   type: 'POST',
              //   dataType: 'json',
              //   data: {
              //     like_id: res.user_like[0].id,//更新成此格式 in 20180409
              //     place_id: res.user_like[0].place_id//更新成此格式 in 20180409
              //   }
              // })
              // .done(function(resOK) {
                // if(resOK.sys_code == 200 || resOK.sys_code == 404){
                //   swal(
                //     resOK.sys_title,
                //     resOK.sys_msg,
                //     resOK.status
                //   ).then(function(){
                //     location.reload();
                //   });
                // }//End if
              // });//End done
            }
          });
        })//done
        .fail(function(ResError) {
          console.log("error");
          console.log(ResError);
        });
      }
    });
  });
</script>
