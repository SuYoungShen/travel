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

      <script type="text/javascript">

        $(document).ready(function() {

          var travel = $("#travel");
          var travel_val = $(travel).find(":selected").val();
          var place = $("#place");
          var place_val = $(place).find(":selected").val();
          var count = 0;//計數

          aj(count, travel_val, place);

          $(travel).on('change', function(event) {

            var travel_val = $(travel).find(":selected").val();
            aj(count, travel_val, place);
          });

          $(".btn").click(function(event) {
            var travel_val = $(travel).find(":selected").val();
            var place_val = $(place).find(":selected").val();

            if (place_val == "pingtung") {//判斷是否為屏東
              url = "pingtung";
              viewAj(url, travel_val, place_val);
            }else if(place_val == "kaohsiung"){
              url = "kaohsiung";
              viewAj(url, travel_val, place_val);
            }else if (place_val == "tainan") {
              url = "tainan";
              viewAj(url, travel_val, place_val);
            }else if(place_val == "alltaiwan"){
              url = "alltaiwan";
              viewAj(url, travel_val, place_val);
            }
          });
        });

        function viewAj(url, travel_val, place_val){//首頁的有圖片的顯示
          $.ajax({
            url: url,
            type: 'POST',
            data:{
              travel: travel_val,
              place: place_val
            },
            dataType: "json",
            success: function(datas){
              $(".main_left li").remove();
              $(".main_right li").remove();

              if (datas.Title01 == null) {
                datas.Title01 == "";
              }else if (datas.Title01 != "") {
                datas.Title01 = "-"+datas.Title01;
              }

              $(".figcaption").remove();
              // 第一筆資料
              if (typeof(datas.Img01) != "undefined") {

                $('.main_Img').attr("src", datas.Img01);
                $('figcaption').html("<h2>"+datas.Name01+/*"<span>"+datas.Title01+"</span>*/"</h2>");
                $("figcaption").append("<p>時間："+datas.OpenTime01+"</p>")
                $("figcaption").append("<p>電話："+datas.Tel01+"</p>")
                $("figcaption").append("<p>地址："+datas.FullAddress01+"</p>")
                $("figcaption").append("<a href='details/"+travel_val+"/"+place_val+"/0' target='_blank'>詳細內容</a>");
                // 第一筆資料
                
              }else {

                $('figcaption').html("<h2>"+datas.Name01+/*"<span>"+datas.Title01+"</span>*/"</h2>");
                $("figcaption").append("<p>時間："+datas.OpenTime01+"</p>")
                $("figcaption").append("<p>電話："+datas.Tel01+"</p>")
                $("figcaption").append("<p>地址："+datas.FullAddress01+"</p>")
                $("figcaption").append("<a href='details/"+travel_val+"/"+place_val+"/0' target='_blank'>詳細內容</a>");
              }

              $("#title").text(datas.title);//抬頭

              for (var i = 1; i < datas.Total; i++) {
                if (place_val == "kaohsiung") {
                  kaohsiung(datas, i);
                }else if(place_val == "tainan"){
                  tainan(datas, i);
                }
                if (Title == null) {
                   Title = "";
                 }else if(Title != ""){
                   Title = "-"+Title;
                 }

                 if (Tel != "") {
                   Tel = "電話："+Tel;
                 }

                if ((i%2) == 0 || i == 1) {
                  $(".main_left").append("<li class='shown'><figure class='effect-oscar'><img src='"+Img+"' alt='' class='img-responsive'/><figcaption><h2>"+Name+"<!--<span>"+Title+"</span>--></h2><p>開放時間："+OpenTime+"</p><p>"+Tel+"</p><p>地址："+FullAddress+"</p><a href='details/"+travel_val+"/"+place_val+"/"+i+"' target='_blank'>View more</a></figcaption></figure></li>");
                }else {
                  $(".main_right").append("<li class='shown'><figure class='effect-oscar'><img src='"+Img+"' alt='' class='img-responsive'/><figcaption><h2>"+Name+"<!--<span>"+Title+"</span>--></h2><p>開放時間："+OpenTime+"</p><p>"+Tel+"</p><p>地址："+FullAddress+"</p><a href='details/"+travel_val+"/"+place_val+"/"+i+"' target='_blank'>View more</a></figcaption></figure></li>");
                }
              }
            },
            error: function(data){
              alert("失敗");
            }
          });
        }

        function kaohsiung(datas, i){
          Img = datas.result.records[i].Picture1;//照片
          Name = datas.result.records[i].Name;//地點名
          Title = datas.result.records[i].Picdescribe1;
          OpenTime = datas.result.records[i].Opentime;//開放時間
          Tel = datas.result.records[i].Tel;//電話
          FullAddress = datas.result.records[i].Add;//地址
        }

        function tainan(datas, i){
          Name = datas.data[i].name;//地點名
          Title = "";
          OpenTime = datas.data[i].opentime;//開放時間
          Tel = datas.data[i].tel;//電話
          FullAddress = datas.data[i].address;//地址
        }

        function alltaiwan(datas, i){
          Img = datas.XML_Head.Infos.Info[i].Picture1;//照片
          Name = datas.XML_Head.Infos.Info[i].Name;//地點名
          Title = "";
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

        function aj(count, travel_val, place){//下拉
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
                  $(place).append("<option value='"+key+"'>"+value+"</option>");
                });
                $(place).selectpicker('refresh');
              }
            });
            ++count;
        }
      </script>
  </body>
</html>
