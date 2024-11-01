<form name="post" action="" method="post" id="post">
<div class="wrap">
<h2><?php _e('Add New Comment','arw_admin_review'); ?></h2>
<div id="poststuff">
<?php  session_start(); ?>
<div class="arw_alert_msgs">
<?php if ( isset( $_SESSION[ 'arw_alert_msgs' ] )){
		echo $_SESSION[ 'arw_alert_msgs' ];
		unset( $_SESSION[ 'arw_alert_msgs' ] );
	}
?>
<?php if ( isset( $_SESSION[ 'arw_invalid_alert_msgs' ] )){
		echo $_SESSION[ 'arw_invalid_alert_msgs' ];
		unset( $_SESSION[ 'arw_invalid_alert_msgs' ] );
	}
?>
</div>
<div id="post-body" class="metabox-holder columns-2">
<div id="post-body-content" class="edit-form-section edit-comment-section">
	<div id="namediv" class="stuffbox">
		<table class="form-table editcomment">
			<tbody>
				<tr>
					<td>
					<?php _e('Comment for:','arw_admin_review'); ?>
					</td>
					<td>
						<select name="arw_posttype" class="post_type">
							<option value="post"><?php _e('Post','arw_admin_review'); ?></option>
					<?php	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
						<option value="product"><?php _e('Products','arw_admin_review'); ?></option>
					<?php } ?>
						</select>
					</td>	
				</tr>
				<tr>
					<td style="vertical-align: top;"><label class="post_product_name" for="email"><?php _e('Post Name:','arw_admin_review'); ?></label></td>
					<td><input autocomplete="off" type="text" placeholder="Search here..." name="spi_search_product" class="spi_search_product" />
						<input hidden type="text" name="search_product_id" class="spi_search_product_id" />
						<div class="spi_search_list"></div>
						<div class="arw_product_listing"></div>
					</td>
				</tr>
				<tr>
					<td><label for="email"><?php _e('User Name:','arw_admin_review'); ?></label></td>
					<td>
						<input autocomplete="off" placeholder="Search user here.." type="text" name="arw_username" class="arw_username" />
						<input hidden type="text" name="arw_userid" class="arw_userid" />
						<div class="arw_search_user_list">							
						</div>
					</td>
				</tr>
			</table>
		
	</div>
	<div id="namediv1" class="stuffbox">
		<div class="inside">
			<fieldset>
				<legend class="edit-comment-author"><?php _e('Author','arw_admin_review'); ?></legend>
				<table class="form-table editcomment">
					<tbody>
						<tr>
							<td class="first"><label for="name"><?php _e('Name:','arw_admin_review'); ?></label></td>
							<td><input required class="arw_author_name" name="newcomment_author" size="30" id="name" type="text"></td>
						</tr>
						<tr>
							<td class="first"><label for="email"><?php _e('Email:','arw_admin_review'); ?></label></td>
							<td>
								<input required class="arw_author_email" name="newcomment_author_email" size="30" id="email" type="email">
							</td>
						</tr>
						<tr>
							<td class="first"><label for="newcomment_author_url"><?php _e('URL:','arw_admin_review'); ?></label></td>
							<td>
								<input class="arw_author_url" id="newcomment_author_url" name="newcomment_author_url" size="30" class="code" type="text">
							</td>
						</tr>
					</tbody>
				</table>
				<br>
			</fieldset>
		</div>
	</div>
	<input hidden value="<?php _e($_SERVER['REMOTE_ADDR'],'arw_admin_review'); ?>" name="client_ip" />
	<input hidden value="<?php _e($_SERVER['HTTP_USER_AGENT'],'arw_admin_review'); ?>" name="client_agent" />
