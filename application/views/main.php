<!-- main -->
<main role="main-home-wrapper" class="container">
  <div class="row">
    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
      <article role="pge-title-content">
        <header>
          <form class="form-inline" method="post">
            <h2><span id="title"><?=$title; ?></span><?=$sub_title;?></h2>
            <?php echo $TravelDropdown; ?>
            <select class="selectpicker" id="place" name="place" data-width="auto" data-style="btn-primary"></select>
            <input type="hidden" id="count" value="0">
            <button type="button" name="button" class="btn btn-danger">送出</button>
          </form>
        </header>
        <p><?=$description; ?></p>
      </article>
    </section>

    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 grid one">
      <figure class="effect-oscar">
        <img src="https://lh3.googleusercontent.com/gKNfKsbOj6Wet5GWLrKeG7v5gSmGd-pUPdkgit9KgTsE1XxPH0SRcdvJEj4XVWerx5CONI6OUuqGKbSZ9Gde=w1920-h934" alt="" class="img-responsive main_Img"/>
        <figcaption></figcaption>
      </figure>
    </section>

    <div class="clearfix"></div>

    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 grid two">
      <ul class="grid-lod effect-2 main_left" id="grid">
        <!-- <li>
          <figure class="effect-oscar">
            <img src="https://lh6.googleusercontent.com/iS8UNKQ05dVBMryacpgTAwsj-h_z0yis2RJEaBZ76AfwBYl9re-n_HBMNQDwJD5B7G079HPOJrnxfB2FZRL0=w1364-h635-rw" alt="" class="img-responsive"/>
            <figcaption>
              <h2>Studio Thonik <span>Exhibition</span></h2>
              <p>Project for Thonik, design studio based in Amsterdam</p>
              <a href="works-details.html">View more</a>
            </figcaption>
          </figure>
        </li> -->
      </ul>
    </section>

    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 grid three">
      <ul class="grid-lod effect-2 main_right" id="grid">
        <!-- <li>
          <figure class="effect-oscar">
            <img src="https://lh6.googleusercontent.com/iS8UNKQ05dVBMryacpgTAwsj-h_z0yis2RJEaBZ76AfwBYl9re-n_HBMNQDwJD5B7G079HPOJrnxfB2FZRL0=w1364-h635-rw" alt="" class="img-responsive"/>
            <figcaption>
              <h2>Studio Thonik <span>Exhibition</span></h2>
              <p>Project for Thonik, design studio based in Amsterdam</p>
              <a href="works-details.html">View more</a>
            </figcaption>
          </figure>
        </li> -->
      </ul>
    </section>
    <div class="clearfix"></div>
  </div>
</main>

<!-- main -->
