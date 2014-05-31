<?php
/*
Template Name: Ministry Page
*/


/* Ministry Repository Items */
$currentTime = time();
while ( have_rows('ministry_items') ) : the_row();
	// If the current time is before the expiration date and if a file exists, or if there's no expiration date
	if(get_sub_field('repo_file')):
		if(get_sub_field('item_expiration_date') >= $currentTime):
			$repo[] = array(
				'name' => get_sub_field('repo_item_name'),
				'file' => get_sub_field('repo_file')
			);
		endif;
	endif;				
endwhile;

$cats = get_field('event_categories');
foreach($cats as $cat){
	$categories[] = $cat->slug;
}

$events = getEvents($categories, null, 15, 'and');

foreach($eventsnonfeat as $event){
	$events[] = $event;
}

$events = getEvents($categories, null, 10, 'in');
wp_reset_postdata();

/* Renders Twig */
$context = Timber::get_context();
$post = new TimberPost();

$context['post'] = $post;
$context['repo'] = $repo;
$context['events'] = $events;
Timber::render('ministrypage.twig', $context);