<!-- main -->
<main role="main-home-wrapper" class="container">
  <div class="row">
    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
      <article role="pge-title-content">
        <header>
          <form class="form-inline" method="post">
            <h2><span><?=$title; ?></span><?=$sub_title;?></h2>
            <?php echo $TravelDropdown; ?>
            <select class="selectpicker" id="place" mame="place" data-width="auto" data-style="btn-primary"></select>
            <button type="submit" name="button" class="btn btn-danger">送出</button>
          </form>
        </header>
        <p><?=$description; ?></p>
      </article>
    </section>

    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 grid">
      <figure class="effect-oscar">
        <img src="<?=$PImg01;?>" alt="" class="img-responsive"/>
        <figcaption>
          <h2><?=$PName01;?><span>-<?=$PName01;?></span></h2>
          <p>開放時間:<?=$POpenTime01;?></p>
          <p>電話:<?=$PTel01;?></p>
          <p>地址:<?=$PFullAddress01;?></p>
          <a href="works-details.html">View more</a>
        </figcaption>
      </figure>
    </section>

    <div class="clearfix"></div>

    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 grid">
      <ul class="grid-lod effect-2" id="grid">
        <?php
          $i=1;
          $totals = (int)($total/2);
          while ( $i < $totals ) {

          $img_Left = $dataTotal->data[$i]->Images;
          $PName_Left = $dataTotal->data[$i]->Name;
          $PTitle_Left = $dataTotal->data[$i]->Title;
          $POpenTime_Left = $dataTotal->data[$i]->OpenTime;
          $PTel_Left = $dataTotal->data[$i]->Tel;
          $PFullAddress_Left = $dataTotal->data[$i]->FullAddress;

          if (empty($img_Left)) {
  					$img_Left = "https://www.90daykorean.com/wp-content/uploads/2016/02/bigstock-Emoticon-saying-no-with-his-fi-42171217.jpg";
  				}else {
            $img_Left = $dataTotal->data[$i]->Images[0]->ThumbnailMax;
          }
          ?>
          <li>
            <figure class="effect-oscar">
              <img src="<?=$img_Left;?>" alt="" class="img-responsive"/>
              <figcaption>
                <h2><?=$PName_Left;?><span><?=!empty($PTitle_Left)?"-".$PTitle_Left:"";?></span></h2>
                <p>開放時間:<?=$POpenTime_Left;?></p>
                <p>電話:<?=!empty($PTel_Left)?$PTel_Left:""; ?></p>
                <p>地址:<?=$PFullAddress_Left;?></p>
                <a href="works-details.html">View more</a>
              </figcaption>
            </figure>
          </li>
          <?php $i++; } ?>
        </ul>
      </section>

      <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 grid">
        <ul class="grid-lod effect-2" id="grid">
          <?php
          while ( $i < $total ) {
            $img_Right = $dataTotal->data[$i]->Images;
            $PName_Right = $dataTotal->data[$i]->Name;
            $PTitle_Right = $dataTotal->data[$i]->Title;
            $POpenTime_Right = $dataTotal->data[$i]->OpenTime;
            $PTel_Right = $dataTotal->data[$i]->Tel;
            $PFullAddress_Right = $dataTotal->data[$i]->FullAddress;

            if (empty($img_Right)) {
    					$img_Right = "https://www.90daykorean.com/wp-content/uploads/2016/02/bigstock-Emoticon-saying-no-with-his-fi-42171217.jpg";
    				}else {
              $img_Right = $dataTotal->data[$i]->Images[0]->ThumbnailMax;
            }
          ?>
          <li>
            <figure class="effect-oscar">
              <img src="<?=$img_Right;?>" alt="" class="img-responsive"/>
              <figcaption>
                <h2><?=$PName_Right;?><span><?=!empty($PTitle_Right)?"-".$PTitle_Right:"";?></span></h2>
                <p>開放時間:<?=$POpenTime_Right;?></p>
                <p>電話:<?=!empty($PTel_Right)?$PTel_Right:""; ?></p>
                <p>地址:<?=$PFullAddress_Right;?></p>
                <a href="works-details.html">View more</a>
              </figcaption>
            </figure>
          </li>
          <?php $i++; } ?>
        </ul>
      </section>
    <div class="clearfix"></div>
  </div>
</main>
<!-- main -->
