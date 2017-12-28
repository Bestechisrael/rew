<?php 
if ( 'on' == et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

<span class="et_pb_scroll_top et-pb-icon"></span>
<?php endif;?>
<div class="footer-img"> </div>
<div class="footer-title">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12"> 
        <!--<div class="footer">
           			
			<h3>Rew Materials Corporate Offices</h3>
            <p>15720 w 108th St, suite 100<br>
              Lenexa, Ks 66219</p> 
         </div>-->
        <?php //echo the_widget('sidebar-2');
		  	//dynamic_sidebar('sidebar-1');
			get_sidebar('footer');
		   ?>
      </div>
      <div class="col-md-7 col-sm-7"> 
        <!--<div class="footer-right">
            <h2>CONNECT WITH US<a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></h2>
            <h3>SING UP TO RECIEVE UPDATES</h3>
            <div class="input-btn">
              <input type="text" class="form-control-btn" placeholder="Your Email Address">
              <div class="input-group-btn"> </div>
            </div>
          </div>-->
        <?php //echo the_widget('sidebar-2');
		  	//dynamic_sidebar('sidebar-1');
			get_sidebar('footer-1');
		   ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 col-sm-6">
        <?php //echo the_widget('sidebar-2');
		  	//dynamic_sidebar('sidebar-1');
			get_sidebar('footer-2');
		   ?>
        <!--<div class="report-potential">
            <p>To report potential policry viotions, fraidulent, or unehical behavior,please called 855-858-3344 or go to www.integraReport.com</p>
			
          </div>--> 
      </div>
      <div class="col-md-4 col-sm-6">
        <?php //echo the_widget('sidebar-2');
		  	//dynamic_sidebar('sidebar-1');
			get_sidebar('footer-3');
		   ?>
        <!--<div class="report-potential f-right">
            <p>REW MATERIAL, 20117 All rights reserved KCG</p>
          </div>--> 
      </div>
    </div>
  </div>
</div>
<div class="footer-menu">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="menu-bottem">
          <ul>
            <?php  wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => '', 'fallback_cb' => '', 'echo' => true, 'items_wrap' => '%3$s' ) ); ?>
            <!-- <li><a href="#">PRODUCTS</a></li>
            <li><a href="#">SERVICRES & DELIVERY</a></li>
            <li><a href="#">TOOLS & RESOURCES</a></li>
            <li><a href="#">LOCATIONS</a></li>
			    <li><a href="#">ABOUT REW</a></li>
            <li><a href="#">CAREERS</a></li>-->
          </ul>
          <div class="rights-title">
            <p>website devloped and hosted by KCG </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="search-form-popup" style="display:none">
<a href="javacript:void(0);" class="close-search-popup"></a>
<form role="search" method="get" id="searchform" action="<?php echo site_url();?>">
<div>

<!--<label for="s">Search for:</label>
--><input type="text" value="" placeholder="Search" name="s" id="s" />
<input name="et_pb_include_posts" value="yes" type="hidden">
                <input name="et_pb_include_pages" value="yes" type="hidden">
<button type="submit" id="searchsubmit"/> <i class="fa fa-search"></i> </button>
</div>
</form>
</div>
<script src="<?=get_stylesheet_directory_uri();?>/js/jquery.js"></script> 
<script src="<?=get_stylesheet_directory_uri();?>/js/bootstrap.min.js"></script> 
<script src="<?=get_stylesheet_directory_uri();?>/js/custom.js"></script>
<?php wp_footer(); ?>
</body></html>