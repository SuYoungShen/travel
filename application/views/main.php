<!-- main -->
<main role="main-home-wrapper" class="container">
  <div class="row">
    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
      <article role="pge-title-content">
        <header>
          <form class="form-inline" method="post">
            <h2><span id="title"><?=$title; ?></span><?=$sub_title;?></h2>
            <?php echo $TravelDropdown; ?>
            <select class="selectpicker" id="place" name="place" data-width="auto" data-style="btn-primary"></select>
            <button type="button" name="button" class="btn btn-danger">送出</button>
          </form>
        </header>
        <p><?=$description; ?></p>
      </article>
    </section>

    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 grid">



      <!-- <div class="panel panel-primary">
        <div class="panel-body">
          <figcaption>
          Panel content
        </figcaption>
        </div>
      </div> -->
  
    <figure class="effect-oscar">
      <img src="assets/images/home-images/image-1.jpg" alt="" class="img-responsive main_Img"/>
      <figcaption>
        <h2>Eliana Dedda<span> Identity</span></h2>
        <p>Personal Brand Identity.</p>
        <a href="detals/0">View more</a>
      </figcaption>
    </figure>



    </section>

    <div class="clearfix"></div>
    <div class="clearfix"></div>

    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 grid">
      <ul class="grid-lod effect-2 main_left" id="grid">
      </ul>
    </section>

    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 grid">
      <ul class="grid-lod effect-2 main_right" id="grid">
      </ul>
    </section>
    <div class="clearfix"></div>
  </div>
</main>

<!-- main -->
