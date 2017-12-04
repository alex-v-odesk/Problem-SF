<?php

//==============
//! VIDEO EMBED
//! take video URL & wrap it with appropriate sizing
//==============

function hair_video_embed($videoURL, $extraClasses = '', $vimeo = false) {
	//oEmbed iframe
	$htmlcode = wp_oembed_get($videoURL); //use oembed

	//tweak URL to hide title/byline/portrait
	if($vimeo)
		$htmlcode = preg_replace("/(\/\/player.vimeo.com\/video\/[0-9]*)/i", '$1?title=0&portrait=0&byline=0&color=ffffff', $htmlcode);

	//get width & height of video
	preg_match('~width="(.*?)"~', $htmlcode, $width);
	preg_match('~height="(.*?)"~', $htmlcode, $height);

	//get video ratio
	$ratio = ($height[1] / $width[1]) * 100;

	$videoCode = '<div class="'.$extraClasses.' flex-video" style="padding-bottom: '.$ratio.'%">'.$htmlcode.'</div>';

	return $videoCode;

}

//==============
//! IS TEAM CONDITIONAL
//! boolean function to check if current user is part of project & not just a regular user
//! usage: if(is_team()): do something for team members only
//==============

function is_team() {
	global $current_user;
	get_currentuserinfo();

	$team = array('teamhair', 'admin');

	if(in_array($current_user->user_login, $team)) {
		return true;
	}

	else {
		return false;
	}

}

//==============
// Get page ID by it's Slug
// function returns a page ID when you input the slug
//==============

function getIdBySlug($page_slug) {

	$pagepath = get_page_by_path($page_slug);

	if($pagepath):
		return $pagepath->ID;
	else:
		return null;
	endif;

}

//==============
// Print SVGs
//==============
function print_svg($icon) {

	$svgFile = TEMPLATEPATH . '/dist/images/_svg/' . $icon . '.svg';
	if(file_exists($svgFile)) {
		return file_get_contents($svgFile);
	}
	else {
		return false;
	}

}

//==============
// Super Awesome SVG social network function.
// hair_social(array("facebook", "twitter"...);
// will make a UL>LI combo with the social networks and links in it.
// It also uses ACF options page fields.
//==============
function hair_follow($social_array) {
	?>
	<ul class="social-icons">
		<?php
			foreach($social_array as $social) {
				$svgFile = TEMPLATEPATH . '/dist/images/_social/' . $social . '.svg';
				?>
				<li>
					<a href="<?php the_field($social, "options"); ?>" class="social--<?php echo $social; ?>" target="_blank"><?php echo file_get_contents($svgFile); ?></a>
				</li>
				<?php
			}
		?>

	</ul>
	<?php
}

//==============
// Super Awesome SVG social network function.
// hair_sharer(array("facebook", "twitter"...);
// will make a UL>LI combo with the social networks and links in it.
//==============
function hair_sharer($social_array) {
	global $post;
	?>
	<ul class="share-icons">
		<?php
			foreach($social_array as $social) {
				$svgFile = TEMPLATEPATH . '/dist/images/_social/' . $social . '.svg';
				?>
				<li>
					<?php if($social == "facebook") : ?>
						<a href="https://www.facebook.com/dialog/feed?app_id=184683071273&link=<?php echo urlencode(get_permalink($post->ID)); ?>&picture=&name=&caption=%20&description=&redirect_uri=http%3A%2F%2Fwww.facebook.com%2F&display=popup" target="_blank"><?php echo file_get_contents($svgFile); ?></a>
					<?php elseif($social == "twitter") : ?>
						<a href="http://twitter.com/intent/tweet?text=<?php echo urlencode(get_permalink($post->ID)); ?>"><?php echo file_get_contents($svgFile); ?></a>
					<?php elseif($social == "pinterest") : ?>
						<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($post->ID)); ?>&media=&description="><?php echo file_get_contents($svgFile); ?></a>
					<?php elseif($social == "tumblr") : ?>
						<a href="hhttp://www.tumblr.com/share/photo?source=&caption=&click_thru=<?php echo urlencode(get_permalink($post->ID)); ?>"><?php echo file_get_contents($svgFile); ?></a>
					<?php elseif($social == "googleplus") : ?>
						<a href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink($post->ID)); ?>"><?php echo file_get_contents($svgFile); ?></a>
					<?php endif; ?>
				</li>
				<?php
			}
		?>

	</ul>
	<?php
}


