<?php

namespace FCFS;

//This API endpoint retrieves the frontend list for display in the UI
class API_ClickList{

    public $namespace = "fcfs/v1";

    //This is an un-authenticated API:
    public $capability /*to use API*/ = 'exist';

    public $methods = ['GET'];

    public function doAction($args){
        //At this point, there will always be a post ID, however there may not be a valid post
        $postID = $_REQUEST['post-id'];
        $List = new ClickList;
        $status = $List->fetchFromDB($postID);
        if ( \is_wp_error( $status )) {
            return $status;
        }

        return ($List->doReturnListJSON());
    }

    public function doRegisterRoutes(){
		register_rest_route(
			$this->namespace,
			"settings",
			array(
				'methods' => ['POST'],
				'callback' => function () {
					return ($this->doAction($_REQUEST));
				},
				'permission_callback' => function () {
					$capability = $this->capability;
					if (!(current_user_can($capability))) {
						return FALSE;
					}
					return TRUE;
				},
				'validate_callback' => function () {
					if(isset($_REQUEST['post-id']) && (is_numeric($_REQUEST['post-id']))){
						return TRUE;
					}else{
						return FALSE;
					}
				}
			)
		);

		register_rest_route(
			$this->namespace,
			"settings",
			array(
				'methods' => ['POST'],
				'callback' => function () {
					return ($this->doAction($_REQUEST));
				},
				'permission_callback' => function () {
					$capability = $this->capability;
					if (!(current_user_can($capability))) {
						return FALSE;
					}
					return TRUE;
				},
				'validate_callback' => function () {
					if(isset($_REQUEST['post-id']) && (is_numeric($_REQUEST['post-id']))){
						return TRUE;
					}else{
						return FALSE;
					}
				}
			)
		);
    }
}
