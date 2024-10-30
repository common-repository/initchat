<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

//Class for the setup startchat dialog box 
class gwac_dialog {

    private $admin=false;
    private $opt=null;
    private $enable=true;
    function __construct($id_admin=false){
      
        $this->admin=$id_admin;
        $this->opt = get_option( 'gwac_options' );
        $this->enable=(!isset($this->opt['wa_enabled']) || $this->opt['wa_enabled']=="YES")?true:false;
        
       
            /* Enqueues admin scripts. */
            if($this->admin)
                add_action( 'admin_enqueue_scripts', array($this,'add_gwac_style' ));
            else{
                if($this->enable){
                    add_action( 'wp_enqueue_scripts', array($this,'add_gwac_style' ));
                    add_action('wp_footer', array($this,'gwac_load_dialog_on_front')); 
                }
            }
        
        //For inline shortcode
        add_shortcode('initChat', array($this,"gwac_loadDialog_shortcode")); 
        add_shortcode('initChat_Dialog', array($this,"'inline_dialog'")); 
        
    }
    function inline_dialog() { 
    
        // Output needs to be return
        if($this->enable){
                return $this->gwac_getDoalog(true);
        }else return "";
        
        return __( 'Chat disabled from backend.', 'initchat' );
    } 
    function gwac_loadDialog_shortcode(){
        
        if(!$this->enable) return __( 'Chat disabled from backend.', 'initchat' );
        
        if($this->opt['wa_align']=="inline") return '';
        $ct ='<div id="gwc-324" class="'.(isset($this->opt['wa_align'])?$this->opt['wa_align']:'right').'">';
        $ct .='<div class="gwc-wrap">';
        if(trim($this->opt['wa_view_type'])!="1"  || $this->admin)
        $ct.=$this->gwac_getDoalog(false);
        $ct.=$this->gwac_getWidget();
        $ct.='</div></div>';
        $ct.=$this->gwac_sript();
        return $ct;
    }
    function gwac_load_dialog_on_front(){
        echo $this->gwac_loadDialog();
    }
    function add_gwac_style($page){
         wp_enqueue_style( 'gwac_style', GWAC_URL.'/css/wp-chat.css');
    }
    function gwac_loadDialog(){
        
        if($this->enable || $this->admin){
            if(isset($this->opt['wa_align']) && $this->opt['wa_align']=="inline") return '';
            $ct ='<div id="gwc-324" class="'.(isset($this->opt['wa_align'])?$this->opt['wa_align']:'right').'">';
            $ct .='<div class="gwc-wrap">';
            if((isset($this->opt['wa_view_type']) && trim($this->opt['wa_view_type'])!="1") || $this->admin){
                $ct.=$this->gwac_getDoalog($active=false);
            }
            $ct.=$this->gwac_getWidget();
            $ct.='</div></div>';
            $ct.=$this->gwac_sript();
           
            return $ct;
        }
        return "";
    }
    function gwac_getWidget(){
        
        $html="";
        $class="";
        //CHECKING VIEW TYPE FOR SHOWING AS A SMALL VIEW 
        if(isset($this->opt['wa_view_type']) && $this->opt['wa_view_type']=="1"){
            
            global $wp;
            $gwc_page=get_the_title();
            if(empty($gwc_page))
                $gwc_page=single_cat_title();
            if(empty($gwc_page))
                $gwc_page=get_bloginfo();
                
            $class="tooltipview";
            $wpanumber=(isset($this->opt['wa_number'])?$this->opt['wa_number']:'');
            $gwc_replay_message=(isset($this->opt['wa_rpmessage'])?$this->opt['wa_rpmessage']:__( "Hello,\nI'm looking your help on *{PAGE}*\n{URL}.", 'initchat' ));
            
            
            $gwac_page_url=home_url( $wp->request );
        
                $gwc_replay_message=str_replace("{PAGE}",$gwc_page,$gwc_replay_message);
                $gwc_replay_message=str_replace("{URL}",$gwac_page_url,$gwc_replay_message);
         
            $html='<div class="gwc-tootltip">'.$this->opt['wa_chatbt'].'</div> <a href="https://wa.me/'.$wpanumber.'?text='.(urlencode($gwc_replay_message)).'" target="_blank">';
        }
        $html.= '<div class="gwc-widget '.$class.'" style="background-color:'.(isset($this->opt['cwd_bg'])?$this->opt['cwd_bg']:'#fff').';">
                    <svg viewBox="0 0 90 90" fill="'.(isset($this->opt['cwd_clr'])?$this->opt['cwd_clr']:'rgb(79, 206, 93)').'" width="32" height="32"><path d="M90,43.841c0,24.213-19.779,43.841-44.182,43.841c-7.747,0-15.025-1.98-21.357-5.455L0,90l7.975-23.522   c-4.023-6.606-6.34-14.354-6.34-22.637C1.635,19.628,21.416,0,45.818,0C70.223,0,90,19.628,90,43.841z M45.818,6.982   c-20.484,0-37.146,16.535-37.146,36.859c0,8.065,2.629,15.534,7.076,21.61L11.107,79.14l14.275-4.537   c5.865,3.851,12.891,6.097,20.437,6.097c20.481,0,37.146-16.533,37.146-36.857S66.301,6.982,45.818,6.982z M68.129,53.938   c-0.273-0.447-0.994-0.717-2.076-1.254c-1.084-0.537-6.41-3.138-7.4-3.495c-0.993-0.358-1.717-0.538-2.438,0.537   c-0.721,1.076-2.797,3.495-3.43,4.212c-0.632,0.719-1.263,0.809-2.347,0.271c-1.082-0.537-4.571-1.673-8.708-5.333   c-3.219-2.848-5.393-6.364-6.025-7.441c-0.631-1.075-0.066-1.656,0.475-2.191c0.488-0.482,1.084-1.255,1.625-1.882   c0.543-0.628,0.723-1.075,1.082-1.793c0.363-0.717,0.182-1.344-0.09-1.883c-0.27-0.537-2.438-5.825-3.34-7.977   c-0.902-2.15-1.803-1.792-2.436-1.792c-0.631,0-1.354-0.09-2.076-0.09c-0.722,0-1.896,0.269-2.889,1.344   c-0.992,1.076-3.789,3.676-3.789,8.963c0,5.288,3.879,10.397,4.422,11.113c0.541,0.716,7.49,11.92,18.5,16.223   C58.2,65.771,58.2,64.336,60.186,64.156c1.984-0.179,6.406-2.599,7.312-5.107C68.398,56.537,68.398,54.386,68.129,53.938z"></path></svg>
                    <span class="notification"></span>
                </div>';
        if($this->opt['wa_view_type']=="1") $html.="</a>";
        return $html;
    }
    function gwac_getDoalog($active=false){
        $user=wp_get_current_user();
        $blogname=get_bloginfo('name');
        $blogdesc=get_bloginfo('description');
        $agent=(isset($this->opt['wa_name'])?$this->opt['wa_name']:$blogname);
        $wpanumber=(isset($this->opt['wa_number'])?$this->opt['wa_number']:'');
        
        $agent_imgae=GWAC_URL.'/img/person.png';
        if(isset($this->opt['agent_image']) && intval($this->opt['agent_image'])>0){
            $att_id=intval($this->opt['agent_image']);
            $agent_imgae=wp_get_attachment_image_src( $att_id, 'thumbnail');
            if(isset($agent_imgae[0]))
                $agent_imgae=$agent_imgae[0];
        }
        
        $gwc_replay_message=(isset($this->opt['wa_rpmessage'])?$this->opt['wa_rpmessage']:__( "Hello,\nI'm looking your help on *{PAGE}*\n{URL}.", 'initchat' ));
        
        
       
    $gwc_page=get_the_title();
    if(empty($gwc_page))
        $gwc_page=single_cat_title();
    if(empty($gwc_page))
        $gwc_page=get_bloginfo();
        
    global $wp;
    $gwac_page_url=home_url( $wp->request );

        $gwc_replay_message=str_replace("{PAGE}",$gwc_page,$gwc_replay_message);
        $gwc_replay_message=str_replace("{URL}",$gwac_page_url,$gwc_replay_message);

        $brmessage=(isset($this->opt['wa_wcmessage']))?str_replace(PHP_EOL,"<br>",$this->opt['wa_wcmessage']):'';
        $brmessage=str_replace('\n',"<br>",$brmessage);

        
        return  '<div class="gwc-dialog" >
                    <div class="gwc-head" '.(isset($this->opt['header_bg'])?'style="background-color:'.$this->opt['header_bg'].'"':'').'>
                        <div class="gwc-img">
                            <img src="'.$agent_imgae.'" class="gwc-i" width="56px">
                            <span></span>
                        </div>
                        <div class="gwc-htext">
                            <div class="gwc-name">'.$agent.'</div>  
                            <div class="gwc-title">'.(isset($this->opt['wa_caption'])?$this->opt['wa_caption']:$blogdesc).'</div>
                        </div>
                    </div>
                    <div class="gwc-body">
                        <div class="gwc-wrapper">
                        <div class="gwc-message">
                            <div class="gwc-agent-name">'.$agent.'</div>
                            <div class="gwc-text">'.(isset($this->opt['wa_wcmessage'])?$brmessage:__( 'Hi there 👋<br>How can I help you?', 'initchat' )).'</div>
                            <div class="gwc-message-time">'.__( 'Just Now', 'initchat' ).'</div>
                        </div>
                        </div>
                         <div class="gwc-footer">
                            <a href="https://wa.me/'.$wpanumber.'?text='.(urlencode($gwc_replay_message)).'" target="_blank" class="gwc-button initchat" id="windlow_open" style="'.(isset($this->opt['btn_bg'])?'background-color:'.$this->opt['btn_bg'].';':'').(isset($this->opt['btn_text_clr'])?'color:'.$this->opt['btn_text_clr'].';':'').'"><svg width="20" height="20" viewBox="0 0 90 90" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" class="startchatButton__Icon-jyajcx-0 jkaHSM"><path d="M90,43.841c0,24.213-19.779,43.841-44.182,43.841c-7.747,0-15.025-1.98-21.357-5.455L0,90l7.975-23.522   c-4.023-6.606-6.34-14.354-6.34-22.637C1.635,19.628,21.416,0,45.818,0C70.223,0,90,19.628,90,43.841z M45.818,6.982   c-20.484,0-37.146,16.535-37.146,36.859c0,8.065,2.629,15.534,7.076,21.61L11.107,79.14l14.275-4.537   c5.865,3.851,12.891,6.097,20.437,6.097c20.481,0,37.146-16.533,37.146-36.857S66.301,6.982,45.818,6.982z M68.129,53.938   c-0.273-0.447-0.994-0.717-2.076-1.254c-1.084-0.537-6.41-3.138-7.4-3.495c-0.993-0.358-1.717-0.538-2.438,0.537   c-0.721,1.076-2.797,3.495-3.43,4.212c-0.632,0.719-1.263,0.809-2.347,0.271c-1.082-0.537-4.571-1.673-8.708-5.333   c-3.219-2.848-5.393-6.364-6.025-7.441c-0.631-1.075-0.066-1.656,0.475-2.191c0.488-0.482,1.084-1.255,1.625-1.882   c0.543-0.628,0.723-1.075,1.082-1.793c0.363-0.717,0.182-1.344-0.09-1.883c-0.27-0.537-2.438-5.825-3.34-7.977   c-0.902-2.15-1.803-1.792-2.436-1.792c-0.631,0-1.354-0.09-2.076-0.09c-0.722,0-1.896,0.269-2.889,1.344   c-0.992,1.076-3.789,3.676-3.789,8.963c0,5.288,3.879,10.397,4.422,11.113c0.541,0.716,7.49,11.92,18.5,16.223   C58.2,65.771,58.2,64.336,60.186,64.156c1.984-0.179,6.406-2.599,7.312-5.107C68.398,56.537,68.398,54.386,68.129,53.938z"></path></svg> <span>'.(isset($this->opt['wa_chatbt'])?$this->opt['wa_chatbt']:__( 'initChat', 'initchat' )).'</span></a>
                                <a href="https://initchat.com/" target="_blank" class="initchat">By initChat</a>
                        </div>
                    </div>
                   
                </div>';
    }
    
    function gwac_sript(){      
        return '
        <script>
       function loadModel(a){var t=!a(".gwc-dialog").hasClass("active");t&&setTimeout(function(){a(".gwc-dialog").css({display:"block"}).animate({opacity:1,bottom:70},{queue:!1,duration:300}),a(".gwc-wrap .gwc-widget span.notification").addClass("active")},3500),a(".gwc-widget").on("click",function(){return a(".gwc-wrap .gwc-widget span.notification").removeClass("active"),t?a(".gwc-dialog").animate({opacity:0,bottom:0},{queue:!1,duration:300,complete:function(){a(".gwc-dialog").css({display:"none"})}}):(a(".gwc-dialog").css({display:"block"}).animate({opacity:1,bottom:70},{queue:!1,duration:300}),a(".gwc-wrap .gwc-widget span.notification").addClass("active")),t=!t,!!a(".gwc-widget").hasClass("tooltipview")})}var script;window.jQuery?jQuery(document).ready(function(a){loadModel(jQuery)}):((script=document.createElement("script")).type="text/javascript",script.src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js",document.getElementsByTagName("head")[0].appendChild(script),setTimeout(function(){loadModel(jQuery)},30));
            </script>';
    }
}
?>