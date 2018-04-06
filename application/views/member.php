<style>
  .commentys-form > h4, .commentys-form input[type='text'],
  .commentys-form  input[type='email'], .commentys-form  input[type='password'],
  .commentys-form textarea{
    color: white;
  }

  main[role="main-inner-wrapper"] .about-content{
    background: #3085a3;
  }

  input::placeholder{
    font-weight: bold;
    color: #d6d92a;
  }

 .comments-pan{
    border-top: 0;
  }

  .swal2-popup{
    font-size: 2rem;
  }
</style>
<!-- main -->
<main role="main-inner-wrapper" class="container">
  <div class="row">
    <section class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <article role="pge-title-content">
        <header>
          <h2><span>歡迎!</span><?=$this->session->userdata('user_name');?></h2>
        </header>
        <p><?=$instructions;?></p>
      </article>
    </section>

    <section class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <article class="about-content">
        <div class="commentys-form">
          <h4>會員資料</h4>
          <div class="row">
            <form method="post">
              <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <input type="hidden" name="Id" value="<?=$this->session->userdata('user_id');?>">
                <input type="hidden" name="type" value="<?=$type;?>">

                <input name="user_name" type="text"
                placeholder="請輸入姓名"
                value="<?=$user_name;?>">
              </div>

              <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <input name="user_email" type="email"
                placeholder="請輸入email"
                value="<?=$user_email;?>">
              </div>

              <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <input name="user_phone" type="text"
                placeholder="自行決定是否輸入手機號碼"
                value="<?=$user_phone;?>">
              </div>

              <div class="clearfix"></div>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="padding-top:3%">
                  <input name="password" type="password"
                  placeholder="如要更改密碼請輸入新密碼">
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="padding-top:3%">
                  <input name="repassword" type="password"
                  placeholder="請重新輸入新密碼">
                </div>

              <div class="text-center">
                <input type="hidden" name="rule" value="update">
                <input id="update" type="button" value="更新">
              </div>
            </form>
          </div>
        </div>
        <!-- <p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc, fiant sollemnes in futurum.</p>
        <p>Claritas est etiam processus dynamicus, qui sequitur mutationem consueum formas humanitatis per seacula quarta deciEodem modo tythepi, qui nunc, fiant sollemnes in futurum.</p> -->
      </article>
    </section>

    <!-- Comments -->
    <div class="comments-pan">
      <div class="clearfix"></div>
      <h3>&nbsp;</h3>
      <ul class="comments-reply">
          <h3>景點留言</h3>
        <li>
          <table id="example" class="table table-striped table-hover table-bordered dt-responsive nowrap" style="width:100%">
          <thead>
            <tr>
              <th>地區</th>
              <th>景點名</th>
              <th>開放時間</th>
              <th>電話</th>
              <th>地址</th>
              <th>您的留言</th>
              <th>留言時間</th>
              <!-- <th>Extn.</th>
              <th>E-mail</th> -->
            </tr>
          </thead>
          <tbody>
          <?php for ($i=0; $i < count($AM); $i++) { ?>
            <tr class="success" data-id=<?=$AM[$i]['id'];?>>
              <?php for ($j=0; $j < 1; $j++){ ?>
                <td><?=$Att[$i][$j]['ch_place'];?></td>
                <td><?=$Att[$i][$j]['Name'];?></td>
                <td><?=$Att[$i][$j]['Opentime'];?></td>
                <td><?=$Att[$i][$j]['Tel'];?></td>
                <td><?=$Att[$i][$j]['Add'];?></td>
              <?php } ?>
              <td><?=$AM[$i]['message'];?></td>
              <td><?=$AM[$i]['create_date'].'|'.$AM[$i]['create_time'];?></td>
            </tr>
          <?php } ?>

          </tbody>
        </table>
          <!-- <figure> -->
            <!-- <img src="images/blog-images/image-1.jpg" alt="" class="img-responsive"/> -->
          <!-- </figure>

          <section>
            <h4>Anna Greenfield      <a href="#">Reply</a></h4>
            <div class="date-pan">January 26, 2016</div>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed volutpat eu nibh ultricies semper. Vivamus porta, felis vitae facilisis sodales, felis est iaculis orci, et ornare sem mauris ut turpis. Pellentesque vitae tortor nec tellus hendrerit aliquam. Donec condimentum leo eu ullamcorper scelerisque pellentesque urna rhoncus.
          </section> -->
        </li>

        <li>
          <figure>
            <!-- <img src="images/blog-images/image-3.jpg" alt="" class="img-responsive"/> -->
          </figure>

          <section>
            <h4>Anna Greenfield  <a href="#">Reply</a></h4>
            <div class="date-pan">January 26, 2016</div>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed volutpat eu nibh ultricies semper. Vivamus porta, felis vitae facilisis sodales, felis est iaculis orci, et ornare sem mauris ut turpis. Pellentesque vitae tortor nec tellus hendrerit aliquam. Donec condimentum leo eu ullamcorper scelerisque pellentesque urna rhoncus.
          </section>
        </li>
      </ul>

      <div class="commentys-form">
        <h4>Leave a comment</h4>
        <div class="row">
          <form action="" method="get">
            <div class="col-xs-12 col-sm-4 col-md-4">
              <input name="" type="text" placeholder="Whats your name *">
              <!-- <input name="" type="text" placeholder="Whats your name *"> -->
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
              <input name="" type="email" placeholder="Whats your email *">
              <!-- <input name="" type="email" placeholder="Whats your email *"> -->
            </div>

            <div class="col-xs-12 col-sm-4 col-md-4">
              <input name="" type="url" placeholder="Runing a Website">
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-12 col-sm-12 col-md-12">
              <textarea name="" cols="" rows=""  placeholder="Whats in your mind"></textarea>
            </div>
            <div class="text-center">
              <input type="button" value="Post Comment">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
<!-- main -->

<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-label="@mdo">Open modal for @mdo</button> -->

<script type="text/javascript">
$(document).ready(function() {
  $('#example').DataTable();
  $('#example2').DataTable();
  $('tr').on('click', function (event) {

    var id = $(this).data("id");

    $.ajax({
      url: 'Att_and_Am',
      type: 'POST',
      dataType: 'json',
      data: {id: id}
    })
    .done(function(res) {

      swal({
        title: res.Place.ch_place+"-"+res.Att.Name,
        imageUrl: res.Att.Picture,
        html:"<p class='bg-info' style='font-size:20px;'>"+res.Att.Description+"</p><p class='bg-danger text-left'>開放時間："+res.Att.Opentime+"<br/>電話："+res.Att.Tel+"<br/>地址："+res.Att.Add+"</p><p class='bg-success text-left'>您的留言："+res.Am.message+"</p>",
        imageAlt: 'Custom image',
        showCancelButton: true,
        cancelButtonText:　"關閉",
        cancelButtonColor: '#3085d6',
        confirmButtonText: '刪除留言',
        confirmButtonColor: '#d33'
      }).then((result) => {
        if (result.value) {
          // $.post('Delete_Am',{am_id: res.Am.am_id,id: res.Am.id,email: res.Am.email}, function(res){
          //   console.log(res);
          // }, 'json');

          $.ajax({
            url: 'Delete_Am',
            type: 'POST',
            dataType: 'json',
            data: {
              am_id: res.Am.am_id,
              id: res.Am.id,
              email: res.Am.email
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
        }
      });
    })
    .fail(function() {
      console.log("error");
    });

  });
});
</script>
