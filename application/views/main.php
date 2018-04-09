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
      <figure class="about-content">
        <img src="https://lh3.googleusercontent.com/zdDkq3znXZHQTjrMiTq_n4-XOnkjAxgzTmkbxQOaComOp_e4JWuP2_dqMjv8J8OyD-8zhX-6N4dosO1-5zvr19cfhHG6iJg9pnZnbuvAgnix0iu741xOU-c7juciF0-fL9Y91WgMzK6mJu07ubXCQkhd7rhTrZJpnnl2AMvAXzn8dq4Ic7B6eya0VmDMS0XdCzgxierTUSL8fK9oz6XVp7wFbb5mlFLVkTcKYB5NbhXbWCHDkBSSkLryJE6RlnbuDJRHGDAcI0_TAUMnEwvQdW5fbv7cmOHf5W3ggdtIDMF5oE4Q1Ev1ji3P-1FSHKnQdzpC9Dn9wxUBqHxfmaq3pJJw_SAubQRRltlpSc09S51DMOvxcfZvpi8umadph9nL1aogo1hEQ6QV7PBgmUuDj5cveKNZodyHe4G26WyCviUJY1kqhEiORAdEWhkVuGR_R7_FkXsDBkqBdS-objCWLqIYbn2VYqm7Ka5HK79WD7WvEYFKHYQxYF4tqIdrSOc72e4NdmhCpkxIouCQNf0mg5M2qfxLL6GPhT1hi9An-nLVF9p3pXIi2qay1NjXp6Xp=w1364-h635" alt="" class="img-responsive main_Img"/>
      
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