<div id="postdiv" class="postarea arw_custom_comment_editor"><fieldset>	<legend class="edit-comment-author"><?php _e('Comment','arw_admin_review'); ?></legend><fieldset>
<?php	wp_editor(			$content,			'content',			array(			  'media_buttons' => false,			  'textarea_rows' => 8,			  'tabindex' => 4,			  'tinymce' => array(				'theme_advanced_buttons1' => 'bold, italic, ul, pH, temp',			  ),			)		);?></div>	<div id="namediv2" class="stuffbox">		<div class="inside">			<fieldset>				<legend class="edit-comment-author"><?php _e('Rating','arw_admin_review'); ?></legend>			<fieldset>			<select required name="arw_rating">				<option value="1"><?php _e('1','arw_admin_review'); ?></option>				<option value="2"><?php _e('2','arw_admin_review'); ?></option>				<option value="3"><?php _e('3','arw_admin_review'); ?></option>				<option value="4"><?php _e('4','arw_admin_review'); ?></option>				<option value="5"><?php _e('5','arw_admin_review'); ?></option>			</select>		</div>	</div>
</div>


	<div id="postbox-container-1" class="postbox-container">
		<div id="submitdiv" class="stuffbox">
			<h2><?php _e('Status','arw_admin_review'); ?></h2>
			<div class="inside">
				<div id="minor-publishing">
					<div id="misc-publishing-actions">
						<fieldset class="misc-pub-section misc-pub-comment-status" id="comment-status-radio">
							<legend class="screen-reader-text"><?php _e('Comment status','arw_admin_review'); ?></legend>
							<label><input name="comment_status" value="1" type="radio"><?php _e('Approved','arw_admin_review'); ?></label><br>
							<label><input checked="checked" name="comment_status" value="0" type="radio"><?php _e('Pending','arw_admin_review'); ?></label>
						</fieldset><?php $date_time = date("m/d/Y/H/i"); $datetime = (explode("/",$date_time)); //print_r($datetime);?>
<div class="custom_comenttime misc-pub-section curtime misc-pub-curtime">	<fieldset id="timestampdiv" class="hide-if-js" style="display: block;">	<legend class="screen-reader-text">Date and time</legend>	<div class="timestamp-wrap"><label><span class="screen-reader-text">Month</span><select id="mm" name="mm">				<option value="01" <?php if($datetime['0'] == '01'){ echo "selected='selected'";  }?> data-text="Jan">01-Jan</option>				<option value="02" <?php if($datetime['0'] == '02'){ echo "selected='selected'"; } ?> data-text="Feb">02-Feb</option>				<option value="03" <?php if($datetime['0'] == '03'){ echo "selected='selected'"; } ?> data-text="Mar">03-Mar</option>				<option value="04" <?php if($datetime['0'] == '04'){ echo "selected='selected'"; } ?> data-text="Apr">04-Apr</option>				<option value="05" <?php if($datetime['0'] == '05'){ echo "selected='selected'"; } ?> data-text="May">05-May</option>				<option value="06" <?php if($datetime['0'] == '06'){ echo "selected='selected'"; } ?> data-text="Jun">06-Jun</option>				<option value="07" <?php if($datetime['0'] == '07'){ echo "selected='selected'"; } ?> data-text="Jul">07-Jul</option>				<option value="08" <?php if($datetime['0'] == '08'){ echo "selected='selected'"; } ?> data-text="Aug">08-Aug</option>				<option value="09" <?php if($datetime['0'] == '01'){ echo "selected='selected'"; } ?> data-text="Sep">09-Sep</option>				<option value="10" <?php if($datetime['0'] == '01'){ echo "selected='selected'"; } ?> data-text="Oct">10-Oct</option>				<option value="11" <?php if($datetime['0'] == '01'){ echo "selected='selected'"; } ?> data-text="Nov">11-Nov</option>				<option value="12" <?php if($datetime['0'] == '01'){ echo "selected='selected'"; } ?> data-text="Dec">12-Dec</option>	</select></label> 	<label>		<span class="screen-reader-text">Day</span>		<input id="jj" name="jj" value="<?php echo $datetime['1']; ?>" size="2" maxlength="2" autocomplete="off" type="text">	</label>,	<label>		<span class="screen-reader-text">Year</span>		<input id="aa" name="aa" value="<?php echo $datetime['2']; ?>" size="4" maxlength="4" autocomplete="off" type="text">	</label>		@ 	<label>		<span class="screen-reader-text">Hour</span>		<input id="hh" name="hh" value="<?php echo $datetime['3']; ?>" size="2" maxlength="2" autocomplete="off" type="text">	</label>	:	<label>		<span class="screen-reader-text">Minute</span>		<input id="mn" name="mn" value="<?php echo $datetime['4']; ?>" size="2" maxlength="2" autocomplete="off" type="text">	</label>	</div>	<input id="ss" name="ss" value="01" type="hidden">	</fieldset></div>
					</div> <!-- misc actions -->
					<div class="clear"></div>
				</div>
				<div id="major-publishing-actions">
					<div id="publishing-action">
						<input name="save" id="save" class="button button-primary button-large" value="Publish" type="submit"></div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div><!-- /submitdiv -->
</div>
</div>
</div>
<?php wp_nonce_field( 'arw_add_cmnt_admin_review', 'arw_add_cmnt_admin_review' ); ?>
</form>
