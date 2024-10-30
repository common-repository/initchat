<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

//Class for the setup plugin menu and initialization 
class gwac_admin {

    private $wac=null;
    private $options=null;
    function __construct($wp){
        
        
        //Setup admin page
        add_action('admin_menu', array($this,"gwac_register_options_page"));
        
        add_action('admin_init', array($this,"gwac_register_options"));
      
        /* Enqueues admin scripts. */
        add_action( 'admin_enqueue_scripts', array($this,'add_admin_gwac_style' ));
        
        
        //Set WP main class
        $this->wac=$wp;

    }
    
    /** 
     * Print the Section text
     */
    public function gwac_none() { }
    
    /** 
     * Validate all field values 
     */
    function gwac_validate_options($input) {  
            
        $new_input = array();
        if( isset( $input['wa_number'] ) )
            $new_input['wa_number'] = absint($input['wa_number']);
            
        if( isset( $input['wa_name'] ) )
            $new_input['wa_name'] = sanitize_text_field( $input['wa_name']);
            
        if( isset( $input['agent_image'] ) )
            $new_input['agent_image'] = absint($input['agent_image']);
        
        
        if( isset( $input['wa_caption'] ) )
            $new_input['wa_caption'] = sanitize_text_field($input['wa_caption']);
        if( isset( $input['wa_view_type'] ) )
            $new_input['wa_view_type'] = intval($input['wa_view_type']);
        else $new_input['wa_view_type']=2;
        
        if( isset( $input['wa_wcmessage'] ) )
            $new_input['wa_wcmessage'] = sanitize_textarea_field( $input['wa_wcmessage'] );
        if( isset( $input['wa_rpmessage'] ) && !empty($input['wa_rpmessage']) )
            $new_input['wa_rpmessage'] = sanitize_textarea_field($input['wa_rpmessage']);
        else    $new_input['wa_rpmessage'] = sanitize_textarea_field(__( 'Hello,\nIm looking your help on {PAGE}\n{URL}.', 'initchat' ));
            
            
        
        if( isset( $input['wa_chatbt'] ) )
            $new_input['wa_chatbt'] = sanitize_text_field($input['wa_chatbt']);
       
        if( isset( $input['wa_align'] ) && in_array($input['wa_align'],array("left","Right","Inline")))
            $new_input['wa_align'] = sanitize_text_field($input['wa_align']);
        else
            $new_input['wa_align'] = "Right";
        
        
        if( isset( $input['header_bg'] ) )
            $new_input['header_bg'] = sanitize_text_field($input['header_bg']);
        if( isset( $input['cwd_bg'] ) )
            $new_input['cwd_bg'] = sanitize_text_field($input['cwd_bg']);
        if( isset( $input['cwd_clr'] ) )
            $new_input['cwd_clr'] = sanitize_text_field($input['cwd_clr']);
            
            
            
        if( isset( $input['btn_bg'] ) )
            $new_input['btn_bg'] = sanitize_text_field($input['btn_bg']);
        
        if( isset( $input['btn_text_clr'] ) )
            $new_input['btn_text_clr'] = sanitize_text_field($input['btn_text_clr']);
            
        if( isset( $input['wa_enabled'] ) )
            $new_input['wa_enabled'] = "YES";
        else
            $new_input['wa_enabled'] ="NO";
            
            
        return $new_input;
    }
    function gwac_register_options(){
        
     


        //Register settings
        register_setting('gwac_options', 'gwac_options', array($this,'gwac_validate_options'));
        
        add_settings_section(
            'gwac_section1', // ID
            'initChat', // Title
            array( $this, 'gwac_none' ), // Callback
            'initchat' // Page
        );  

        add_settings_field(
            'wa_number', // ID
            'WhatsApp Number', // Title 
            array( $this, 'gwac_none' ), // Callback
            'initchat', // Page
            'gwac_section1' // Section           
        );  
        add_settings_field(
                    'wa_name', // ID
                    'Name', // Title 
                    array( $this, 'gwac_none' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        ); 
        add_settings_field(
                    'wa_view_type', // ID
                    'View Type', // Title 
                    array( $this, 'wa_view_type' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        ); 
        add_settings_field(
                    'agent_image', // ID
                    'Agent Image', // Title 
                    array( $this, 'gwac_none' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        ); 
        add_settings_field(
                    'wa_caption', // ID
                    'Caption', // Title 
                    array( $this, 'gwac_none' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        ); 
        add_settings_field(
                    'wa_wcmessage', // ID
                    'Message', // Title 
                    array( $this, 'gwac_none' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        );
        add_settings_field(
                    'wa_rpmessage', // ID
                    'Replay Message', // Title 
                    array( $this, 'gwac_none' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        );
        add_settings_field(
                    'wa_chatbt', // ID
                    'Chat button text', // Title 
                    array( $this, 'gwac_none' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        );
        add_settings_field(
                    'wa_align', // ID
                    'Popup Alignment', // Title 
                    array( $this, 'gwac_none' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        );
        add_settings_field(
                    'header_bg', // ID
                    'Header background color', // Title 
                    array( $this, 'gwac_none' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        );
        add_settings_field(
                    'cwd_clr', // ID
                    'Chat widget color', // Title 
                    array( $this, 'gwac_none' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        );
        add_settings_field(
                    'cwd_bg', // ID
                    'Cht widget background color', // Title 
                    array( $this, 'gwac_none' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        );
        
        
        add_settings_field(
                    'btn_bg', // ID
                    'Button background color', // Title 
                    array( $this, 'gwac_none' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        );
        add_settings_field(
                    'btn_text_clr', // ID
                    'Button Text color', // Title 
                    array( $this, 'gwac_none' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        );
        add_settings_field(
                    'wa_enabled', // ID
                    'Enable or Disable', // Title 
                    array( $this, 'gwac_none' ), // Callback
                    'initchat', // Page
            'gwac_section1' // Section            
        );

        
    }
    function add_admin_gwac_style($page){
        
        if( 'toplevel_page_initchat' == $page ) {
        
        
            /* CSS for preview.s */
            wp_enqueue_style( 'gwac_admin_style', GWAC_URL.'/css/gwac_admin_style.css');
        
             /* JS for metaboxes. */
            wp_enqueue_script( 'gwac_script', GWAC_URL.'/js/gwac_admin_script.js', array( 'jquery' ));
        
            wp_enqueue_style( 'gwac_admin_style' );
            
        }
        wp_enqueue_media(); 
    }
    function gwac_register_options_page(){
        //Adding main menu for startchat settings
        add_menu_page('initChat', 'initChat', 'manage_options', 'initchat', array($this,'gwac_option_page'),plugins_url()."/initchat/assets/img/initchat-icon.png");

    }
    function gwac_option_page() {
	
        if ( !current_user_can( 'manage_options' ) )  {
    		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    	}
    	
    	
    		// Set class property
         $this->options = get_option( 'gwac_options' );
     
         $user=wp_get_current_user();
         $blogname=get_bloginfo("name");

            $agent=(isset($this->options['wa_name'])?$this->options['wa_name']:$blogname);
            $gwc_replay_message=(isset($this->options['wa_rpmessage'])?$this->options['wa_rpmessage']:__( "Hello,\nI'm looking your help on *{PAGE}*\n{URL}.", 'initchat' ));
        ?>
    	
    	
    	<div class="gwc panel">
    	    
    	        
    	    <div class="wrapper">
    	        <form method="post" action="options.php">
    	        <h1><img src='<?=plugins_url()."/initchat/assets/img/initchat-icon.png";?>'/> <?php echo __( 'initChat', 'initchat' );?> &nbsp; &nbsp; <label class="switch">
  <input type="checkbox"  name="gwac_options[wa_enabled]" value="YES" <?=(! isset( $this->options['wa_enabled'] ) || $this->options['wa_enabled']=="YES") ? "checked='checked'" : ''?>>
  <span class="slider round"></span>
</label> <small><?php echo __( 'Enable/Disable', 'initchat' );?></small> </h1>
        	    
        	    <div class="sidebar">
        	        
                    <div class="slide main">
                       
                        <div class="tab-contents">
                            
                            <div class="content active"><h3><?php echo __( 'Contents', 'initchat' );?></h3>
                            
                                <div class="form-control">
                                    <label><?php echo __( 'WhatsApp Number', 'initchat' );?></label>
                                    <div class="control">
                                        <input type="text" name="gwac_options[wa_number]" value="<?=isset( $this->options['wa_number'] ) ? esc_attr( $this->options['wa_number']) : ''?>" maxlenght="12" required minlegth="12" placeholder="<?php echo __( '+001234567890', 'initchat' );?>"  class="">
                                    </div> 
                                </div>
                                
                                <div class="group">
                                     <span><b><?php echo __( 'Popup Type', 'initchat' );?></b></span>
                                    <div class="form-control">
                                       
                                <br/>
                                            <input type="radio" value="1" id="wa_view_type1" name="gwac_options[wa_view_type]" <?=(isset( $this->options['wa_view_type'] ) && $this->options['wa_view_type']=="1")? 'checked="checked"' : ''?>><label for="wa_view_type1"><?php echo __( 'Tooltip View', 'initchat' );?></label>
                                       </div>
                                       <div class="form-control">
                                            <input type="radio" value="2" id="wa_view_type2"  name="gwac_options[wa_view_type]" <?=(isset( $this->options['wa_view_type'] ) && $this->options['wa_view_type']!="1")? 'checked="checked"' : ''?>><label for="wa_view_type2"><?php echo __( 'Popup View', 'initchat' );?></label>
                                        </div>
                                        
                                    <br/>
                                    <div class="form-control">
                                        <label><?php echo __( 'Chat Message<br/> (This default message will show to the users when they contacting you via whatsapp. Allow \n for new line and {PAGE} and {URL} replace with current user page)', 'initchat' );?></label>
                                        <div class="control"><textarea placeholder="<?php echo __( 'Replay Message', 'initchat' );?>"   maxlenght="60"  rows="3" style="margin-top: 0px; margin-bottom: 0px; height: 52px;" name="gwac_options[wa_rpmessage]"><?=$gwc_replay_message;?></textarea></div>
                                    </div>
                                </div>
                               
                                
                                <div class="group viewtype2" <?=($this->options['wa_view_type']!="2")?'style="display:none;"':'';?>>
                                    <span><b><?php echo __( 'Popup Top Area', 'initchat' );?></b></span><br/></br>
                                    <div class="form-control agent-pic">
                                        <label><?php echo __( 'Agent Photo', 'initchat' );?></label>
                                        <div class="control">
                                            
                                        	<input id="upload_image_button" type="button" class="button" value="<?php echo __( 'Change Agent Photo', 'initchat' );?>" />
                                        	<input type='hidden' name='gwac_options[agent_image]' id='image_attachment_id' value="<?=isset( $this->options['agent_image'] ) ? esc_attr( $this->options['agent_image']) : ''?>">
                                                                                    
                                        </div> 
                                    </div><div class="form-control">
                                        <label><?php echo __( 'Name', 'initchat' );?></label>
                                        <div class="control"><input type="text"  maxlenght="17"   class="name" placeholder="<?php echo __( 'Full Name', 'initchat' );?>" name="gwac_options[wa_name]" value="<?=$agent;?>"></div> 
                                    </div><div class="form-control">
                                        <label><?php echo __( 'Caption', 'initchat' );?></label>
                                        <div class="control"><input type="text"   maxlenght="22"   class="caption" placeholder="<?php echo __( 'Caption', 'initchat' );?>" name="gwac_options[wa_caption]" value="<?=isset( $this->options['wa_caption'] ) ? esc_attr( $this->options['wa_caption']) : ''?>"></div> 
                                    </div><div class="form-control">
                                        <label><?php echo __( 'Welcome Message', 'initchat' );?></label>
                                        <div class="control"><textarea placeholder="<?php echo __( 'Message', 'initchat' );?>"   maxlenght="60" class="message"  rows="3" style="margin-top: 0px; margin-bottom: 0px; height: 52px;" name="gwac_options[wa_wcmessage]"><?=isset( $this->options['wa_wcmessage'] ) ? esc_attr( $this->options['wa_wcmessage']) : __( 'Hi there \nHow can I help you?', 'initchat' );?></textarea></div>
                                    </div>
                                    
                                </div>
                                
                                
                                <div class="group">
                                    <span><b><?php echo __( 'Chat Button', 'initchat' );?></b></span><br/></br>
                                    <div class="form-control">
                                    <div class="control">
                                        <input type="text"  class="btn-text" required   maxlenght="12"   placeholder="<?php echo __( 'Chat button text', 'initchat' );?>" name="gwac_options[wa_chatbt]" value="<?=isset( $this->options['wa_chatbt'] ) ? esc_attr( $this->options['wa_chatbt']) :  __( 'Need Help ?', 'initchat' );?>">
                                    </div> </div> 
                                </div>
                                
                                
                                
                           
                                <h3><?php echo __( 'Apperiance', 'initchat' );?></h3>
                                <div class="group">
                                         <span><b><?php echo __( 'Set Your Favorite Colors', 'initchat' );?></b></span></br></br>
                                        <div class="form-control">
                                            <label><?php echo __( 'Chat Widget Color', 'initchat' );?></label>
                                            <div class="control"><input type="color" class="cwd_clr"   name="gwac_options[cwd_clr]" value="<?=isset( $this->options['cwd_clr'] ) ? esc_attr( $this->options['cwd_clr']) : '#095e54'?>"></div> 
                                        </div>
                                        <div class="form-control">
                                            <label><?php echo __( 'Chat Widget Background Color', 'initchat' );?></label>
                                            <div class="control"><input type="color" class="cwd_bg"   name="gwac_options[cwd_bg]" value="<?=isset( $this->options['cwd_bg'] ) ? esc_attr( $this->options['cwd_bg']) : '#ffffff'?>"></div> 
                                        </div>
                                        
                                        <div class="form-control  viewtype2"  <?=($this->options['wa_view_type']!="2")?'style="display:none;"':'';?>>
                                            <label><?php echo __( 'Header Background Color', 'initchat' );?></label>
                                            <div class="control"><input type="color" class="header_bg"   name="gwac_options[header_bg]" value="<?=isset( $this->options['header_bg'] ) ? esc_attr( $this->options['header_bg']) : '#095e54'?>"></div> 
                                        </div>
                                        <div class="form-control  viewtype2"  <?=($this->options['wa_view_type']!="2")?'style="display:none;"':'';?>>
                                            <label><?php echo __( 'Button Background Color', 'initchat' );?></label>
                                            <div class="control"><input type="color" class="btn_bg"   name="gwac_options[btn_bg]" value="<?=isset( $this->options['btn_bg'] ) ? esc_attr( $this->options['btn_bg']) : '#095e54'?>"></div> 
                                        </div>
                                        <div class="form-control  viewtype2"  <?=($this->options['wa_view_type']!="2")?'style="display:none;"':'';?>>
                                            <label><?php echo __( 'Button Text Color', 'initchat' );?></label>
                                            <div class="control"><input type="color" class="btn_text_clr"   name="gwac_options[btn_text_clr]" value="<?=isset( $this->options['btn_text_clr'] ) ? esc_attr( $this->options['btn_text_clr']) : '#ffffff'?>"></div> 
                                        </div>
                                      
                                    
                                </div>
                            
                                 <h3><?php echo __( 'Settings', 'initchat' );?></h3>
                               
                                <div class="group">
                                     <span><b><?php echo __( 'Vhat Popup Position', 'initchat' );?></b></span>
                                        <div class="form-control radio">
                                            <input type="radio" value="left" id="wa_align_left" name="gwac_options[wa_align]" <?=(isset( $this->options['wa_align'] ) && $this->options['wa_align']=="left")? 'checked="checked"' : ''?>><label for="wa_align_left"><?php echo __( 'Left', 'initchat' );?></label>
                                        </div>
                                        <div class="form-control radio">
                                            <input type="radio" value="Right" id="wa_align_right"  name="gwac_options[wa_align]" <?=(isset( $this->options['wa_align'] ) && $this->options['wa_align']=="Right")? 'checked="checked"' : ''?>><label for="wa_align_right"><?php echo __( 'Right', 'initchat' );?></label>
                                        </div>
                                        <div class="form-control radio">
                                            <input type="radio" value="Inline"  id="wa_align_inline"  name="gwac_options[wa_align]" <?=(isset( $this->options['wa_align'] ) && $this->options['wa_align']=="Inline")? 'checked="checked"' : ''?>><label for="wa_align_inline"><?php echo __( 'Inline', 'initchat' );?></label>
                                        </div>
                                        <div class="control inline_shortcode clear" style="display:none;"><p><?php echo __( 'With Model Dialog:', 'initchat' );?><code>[initChat]</code></p><p><?php echo __( 'Dialog Only:', 'initchat' );?><code>[initChat_Dialog]</code></p></div>
                                </div>
                                    
                                <?php 
                                    settings_fields( 'gwac_options' );
                                    submit_button();
                                ?>
                                
                            </div>
                        
                        </div>
                    </div>
                    
        	    </div>
        	    </form>
        	    <div class="preview">
        	        <br/><h2>Need Support ?</h2>
        	        <p>Looking for help or feedback please click the below link </p>
        	        <a href="https://www.initchat.com" title="initChat">Contact Us</a>
        	        <?= $this->wac->gwac_loadDialog(); ?>
        	    </div>
        	    
    	    </div>
    	    
    	</div>
    	
    	
    	<?php

    }
}