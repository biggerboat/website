<?php
	global $post;
	$post = get_post($_GET['job_id']);
	setup_postdata($post);

	$since = human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago';
	$current_user = wp_get_current_user();
?>

<br>
<input type="hidden" name="post_id" value="<?php echo $post->ID; ?>">
<div id="icon-tools" class="icon32" style="margin-right:30px;">
	<br>
</div>
<h3><?php the_title(); ?></h3>

<table class="condensed-table" id="project_description">
    <tbody>
    <tr>
        <th style="width:100px;">Name</th>
        <td><?php echo get_post_meta(get_the_ID(), 'bb-jobs-name', true); ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><a href="mailto:<?php echo get_post_meta(get_the_ID(), 'bb-jobs-email', true); ?>&subject=<?php the_title(); ?>"><?php echo get_post_meta(get_the_ID(), 'bb-jobs-email', true); ?></a></td>
    </tr>
    <tr>
        <th>Phone</th>
        <td><?php echo get_post_meta(get_the_ID(), 'bb-jobs-phone', true); ?></td>
    </tr>
    <tr>
        <th>Date</th>
        <td><?php the_date(); ?> (<?php echo $since; ?>)</td>
    </tr>
    <tr>
        <th style="vertical-align: top;">Description</th>
        <td style="vertical-align: top;"><?php the_content(); ?></td>
    </tr>
    </tbody>
</table>

<div id="icon-tools" class="icon32" style="margin-right:30px;visibility:hidden;">
	<br>
</div>
<h3>Bigger Boaties</h3>

<table class="condensed-table" id="team">
    <tbody>

<?php
	global $wpdb;

	$users = get_users(array('order' => 'ASC'));
	foreach($users as $user):
		$userstatus = maybe_unserialize( get_user_meta($user->ID, 'job-vote-' . get_the_ID(), true) );
?>

	<tr>
        <th><?php echo get_avatar($user->user_email, 25); ?></th>
        <td>
            <?php
                $user = get_userdata( $user->ID );
                echo $user->first_name . " " . $user->last_name;
            ?>
        </td>
        <td style="width: 200px;">

<?php if ($current_user->ID == $user->ID):
	/*
	 * Is current user
	 */
?>
		<input type="hidden" name="user_id" value="<?php echo $user->ID; ?>">
		<ul class="inputs-list">
			<li>
				<label>
					<input type="radio" value="1" name="interested" <?php if (is_array($userstatus) && $userstatus['interested'] == '1') echo 'checked=""'; ?>>
					<span>Yes, I'm interested!</span>
				</label>

				<div class="subinput">
					<label>
						<input type="checkbox" name="job-contact-client">
						<span>I've contacted the client</span>
					</label>
					<label>
						<input type="checkbox" name="job-got-job">
						<span>Wohoo, I've got the job!</span>
					</label>
				</div>
			</li>
			<li>
				<label>
					<input type="radio" value="0" name="interested" <?php if (is_array($userstatus) && $userstatus['interested'] == '0') echo 'checked=""'; ?>>
					<span>No, not for me</span>

				</label>

				<div class="subinput">
					<label>
						<input type="checkbox" name="job-contact-client-decline">
						<span>Sent mail to client that no one is interested</span>
					</label>
				</div>
			</li>
		</ul>

<?php else:
	/*
	 * Is not current user
	 */
	if (is_array($userstatus)) {
		$userSince = human_time_diff( $userstatus['date'], current_time('timestamp') ) . ' ago';
		echo $userstatus['interested'] == '1' ? '<span class="label success">Interested (' . $userSince . ')</span>' : '<span class="label important">Not Interested (' . $userSince . ')</span>';
	}else{
		echo '<span class="label">Not responded yet</span>';
	}
endif; ?>
			
        </td>
    </tr>

<?php endforeach; ?>

    </tbody>
</table>
<br><br><br>
<h3>Activity log</h3>
<div id="icon-users" class="icon32" style="margin-right:30px;">
	<br>
</div>
<table class="condensed-table" id="project_description">
	<tbody>
	<tr>
	        <td style="vertical-align: top;">
				<div id="activity">
					<?php
					/**
					 * ACTIVITY LOG GETS UPDATED THROUGH AJAX
					 */
					?>
				</div>

	        </td>
	    </tr>
	</tbody>
</table>