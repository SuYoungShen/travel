<main role="main-inner-wrapper" class="container" onload="initialize()" onunload="GUnload()">
    <div class="blog-details">
      <article class="post-details" id="post-details">
        <header role="bog-header" class="bog-header text-center">
          <h2><?=$place.$travel;?></h2>
          <h3><span><?=$Name;?></span><?php //echo $Title;?></h3>
        </header>
        <?php if ($Count <= 1){ ?>
          <div align = "center">
            <img src="<?=$Images; ?>" alt="" class="img-responsive"/>
          </div>
        <?php }else{ ?>
          <div id="myCarousel" class="carousel slide " data-ride="carousel">

            <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <?php for($i=1; $i < $Count; $i++){ ?>
                <li data-target="#myCarousel" data-slide-to="<?=$i;?>"></li>
              <?php } ?>
            </ol>

            <div class="carousel-inner">

              <div class="item active">
                <img src="<?=$Images; ?>" alt="" class="img-responsive"/>
              </div>
              <?php for($i=1; $i < $Count; $i++){ ?>
                <div class="item">
                  <img src='<?php echo $Images; ?>' alt="" class="img-responsive"/>
                </div>
              <?php } ?>
            </div>

            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        <?php } ?>
        <div class="enter-content">
          <p class="bg-info"><?=$Introduction;?></p>
          <p class="bg-danger">
            <?=$OpenTime;?><br/>
            <?=$Tel;?><br/>
            <?=$FullAddress;?><br/>
            <?=$Driving;?>
          </p>
          <?=$map['html'];?>
        </iframe>
        <!-- <a href="https://www.google.com.tw/maps/place/屏東市大洲里65號">S</a> -->
        </div>

      <div class="comments-pan">
        <h3>3 Comments</h3>
        <ul class="comments-reply">
          <li>
            <!-- <figure>
            <img src="http://i-pingtung.com/Utility/DisplayImage?id=11160" alt="" class="img-responsive"/>
            </figure> -->

            <section>
            <h4>Anna Greenfield      <a href="#">Reply</a></h4>
            <div class="date-pan">January 26, 2016</div>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed volutpat eu nibh ultricies semper. Vivamus porta, felis vitae facilisis sodales, felis est iaculis orci, et ornare sem mauris ut turpis. Pellentesque vitae tortor nec tellus hendrerit aliquam. Donec condimentum leo eu ullamcorper scelerisque pellentesque urna rhoncus.
          </section>

            <ol class="reply-pan">
            <li>
              <figure>
                <!-- <img src="http://i-pingtung.com/Utility/DisplayImage?id=11160" alt="" class="img-responsive"/> -->
              </figure>
              <section>
                <h4>Johnathan Doe  <a href="#">Reply</a></h4>
                <div class="date-pan">January 26, 2016</div>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed volutpat eu nibh ultricies semper. Vivamus porta, felis vitae facilisis sodales, felis est iaculis orci, et ornare sem mauris ut turpis. Pellentesque vitae tortor nec tellus hendrerit aliquam. Donec condimentum leo eu ullamcorper scelerisque pellentesque urna rhoncus.
              </section>
            </li>
          </ol>
          </li>
          <li>
            <figure>
              <img src="http://i-pingtung.com/Utility/DisplayImage?id=11160" alt="" class="img-responsive"/>
            </figure>

            <section>
              <h4>Anna Greenfield  <a href="#">Reply</a></h4>
              <div class="date-pan">January 26, 2016</div>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed volutpat eu nibh ultricies semper. Vivamus porta, felis vitae facilisis sodales, felis est iaculis orci, et ornare sem mauris ut turpis. Pellentesque vitae tortor nec tellus hendrerit aliquam. Donec condimentum leo eu ullamcorper scelerisque pellentesque urna rhoncus.
            </section>
          </li>
        </ul>

        <div class="commentys-form">
        <h4>心得分享</h4>
        <div class="row">
          <form>
            <div class="col-xs-12 col-sm-6 col-md-6">
              <input type="hidden" name="Id" value="<?=$Id;?>">
              <input name="Post_Name" type="text" placeholder="姓名">
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6">
              <input name="Post_Email" type="email" placeholder="Email">
            </div>

            <div class="clearfix"></div>

            <div class="col-xs-12 col-sm-12 col-md-12">
            <textarea name="Message" placeholder="分享您對此景點的心得..."></textarea>
          </div>

            <div class="text-center">
            <input id="Submit" type="button" value="送出">
          </div>
          </form>
        </div>
      </div>
      </div>
  </div>
</main>

<script type="text/javascript">
//20180325
  $(document).ready(function() {
    $("#Submit").click(function(event) {
      var Id = $("input[name='Id']").val();
      var Post_Name = $("input[name='Post_Name']").val();
      var Post_Email = $("input[name='Post_Email']").val();
      var Message = $("textarea[name='Message']").val();

      $.ajax({
        url:"AMessage",
        type: 'POST',
        data:{
          Id: Id,
          Name: Post_Name,
          Email: Post_Email,
          Message: Message
        },
        dataType: "json",
        success: function(datas){
          alert(datas.sys_msg);
        },
        error: function(data){
          alert('123');
        }
      });
    });
  });
</script>
