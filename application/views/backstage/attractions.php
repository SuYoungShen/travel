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
    var DataTable = $('#bootstrap-data-table').DataTable();

    $('#select').change(function(event){
      $.ajax({
        url: 'attractions',
        type: 'POST',
        dataType: 'json',
        data: {
          place: $(this).val()
        }
      })
      .done(function(ok) {
        console.log('ok');
        DataTable.rows().remove().draw(false);
        $(ok).each(function(index, val) {
          var row = DataTable.row.add([//add td 內容 in 20180507
            val.Name,
            val.Opentime,
            val.Tel,
            val.Add,
            val.Update_Date//add in 20180509
          ]).draw(false).nodes();//nodes get tr attr  in 20180507
          $(row).attr('data-id', val.id);//增加被點選tr得屬性  in 20180507
        });
          // chick_tr();
      })
      .fail(function(error) {
        console.log('error');
        console.log(error);
      });
    });
    //add 個別景點資訊 in 20180509
    $('#bootstrap-data-table tbody').on( 'click', 'tr', function (event) {

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
            html:
            "<textarea id='Description' class='swal2-textarea bg-info' style='color:white;'>"+ResOk.one_att.Description+"</textarea>"+
            "開放時間：<input id='Opentime' class='swal2-input bg-danger text-left' style='color:white;' value='"+ResOk.one_att.Opentime+"'>"+
            "電話：<input id='Tel' class='swal2-input bg-danger text-left' style='color:white;' value='"+ResOk.one_att.Tel+"'>"+
            "地址：<input id='Add' class='swal2-input bg-danger text-left' style='color:white;' value='"+ResOk.one_att.Add+"'>",
            imageAlt: 'Custom image',
            showCancelButton: true,
            cancelButtonText:　"更新",
            cancelButtonColor: 'green',
            confirmButtonText: '刪除景點',
            confirmButtonColor: '#d33'
          }).then((result) => {
            if (result.value) {//刪除
              $.ajax({
                url: '../de_ed_att',
                type: 'POST',
                dataType: 'json',
                data: {
                  id: id,
                  place: place,
                  type: 0,
                  rule: 'Delete'
                }
              })
              .done(function(resOK) {
              if(resOK.sys_code == 200 || resOK.sys_code == 404){
                swal(
                  resOK.sys_title,
                  resOK.sys_msg,
                  resOK.status
                ).then(function(){
                  location.reload();
                });
              }//End if
              });//End done
            }else if(result.dismiss === swal.DismissReason.cancel) {//編輯

              $.ajax({
                url: '../de_ed_att',
                type: 'POST',
                dataType: 'json',
                data: {
                  id: id,
                  place: place,
                  Description: $('#Description').val(),
                  Opentime: $('#Opentime').val(),
                  Tel: $('#Tel').val(),
                  Add: $('#Add').val(),
                  type: 0,
                  rule: 'Edit'
                }
              })
              .done(function(resOK) {
                if(resOK.sys_code == 200 || resOK.sys_code == 404){
                  swal(
                    resOK.sys_title,
                    resOK.sys_msg,
                    resOK.status
                  ).then(function(){
                    location.reload();
                  });
                }//End if
              }).fail(function(ResError) {
                console.log("error");
                console.log(ResError);
              });//End done
            }//End 編輯
          });//End Result
        });//End done
      }//End else
    });//End tr
  });
</script>
