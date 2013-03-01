<br>
<h2>Biggerboat Jobs</h2>

<?php

global $biggerboatJobs;

// set the $paged variable
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$items_per_page = 10;

// query the jobs
$args = array(
	'post_type' => 'jobs',
	'paged' => $paged,
	'posts_per_page' => $items_per_page
);
query_posts($args);

?>

<table class="condensed-table zebra-striped">

	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Subject</th>
			<th>Client name</th>
			<th>Interested</th>
			<th>Not interested</th>
			<th>Not responded</th>
			<th>Published</th>
		</tr>
	</thead>

	<tbody>

	<?php
		if ( have_posts() ):
			while ( have_posts() ): the_post();

				$since = human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago';

				// current user has interest?
				$currentuser = wp_get_current_user();
				$userstatus = maybe_unserialize( get_user_meta($currentuser->ID, 'job-vote-' . get_the_ID(), true) );

				$titleClass = 'label';
				if (is_array($userstatus) && $userstatus['interested'] == 1) $titleClass .= ' success';
				if (is_array($userstatus) && $userstatus['interested'] == 0) $titleClass .= ' important';

				$boaties_interested = $biggerboatJobs->boaties_interested(get_the_ID());
	?>

			<tr>
				<td><a class="btn small" href="?page=biggerboat-jobs-detail&job_id=<?php the_ID(); ?>">View Job</a></td>
				<td><span class="<?php echo $titleClass; ?>"><?php the_title(); ?></span></td>
				<td><?php echo get_post_meta(get_the_ID(), 'bb-jobs-name', true); ?></td>
				<td><?php echo $boaties_interested[1]; ?></td>
				<td><?php echo $boaties_interested[0]; ?></td>
				<td><?php echo $boaties_interested[2]; ?></td>
				<td><?php echo $since; ?></td>
			</tr>
	<?php
			endwhile;
		endif;
	?>

	</tbody>
</table>

<?php wp_reset_query(); ?>
