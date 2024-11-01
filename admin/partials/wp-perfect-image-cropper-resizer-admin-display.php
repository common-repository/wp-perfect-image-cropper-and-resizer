<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://expresstech.io/
 * @since      1.0.0
 *
 * @package    Wp_Perfect_Image_Cropper_Resizer
 * @subpackage Wp_Perfect_Image_Cropper_Resizer/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <form action="options.php" method="post">
        <?php
            settings_fields( $this->plugin_name );
            do_settings_sections( $this->plugin_name );
            submit_button();

        ?>
    </form>
</div>
<hr>

<?php
function generate_image_thumbnail($source_image_path, $thumbnail_image_path, $maxwidth, $maxheight)
{
    list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
    switch ($source_image_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($source_image_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($source_image_path);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($source_image_path);
            break;
    }
    if ($source_gd_image === false) {
        return false;
    }
    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = $maxwidth / $maxheight;
    if ($source_image_width <= $maxwidth && $source_image_height <= $maxheight) {
        $thumbnail_image_width = $source_image_width;
        $thumbnail_image_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
        $thumbnail_image_width = (int) ($maxheight * $source_aspect_ratio);
        $thumbnail_image_height = $maxheight;
    } else {
        $thumbnail_image_width = $maxwidth;
        $thumbnail_image_height = (int) ($maxwidth / $source_aspect_ratio);
    }
    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);

    $img_disp = imagecreatetruecolor($maxwidth,$maxheight);
    $backcolor = imagecolorallocate($img_disp,255,255,255);
    imagefill($img_disp,0,0,$backcolor);

        imagecopy($img_disp, $thumbnail_gd_image, (imagesx($img_disp)/2)-(imagesx($thumbnail_gd_image)/2), (imagesy($img_disp)/2)-(imagesy($thumbnail_gd_image)/2), 0, 0, imagesx($thumbnail_gd_image), imagesy($thumbnail_gd_image));

    imagejpeg($img_disp, $thumbnail_image_path, 90);
    imagedestroy($source_gd_image);
    imagedestroy($thumbnail_gd_image);
    imagedestroy($img_disp);
    return true;
}

$posttype = get_option( $this->option_name . '_posttype' );
$maxwidth= get_option( $this->option_name . '_maxwidth' );
$maxheight = get_option( $this->option_name . '_maxheight' );

$args = array( 'post_type' => $posttype, 'posts_per_page' => -1 );

$loop = new WP_Query( $args );
echo 'Total '.$posttype.'s : '.$loop->post_count."<br><br>";

if(isset($_POST['doit'])) {
	// echo 'doit';
	$i = 1;
	while ( $loop->have_posts() ) : $loop->the_post(); 
	$link = get_permalink(get_the_ID());
	// global $product; 
	if($posttype == 'product') {
		$product = new WC_product(get_the_ID());
    	$media = $product->get_gallery_attachment_ids();
	} else {
		$media = get_post_thumbnail_id(get_the_ID()); //get_attached_media( 'image' );
		if($media)
			$media = array($media);
		else
			$media = array();
	}
	?>

	<?php echo $i ?>. <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a> Compressing <?php echo count($media) ?> images ...

	<?php
	$skipped = 0;
	foreach($media as $m) {
		$path =  get_attached_file( $m );


		list($source_image_width, $source_image_height, $source_image_type) = getimagesize($path);
		if($source_image_width == $maxwidth && $source_image_height == $maxheight) {
			$skipped += 1;
		} else {
			generate_image_thumbnail($path,$path,$maxwidth,$maxheight);

			$attach_data = wp_generate_attachment_metadata( $m, $path );
			if ( is_wp_error( $metadata ) )
				echo " [ERROR - while generating thumnbnail] ";
			else
	  			wp_update_attachment_metadata( $attach_id,  $attach_data );
		}
		

		//echo $guid;
	}
	if($skipped > 0)
		echo " ($skipped images skipped) ";
	echo "done<br>";
	$i++;
	endwhile; 

}

?>

<div class="wrap">
    <!-- <h2>Stats</h2> -->
    <form action="" method="post">
        <input type="submit" name="doit" value="Process Images" class="button button-primary">
    </form>
</div>

