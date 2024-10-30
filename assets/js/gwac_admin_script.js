
jQuery(document).ready(function($){
    

			// Uploading files
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = "1"; // Set this
			if(wp.media.model.settings.post.id==0 && jQuery("#image_attachment_id").val()!=""){
				wp_media_post_id=jQuery("#image_attachment_id").val();
			}
			if($("#wa_view_type1").is(":checked")=="1")
                $(".gwc-dialog").addClass("dgwc-none"); 
		
			jQuery('#upload_image_button').on('click', function( event ){

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					// Open frame
					file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = set_to_post_id;
				}
				

				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select a image to upload',
					button: {
						text: 'Use this image',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});
				

				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame.state().get('selection').first().toJSON();

					// Do something with attachment.id and/or attachment.url here
					$( '.gwc-img img' ).attr( 'src', attachment.url );
					$( '#image_attachment_id' ).val( attachment.id );

					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});

					// Finally, open the modal
					file_frame.open();
			});

			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});
		$(".gwc-wrap>a").on("click",function(){
		    
		    return false;
		});
   $("input[name='gwac_options[wa_view_type]']").on("change",function(){

       
      if($(this).val()=="1"){
        $(".viewtype2,.gwc-dialog").addClass("dgwc-none"); 
        if($(".gwc-wrap").find(".gwc-tootltip").length<=0)
            $(".gwc-widget").after('<div class="gwc-tootltip">'+$(".gwc.panel .btn-text").val()+'</div>');
        else
        $(".gwc-tootltip").css({"display":"block"}); 
      }else{
        $(".gwc-tootltip").css({"display":"none"}); 
        $(".viewtype2,.gwc-dialog").removeClass("dgwc-none").css({"display":"block"});
      }
      return false;

   });

   $("input[name='gwac_options[wa_align]']").on("change",function(){
       $("#gwc-324").removeClass("left");
       $("#gwc-324").removeClass("right");
       $("#gwc-324").removeClass("inline");
       
      if($(this).val()=="Inline"){
          jQuery('.inline_shortcode').show();
          $("#gwc-324").addClass("inline");
      }else if($(this).val()=="left"){
          $("#gwc-324").addClass("left");
          jQuery('.inline_shortcode').hide();
      }else{
          $("#gwc-324").addClass("right");
          jQuery('.inline_shortcode').hide();
      }
    return false;
   });
   
   $(".gwc.panel .name").on("keyup",function(){ $(".gwc-name,.gwc-agent-name").html($(this).val());});
   $(".gwc.panel .message").on("keyup",function(){ $(".gwc-text").html($(this).val().replace(/\n/g,"<br>\n"));});
   $(".gwc.panel .caption").on("keyup",function(){ $(".gwc-title").html($(this).val());});
    $(".gwc.panel .btn-text").on("keyup",function(){ $("a.gwc-button.initchat span,.gwc-tootltip").html($(this).val());
        
    });
     $(".gwc.panel .header_bg").on("change",function(){ $(".gwc-head").css("background-color",$(this).val());});
     
    $(".gwc.panel .btn_text_clr").on("change",function(){ $("a.gwc-button.initchat").css("color",$(this).val());$("a.gwc-button.initchat svg").css("fill",$(this).val());});
    $(".gwc.panel .btn_bg").on("change",function(){ $("a.gwc-button.initchat").css("background-color",$(this).val());});
    $(".gwc.panel .btn_bg").on("change",function(){ $("a.gwc-button.initchat").css("background-color",$(this).val());});
    
    $(".gwc.panel .cwd_clr").on("change",function(){ $(".gwc-widget").css("color",$(this).val());$(".gwc-widget svg").css("fill",$(this).val());});
    $(".gwc.panel .cwd_bg").on("change",function(){ $(".gwc-widget").css("background-color",$(this).val());});
    
    
    
    
    
});