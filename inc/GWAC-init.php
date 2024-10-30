<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
include(GWAC_PATH."/inc/GWAC-dialog.php");

//Class for the setup plugin menu and initialization 
class gwac_main extends gwac_dialog {
    function __construct(){
        
        //Setup admin panel
        if(is_admin()){
            parent::__construct(true);
            $this->gwac_admin_area();
            
        }
        else
        parent::__construct(false);
        

    }
    //gwac_admin_area() help to load admin panel design and setup widget settings
     function gwac_admin_area(){
       
        //Call admin area class 
        include(GWAC_PATH."/inc/GWAC-admin.php");
        new gwac_admin($this);
        
    }
    
}
