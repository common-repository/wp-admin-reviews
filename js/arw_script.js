jQuery(".arw_username").keyup(function(){
	var this_val = jQuery(this).val();	var this_length = jQuery(this).val().length;	if(this_length>=2){		search_user(this_val);		jQuery(".arw_search_user_list").removeClass("hide_list"); 		if(this_val==""){			jQuery('.arw_search_user_list').addClass("hide_list");		}		}else{		jQuery('.arw_search_user_list').addClass("hide_list");	}
});

jQuery(".spi_search_product").keyup(function(){
	var this_val = jQuery(this).val();	var this_length = jQuery(this).val().length;if(this_length>=2){	search_product(this_val);	jQuery(".spi_search_list").removeClass("hide_list"); 	if(this_val==""){		jQuery('.spi_search_list').addClass("hide_list");	}}else{	jQuery('.spi_search_list').addClass("hide_list");}

});
jQuery(document).on('click', 'body', function(){
	if (jQuery(".arw_username").is(":focus")) {		var unamedata = jQuery(this).val();		if(unamedata==""){			jQuery('.arw_search_user_list').addClass("hide_list");		}
	}else{
		jQuery('.arw_search_user_list').addClass("hide_list");
	}
	if (jQuery(".spi_search_product").is(":focus")) {		var searchlistdata = jQuery(this).val();		if(searchlistdata==""){			jQuery('.spi_search_list').addClass("hide_list");		}
	}else{
		jQuery('.spi_search_list').addClass("hide_list");
	}
});

function search_user(this_val){
	jQuery.ajax({
		type: "POST",	 
		url: ajax_params.ajax_url,	
		data: {
			action : "ARW_get_userlist",
			'arw_username':this_val
		} ,	
		success: function(response){
			var response = JSON.parse(response);				
			if(response.status ==1){
				jQuery('.arw_search_user_list').html(response.html);
			}else{
				jQuery('.arw_search_user_list').html("No user found");
			} 
		},	
		error: function(jqXHR, textStatus, errorThrown) {
		
			console.log(textStatus, errorThrown);		
		}	

	});
}


function search_product(search_product){
	var post_type = jQuery( ".post_type option:selected" ).val();
	 jQuery.ajax({
		type: "POST",
		url: ajax_params.ajax_url,
		data: {
			action : "ARW_get_products",
			'spi_postname':search_product,
			'post_type':post_type
		},
		success: function(response){
			  var response = JSON.parse(response);			
			if(response.status ==1){
				jQuery('.spi_search_list').html(response.html);
			}else{
				jQuery('.spi_search_list').html("No "+post_type+" found");
			}
		},	
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);		
		}
	});
}

jQuery("body").on('click', '.delete_arw_product', function(){
	var post_type = jQuery( ".post_type option:selected" ).val();
	var r = confirm("Remove "+post_type+"!");
	if (r == true) {
		jQuery(this).parent().remove();
	}
});
function check_post_duplicate(postid){
	var is_dupticate = 0;
		jQuery('div','.arw_product_listing').each(function(){
			var arw_single_pro = jQuery(this).attr('data_id'); 
			//console.log( arw_single_pro);
			if(arw_single_pro==postid){
				 is_dupticate = 1;
			}
		});
	return is_dupticate;
}
jQuery("body").on('click', '.search_post', function(){
	var postname = jQuery(this).html();
	var postid = jQuery(this).attr('postid');

	var valid_post = check_post_duplicate(postid);
		postname = postname.substr(0,10)+'...'; 
	if(valid_post==0){
		var listdata = "<div class='arw_product_name' data_id='"+postid+"'><input hidden name='arw_product_listing[]' value='"+postid+"' />"+postname+"<span class='delete_arw_product dashicons dashicons-no-alt'></span></div>";		
		jQuery('.arw_product_listing').append(listdata);
		jQuery('.spi_search_product_id').val(postid);
		//jQuery('.spi_search_product').val(postname);
		
	}else{
		alert("Already Exist");
	}
	jQuery('.spi_search_list').addClass("hide_list");
	jQuery('.spi_search_product').val("");
});
jQuery("body").on('click', '.user_detail', function(){
	var postname = jQuery(this).html();
	var user_id = jQuery(this).attr('user_id');
	var user_url = jQuery(this).attr('user_url');
	var email = jQuery(this).attr('email');
	
	
	jQuery('.arw_author_name').val(postname);
	jQuery('.arw_author_email').val(email);
	jQuery('.arw_author_url').val(user_url);
	
	jQuery('.arw_username').val(postname);	
	jQuery('.arw_userid').val(user_id);	
	jQuery('.arw_search_user_list').addClass("hide_list");
	//jQuery('.arw_username').val("");
});
jQuery( ".post_type" ).change(function() {
 var post_type = jQuery( ".post_type option:selected" ).val();
  jQuery(".post_product_name").html(post_type+" name:");
});jQuery( document ).ready(function() {    jQuery('.arw_custom_comment_editor #content').attr('required', 'required');});
