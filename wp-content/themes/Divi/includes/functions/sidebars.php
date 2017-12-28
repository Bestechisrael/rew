<?php
function et_widgets_init() {
	register_sidebar( array(
		'name' => esc_html__( 'Sidebar', 'Divi' ),
		'id' => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="et_pb_widget custom-widget-1 %2$s">',
		'after_widget' => '</div> <!-- end .et_pb_widget -->',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	) );
	
	register_sidebar( array(
		'name' => esc_html__( 'Footer Area', 'Divi' ) . ' #1',
		'id' => 'sidebar-2',
		'before_widget' => '<div id="%1$s" class="fwidget custom-widget-2 et_pb_widget %2$s">',
		'after_widget' => '</div> <!-- end .fwidget -->',
		'before_title' => '<h4 class="title">',
		'after_title' => '</h4>',
	) );
	

	register_sidebar( array(
		'name' => esc_html__( 'Footer Area', 'Divi' ) . ' #2',
		'id' => 'sidebar-3',
		'before_widget' => '<div id="%1$s" class="fwidget custom-widget-2 et_pb_widget %2$s">',
		'after_widget' => '</div> <!-- end .fwidget -->',
		'before_title' => '<h4 class="title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer Area', 'Divi' ) . ' #3',
		'id' => 'sidebar-4',
		'before_widget' => '<div id="%1$s" class="fwidget custom-widget-3 et_pb_widget %2$s">',
		'after_widget' => '</div> <!-- end .fwidget -->',
		'before_title' => '<h4 class="title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer Area', 'Divi' ) . ' #4',
		'id' => 'sidebar-5',
		'before_widget' => '<div id="%1$s" class="fwidget custom-widget-4 et_pb_widget %2$s">',
		'after_widget' => '</div> <!-- end .fwidget -->',
		'before_title' => '<h4 class="title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer Area', 'Divi' ) . ' #5',
		'id' => 'sidebar-6',
		'before_widget' => '<div id="%1$s" class="fwidget custom-widget-5 et_pb_widget %2$s">',
		'after_widget' => '</div> <!-- end .fwidget -->',
		'before_title' => '<h4 class="title">',
		'after_title' => '</h4>',
	) );
}
add_action( 'widgets_init', 'et_widgets_init' );