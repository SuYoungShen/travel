<!-- header -->
<header role="header">
  <div class="container">
    <!-- logo -->
    <h1>
      <a href="<?=base_url();?>" title="avana LLC">
        <img src="assets/images/logo.png" title="avana LLC" alt="avana LLC"/>        
      </a>
    </h1>
    <!-- logo -->

    <!-- nav -->
    <nav role="header-nav" class="navy">
      <ul>
        <li class="nav-active"><a href="index.html" title="Work">Work</a></li>
        <li><a href="about.html" title="About">About</a></li>
        <li><a href="blog.html" title="Blog">Blog</a></li>
        <li><a href="contact.html" title="Contact">Contact</a></li>
        <?php if ($this->session->userdata('login_status') === true) { ?>
        <li><a href="logout" title="Contact">登出</a></li>
        <?php }else{ ?>
        <li><a href="login" title="Contact">會員登入</a></li>
        <?php }?>
      </ul>
    </nav>
    <!-- nav -->
  </div>
</header>
  <!-- header -->
