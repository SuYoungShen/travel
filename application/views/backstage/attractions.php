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
                          </tr>
                        </thead>
                        <tbody>
                          <?php  foreach ($attractions as $key => $value) { ?>
                            <tr data-id = '<?=$value['id'];?>'>
                              <td><?=$value['Name'];?></td>
                              <td><?=$value['Opentime'];?></td>
                              <td><?=$value['Tel'];?></td>
                              <td><?=$value['Add'];?></td>
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
<button type="button" name="button" id='test'>刪除</button>
