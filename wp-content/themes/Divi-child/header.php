<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php //elegant_description(); ?>
<?php //elegant_keywords(); ?>
<?php //elegant_canonical(); ?>
<?php //do_action( 'et_head_meta' ); ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php $template_directory_uri = get_template_directory_uri(); ?>
<!--[if lt IE 9]>
	<script src="<?php echo esc_url( $template_directory_uri . '/js/html5.js"' ); ?>" type="text/javascript"></script>
	<![endif]-->
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
<link type="text/css" rel="stylesheet" href="<?=get_stylesheet_directory_uri();?>/css/bootstrap.min.css?v=3.3.7"/>
<link type="text/css" rel="stylesheet" href="<?=get_stylesheet_directory_uri();?>/css/font-awesome.min.css?v=4.7.0"/>
<!--<link type="text/css" rel="stylesheet" href="<?=get_stylesheet_directory_uri();?>/style.css?v=3.0"/>-->
<link type="text/css" rel="stylesheet" href="<?=get_stylesheet_directory_uri();?>/css/responsive.css?v=3.0"/>
<script type="text/javascript">
		//document.documentElement.className = 'js';
	</script>
<?php wp_head(); ?>
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet">
</head>
<body>
<div id="wapper">
<header id="header">
  <section class="mainmenu-area stricky" id="sticky-header">
    <div class="container">
      <div class="row mobile-header">
        <div class="col-lg-4 col-sm-4 col-xs-4">
          <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header"> 
              <!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>--> 
              
            </div>
          </nav>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-4">
          <div class="logo-block">
            <?php
				$logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && '' != $user_logo
					? $user_logo
					: $template_directory_uri . '/images/logo.png';
			?>
            <!--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>--> 
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"> <img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"    /> </a> </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-4">
          <div class="search"> 
            <!-- <input type="text" class="form-control input-sm" maxlength="64" placeholder="Search">--> 
            <a href="javascript:void(0);" class="searchicon popup-search"><i class="fa fa-search" aria-hidden="true"></i> </a> </div>
        </div>
      </div>
      <div class="row  desktop-header">
        <div class="col-lg-2">
          <div class="logo-block">
            <?php
				$logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && '' != $user_logo
					? $user_logo
					: $template_directory_uri . '/images/logo.png';
			?>
            <!--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>--> 
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"> <img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"  /> </a> </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
          <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header"> 
              <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>-->
              
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav">
                  <?php  wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'echo' => true, 'items_wrap' => '%3$s' ) ); ?>
                </ul>
              </div>
            </div>
          </nav>
        </div>
        <div class="col-lg-1">
          <div class="search">
            <form role="search" method="get" class="et_pb_searchform search" action="http://dizzidenprojects.com/kcg/">
              <div> 
                <!--<label class="screen-reader-text" for="s">Search for:</label>-->
                
<!--                <input value="" name="s" class="et_pb_s form-control input-sm" style="height: 29px; padding-right: 0px;" type="text">
-->                <input name="et_pb_include_posts" value="yes" type="hidden">
                <input name="et_pb_include_pages" value="yes" type="hidden">
              </div>
            </form>
            <a href="javascript:void(0)" class="searchicon et_pb_searchsubmit popup-search"><i class="fa fa-search" aria-hidden="true"></i> </a> </div>
        </div>
      </div>
    </div>
    <div class="services-title">
      <div class="container">
        <div class="services-nation">
          <p class="desktop-header">SERVICES THE NATION</p>
          <ul class="desktop-header">
            <li ><a href="http://dizzidenprojects.com/kcg/locations/">FIND MY LOCATION <i class="fa fa-map-marker" aria-hidden="true"></i></a></li>
            <li><a href="#">LOG IN</a></li>
          </ul>
          <ul class="mobile-header">
            <li ><a href="#"> <i class="fa fa-map-marker" aria-hidden="true"></i></a></li>
            <li><a href="#">LOG IN</a></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <div class="container mobile-header">
    <div class="row">
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <?php  //wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '<b class="caret"></b>', 'fallback_cb' => '<b class="caret"></b>', 'echo' => true, 'items_wrap' => '<b class="caret"></b>%3$s' ) ); ?>
        <?php  //wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'echo' => true, 'items_wrap' => '%3$s' ) ); ?>
        <ul class="nav navbar-nav">
          <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'nav navbar-nav' ) ); ?>
        </ul>
      </div>
    </div>
  </div>
</header>
