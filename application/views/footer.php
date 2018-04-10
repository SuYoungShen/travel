<!-- footer -->
<footer role="footer">
  <!-- logo -->
  <h1>
    <a href="index.html" title="avana LLC"><img src="assets/images/logo.png" title="avana LLC" alt="avana LLC"/></a>
  </h1>
  <!-- logo -->

  <!-- nav -->
  <nav role="footer-nav">
    <ul>
      <li><a href="index.html" title="Work">Work</a></li>
      <li><a href="about.html" title="About">About</a></li>
      <li><a href="blog.html" title="Blog">Blog</a></li>
      <li><a href="contact.html" title="Contact">Contact</a></li>
    </ul>
  </nav>
  <!-- nav -->

  <ul role="social-icons">
    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
    <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
    <li><a href="#"><i class="fa fa-flickr" aria-hidden="true"></i></a></li>
  </ul>
  <p class="copy-right">&copy; 2015  avana LLC.. All rights Resved</p>
</footer>
<!-- footer -->

      <!-- custom -->
      <script src="assets/js/nav.js" type="text/javascript"></script>
      <script src="assets/js/custom.js" type="text/javascript"></script>

      <!-- Include all compiled plugins (below), or include individual files as needed -->

      <script src="assets/js/effects/masonry.pkgd.min.js"  type="text/javascript"></script>
      <script src="assets/js/effects/imagesloaded.js"  type="text/javascript"></script>
      <script src="assets/js/effects/classie.js"  type="text/javascript"></script>
      <script src="assets/js/effects/AnimOnScroll.js"  type="text/javascript"></script>
      <script src="assets/js/effects/modernizr.custom.js"></script>
      <!-- jquery.countdown -->

      <script src="assets/js/html5shiv.js" type="text/javascript"></script>
      <script src="assets/js/bootstrap-select.min.js" type="text/javascript"></script>

      <script src="assets/js/memberInfoUp.js" type="text/javascript"></script>

      <!-- DataTable -->
      <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>
      <!-- DataTable -->


      <script type="text/javascript">

        $(document).ready(function() {

          var travel = $("#travel");
          var travel_val = $(travel).find(":selected").val();
          var place = $("#place");
          var place_val = $(place).find(":selected").val();
          var count = 0;//計數

          Dropdown_Ajax(count, travel_val, place);

          $(travel).on('change', function(event) {
            var travel_val = $(travel).find(":selected").val();
            Dropdown_Ajax(count, travel_val, place);
          });

          $(".btn").click(function(event) {
            //計算按幾次按鈕，為了要恢復下面被移除的ul
            var count=document.getElementById("count").value;
            count++;
            document.getElementById("count").value = count;
            //計算按幾次按鈕，為了要恢復下面被移除的ul

            var travel_val = $(travel).find(":selected").val();
            var place_val = $(place).find(":selected").val();

            if (place_val == "pingtung") {//判斷是否為屏東
              url = "pingtung";
              viewAj(url, travel_val, place_val, count);
            }else if(place_val == "kaohsiung"){
              url = "kaohsiung";
              viewAj(url, travel_val, place_val, count);
            }else if (place_val == "tainan") {
              url = "tainan";
              viewAj(url, travel_val, place_val, count);
            }else if(place_val == "chiayi"){
              url = "chiayi";
              viewAj(url, travel_val, place_val, count);
            }else if(place_val == "chiayis"){
              url = "chiayis";
              viewAj(url, travel_val, place_val, count);
            }else if(place_val == "alltaiwan"){
              url = "alltaiwan";
              viewAj(url, travel_val, place_val, count);
            }
          });
        });

        function Dropdown_Ajax(count, travel_val, place){//下拉
          var url = "";
          if (travel_val == "attractions") {
            url = "attractions_place";
          }else if (travel_val == "food") {
            url = "food_place";
          }
          $.ajax({
              url: url,
              type: 'POST',
              data: {data: travel_val},
              dataType: "json",
              success: function(datas){

                $(place).selectpicker('show');
                $(place).selectpicker('setStyle', 'btn-success');

                if (count >= 1) {
                  $(place).empty();
                  $(place).selectpicker('refresh');
                }
                $.each(datas, function(key, value) {
                  $(place).append("<option value='"+value['en_place']+"'>"+value['ch_place']+"</option>");
                });
                $(place).selectpicker('refresh');
              },
            error: function(resError){
              console.log(resError);
            }
            });
            ++count;
        }

        function viewAj(url, travel_val, place_val, count){//顯示內容

          $.ajax({
            url: url,
            type: 'POST',
            data:{
              travel: travel_val,
              place: place_val
            },
            dataType: "json",
            success: function(datas){
              // 第一筆資料
              if (typeof(datas[0]["Picture"]) === typeof("string") && datas[0]["Picture"] != "") {//資料有照片會跑這段
                //移除無照片的眶
                $(".comments-pan").remove();
                if (count > 1) {//如果按送出超過一次以上
                  $('figure').remove();
                  $('.one').append('<figure class="effect-oscar"><img src="" alt="" class="img-responsive main_Img"/><figcaption></figcaption></figure>');
                  $('.two').append('<ul class="grid-lod effect-2 main_left" id="grid"></ul>');
                  $('.three').append('<ul class="grid-lod effect-2 main_right" id="grid"></ul>');
                }

                $('figure').remove();
                $('.one').append('<figure class="effect-oscar"><img src="" alt="" class="img-responsive main_Img"/><figcaption></figcaption></figure>');
                //20180409 更新成以下格式
                $('.main_Img').attr("src", datas[0]["Picture"]);
                $('figcaption').html("<h2>"+datas[0]["Name"]+"</h2>");
                $("figcaption").append("<p>時間："+datas[0]["Opentime"]+"</p>")
                $("figcaption").append("<p>電話："+datas[0]["Tel"]+"</p>")
                $("figcaption").append("<p>地址："+datas[0]["Add"]+"</p>")
                $("figcaption").append("<a href='details/"+travel_val+"/"+place_val+"/"+datas[0]["id"]+"' target='_blank'>詳細內容</a>");
                // 第一筆資料

              }else {

                //更新成以下程式 in 20180409
                if (count > 1) {//如果按送出超過一次以上
                  $(".comments-pan").remove();
                }
                //更新成以下程式 in 20180409

                //因為無照片所以要移除有照片的tag
                $(".one figure").remove();
                $(".two ul").remove();
                $(".three ul").remove();
                //因為無照片所以要移除有照片的tag

                $('.one').append('<div class="comments-pan"><ul class="comments-reply"><li><section></section></li></ul></div>');
                $('.two').append('<div class="comments-pan"><ul class="comments-reply"></ul></div>');
                $('.three').append('<div class="comments-pan"><ul class="comments-reply"></ul></div>');
                //20180409 更新成以下格式
                $('.comments-reply li section').html("<h2>"+datas[0]["Name"]+"</h2>");
                $(".comments-reply li section").append("<p>時間："+datas[0]["Opentime"]+"</p>")
                $(".comments-reply li section").append("<p>電話："+datas[0]["Tel"]+"</p>")
                $(".comments-reply li section").append("<p>地址："+datas[0]["Add"]+"</p>")
                $(".comments-reply li section").append("<button type='button' class='btn btn-primary'><a class='bg-primary' href='details/"+travel_val+"/"+place_val+"/"+datas[0]["id"]+"' target='_blank'>詳細內容</a></button>");
              }

              $("#title").text(datas["title"]);//抬頭

              for (var i = 1; i < datas["total"]; i++) {
                if (place_val == "kaohsiung") {
                  kaohsiung(datas, i);
                }else if(place_val == "tainan"){
                  tainan(datas, i);
                }else if(place_val == "chiayi"){
                  chiayi(datas, i);
                }else if(place_val == "chiayis"){
                  chiayis(datas, i);
                }

                 if (Tel != "") {
                   Tel = "電話："+Tel;
                 }

                 if (typeof(Img) === typeof("string")  && Img != "") {//如果有照片為字串

                   if ((i%2) == 0) {
                     $(".main_left").append("<li class='shown'><figure class='effect-oscar'><img src='"+Img+"' alt='' class='img-responsive'/><figcaption><h2>"+Name+"</h2><p>開放時間："+OpenTime+"</p><p>"+Tel+"</p><p>地址："+FullAddress+"</p><a href='details/"+travel_val+"/"+place_val+"/"+Id+"' target='_blank'>詳細內容</a></figcaption></figure></li>");
                   }else {
                     $(".main_right").append("<li class='shown'><figure class='effect-oscar'><img src='"+Img+"' alt='' class='img-responsive'/><figcaption><h2>"+Name+"</h2><p>開放時間："+OpenTime+"</p><p>"+Tel+"</p><p>地址："+FullAddress+"</p><a href='details/"+travel_val+"/"+place_val+"/"+Id+"' target='_blank'>詳細內容</a></figcaption></figure></li>");
                   }

                 }else if(Img === false){//如果沒照片為false

                   if ((i%2) == 0) {
                     $(".two .comments-pan .comments-reply").append("<li><section><h2>"+Name+"</h2><p>開放時間："+OpenTime+"</p><p>"+Tel+"</p><p>地址："+FullAddress+"</p><button type='button' class='btn btn-primary'><a class='bg-primary' href='details/"+travel_val+"/"+place_val+"/"+Id+"' target='_blank'>詳細內容</a></button></section></li>");
                   }else {
                     $(".three .comments-pan .comments-reply").append("<li><section><figcaption><h2>"+Name+"</h2><p>開放時間："+OpenTime+"</p><p>"+Tel+"</p><p>地址："+FullAddress+"</p><button type='button' class='btn btn-primary'><a class='bg-primary' href='details/"+travel_val+"/"+place_val+"/"+Id+"' target='_blank'>詳細內容</a></button></section></li>");
                   }
                 }
              }
            },
            error: function(data){
              console.log(data);
            }
          });
        }

        //20180409 更新成以下格式
        function kaohsiung(datas, i){
          Id = datas[i]["id"];//id
          Img = datas[i]["Picture"];//照片
          Name = datas[i]["Name"];//地點名
          OpenTime = datas[i]["Opentime"];//開放時間
          Tel = datas[i]["Tel"];//電話
          FullAddress = datas[i]["Add"];//地址
        }

        //20180409 更新成以下格式
        function tainan(datas, i){
          Id = datas[i]["id"];//id
          if(datas[i]["Picture"] == ""){
            Img = false;
          }else {//無照片
            Img = datas[i]["Picture"];
          }
          Name = datas[i]["Name"];//地點名
          OpenTime = datas[i]["Opentime"];//開放時間
          Tel = datas[i]["Tel"];//電話
          FullAddress = datas[i]["Add"];//地址
        }

        //20180410 新增以下程式
        function chiayi(datas, i){
          Id = datas[i]["id"];//id
          if(datas[i]["Picture"] == ""){
            Img = false;
          }else {//無照片
            Img = datas[i]["Picture"];
          }
          Name = datas[i]["Name"];//地點名
          OpenTime = datas[i]["Opentime"];//開放時間
          Tel = datas[i]["Tel"];//電話
          FullAddress = datas[i]["Add"];//地址
        }

        //20180410 新增以下程式
        function chiayis(datas, i){
          Id = datas[i]["id"];//id
          if(datas[i]["Picture"] == "" || datas[i]["Picture"] == null){
            Img = false;
          }else {//無照片
            Img = datas[i]["Picture"];
          }
          Name = datas[i]["Name"];//地點名
          OpenTime = datas[i]["Opentime"];//開放時間
          Tel = datas[i]["Tel"];//電話
          FullAddress = datas[i]["Add"];//地址
        }

        function alltaiwan(datas, i){
          Img = datas.XML_Head.Infos.Info[i].Picture1;//照片
          Name = datas.XML_Head.Infos.Info[i].Name;//地點名
          OpenTime = datas.XML_Head.Infos.Info[i].OpenTime;//開放時間
          Tel = datas.XML_Head.Infos.Info[i].Tel;//電話
          FullAddress = datas.XML_Head.Infos.Info[i].Add;//地址
        }
        function pingtung(){
          // for (var i = 1; i < datas.total; i++) {
          //
          //   var Img = datas.data[i].Images;//照片
          //   var Name = datas.data[i].Name;//地點名
          //   var Title = datas.data[i].Title;
          //   var OpenTime = datas.data[i].OpenTime;
          //   var Tel = datas.data[i].Tel;
          //   var FullAddress = datas.data[i].FullAddress;
          //
          //   if (Title == null) {
          //     Title = "";
          //   }else if(Title != ""){
          //     Title = "-"+Title;
          //   }
          //
          //   if (Tel != "") {
          //     Tel = "電話："+Tel;
          //   }
          //
          //   if (Img == "") {
          //     Img = "https://www.90daykorean.com/wp-content/uploads/2016/02/bigstock-Emoticon-saying-no-with-his-fi-42171217.jpg";
          //   }else {
          //     Img = datas.data[i].Images[0].Original;
          //   }
          //
          //   if ((i%2) == 0 || i == 1) {
          //     $(".main_left").append("<li class='shown'><figure class='effect-oscar'><img src='"+Img+"' alt='' class='img-responsive'/><figcaption><h2>"+Name+"<span>"+Title+"</span></h2><p>開放時間："+OpenTime+"</p><p>"+Tel+"</p><p>地址："+FullAddress+"</p><a href='travel/details/"+travel_val+"/"+place_val+"/"+i+"'>View more</a></figcaption></figure></li>");
          //   }else {
          //     $(".main_right").append("<li class='shown'><figure class='effect-oscar'><img src='"+Img+"' alt='' class='img-responsive'/><figcaption><h2>"+Name+"<span>"+Title+"</span></h2><p>開放時間："+OpenTime+"</p><p>"+Tel+"</p><p>地址："+FullAddress+"</p><a href='travel/details/"+travel_val+"/"+place_val+"/"+i+"'>View more</a></figcaption></figure></li>");
          //   }
          // }
        }

      </script>
  </body>
</html>
