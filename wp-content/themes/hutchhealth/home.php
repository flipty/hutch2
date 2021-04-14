<?php

/**
 * Default Homepage For Genesis.
 * Remove or Comment Out genesis(); if you want to use widgets.
 * And uncomment the get_header(); and get_footer(); and place
 * widget area's between those.
 */

//genesis();

get_header();

//Widget Area's go here
vimm_dynamic_sidebar( 'Home Top', true, true );
//vimm_dynamic_sidebar( 'Home Tabs', true, true );
vimm_dynamic_sidebar( 'Home Middle', true, true );
vimm_dynamic_sidebar( 'Home Bottom', true, true );


get_footer();
