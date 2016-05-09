<?php
/*
Plugin Name: WP Sapphire Enquiry Form
Plugin URI: https://github.com/ara-j/WP-Sapphire-Enquiry-Form
Description: Last updated on: 2016-04-23 12:00 AM
Version: 1.0.3
Author: Future Covenant LLC.
Author URI: http://www.futurecovenant.com
License: A "Slug" license name e.g. GPL2
 */
global $sapphire_enquiry_form_url;
$sapphire_enquiry_form_url = plugin_dir_url( __FILE__ );
global $sapphire_admin_url;
$sapphire_admin_url = admin_url();

class sapphire_enquiry_form {

    public function show_sapphire_enquiry_form()
	{
		include(sprintf("%s/templates/sapphire-enquiry-form.php", dirname(__FILE__)));
        
	}


    public function __construct() 
    {
        add_action('admin_notices', array($this, 'plugin_activation'));

		add_action('admin_init', array(&$this, 'admin_init'));
		add_action('admin_menu', array(&$this, 'add_menu'));
		
		add_action('wp_enqueue_scripts', array(&$this, 'register_plugin_scripts'));
        add_action('wp_enqueue_scripts', array(&$this, 'register_plugin_styles'));
		
		add_shortcode('sapphire-enquiry-form', array(&$this, 'show_sapphire_enquiry_form') );

        add_action( 'admin_post_send_enquiry', array(&$this, 'save_enquiry'));
        add_action( 'admin_post_nopriv_send_enquiry', array(&$this, 'save_enquiry'));
    } 

	public function plugin_activation() 
    {


	} 

	public function admin_init()
	{
		register_setting('sapphire_enquiry_form', 'setting_sapphire_suitecrm_url');
		register_setting('sapphire_enquiry_form', 'setting_sapphire_suitecrm_admin_username');
		register_setting('sapphire_enquiry_form', 'setting_sapphire_suitecrm_admin_password');
		register_setting('sapphire_enquiry_form', 'setting_sapphire_suitecrm_admin_welcome_page');
	}

	public function add_menu()
	{
		add_options_page('WP Sapphire Enquiry Form Settings', 'Sapphire Enquiry', 'manage_options', 'sapphire_enquiry_form', array(&$this, 'plugin_settings_page'));
	}
	
	public function plugin_settings_page()
	{
		include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
	} 
	
    public function register_plugin_scripts() 
    {
		wp_register_script('javascript_sapphire_enqiry_form_jquery',plugin_dir_url( __FILE__ ).'assets/js/jquery-2.2.3.min.js');
		wp_enqueue_script('javascript_sapphire_enqiry_form_jquery');

        wp_register_script('javascript_sapphire_enqiry_form_validator',plugin_dir_url( __FILE__ ).'assets/js/jquery.validate.min.js');
		wp_enqueue_script('javascript_sapphire_enqiry_form_validator');

        wp_register_script('javascript_sapphire_enqiry_form',plugin_dir_url( __FILE__ ).'assets/js/sapphire_enqiry_form.js','','1.1', true);
		wp_enqueue_script('javascript_sapphire_enqiry_form');
    }
    
    public function register_plugin_styles() 
	{
		wp_register_style('style_sapphire_enqiry_form',plugin_dir_url( __FILE__ ).'assets/css/sapphire_enqiry_form.css');
		wp_enqueue_style('style_sapphire_enqiry_form');
    }

    function save_enquiry() {
        $url = get_option('setting_sapphire_suitecrm_url') . "/service/v4_1/rest.php";;

        $session_id = login();
        
        $email = $_POST['txtEmail'];
        $phone = $_POST['txtPhone'];
        
        $get_entry_list_contact_parameters = array(
             'session' => $session_id,
             'module_name' => 'Contacts',
             'query' => "contacts.id in (SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted = 0 and eabr.bean_module like 'contacts' and ea.email_address LIKE '" . $email . "%')",
             'order_by' => "",
             'offset' => '0',
             'select_fields' => array(
                  'id',
                  'email1',
             ),
             'max_results' => '2',
             'deleted' => '0',
             'Favorites' => false,
        );

        $get_entry_list_account_parameters = array(
             'session' => $session_id,
             'module_name' => 'Accounts',
             'query' => "accounts.id in (SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted = 0 and eabr.bean_module like 'accounts' and ea.email_address LIKE '" . $email . "%')",
             'order_by' => "",
             'offset' => '0',
             'select_fields' => array(
                  'id',
                  'email1',
             ),
             'max_results' => '2',
             'deleted' => '0',
             'Favorites' => false,
        );


        $get_entry_list_contact_result = call('get_entry_list', $get_entry_list_contact_parameters, $url);
        $get_entry_list_account_result = call('get_entry_list', $get_entry_list_account_parameters, $url);

        $isContactExist = ($get_entry_list_contact_result->total_count > 0);

        $contactId = "";
        $accountId = "";

        if ($isContactExist)
        {
            $contactId = $get_entry_list_contact_result->entry_list[0]->id;
            $accountId = $get_entry_list_account_result->entry_list[0]->id;
        }
        else
        {
            $set_account_entry_parameters = array(
                 "session" => $session_id,
                 "module_name" => "Accounts",
                 "name_value_list" => array(
                      array("name" => "name", "value" => $_POST["txtFirstName"] . " " . $_POST["txtLastName"]),
                      array("name" => "email1", "value" => $email),
                      array("name" => "phone_office", "value" => $phone),
                      array("name" => "account_type", "value" => "Client"),
                 ),
                );

            $set_account_entry_result = call("set_entry", $set_account_entry_parameters, $url);
            $accountId = $set_account_entry_result->id;

            $set_contact_entry_parameters = array(
                 "session" => $session_id,
                 "module_name" => "Contacts",
                 "name_value_list" => array(
                      array("name" => "first_name", "value" => $_POST["txtFirstName"]),
                      array("name" => "last_name", "value" => $_POST["txtLastName"]),
                      array("name" => "email1", "value" => $email),
                 ),
                );
            

            $set_contact_entry_result = call("set_entry", $set_contact_entry_parameters, $url);
            $contactId = $set_contact_entry_result->id;

            $relation_account_contact_Params = array(
                'session' => $session_id,
                'module_name' => 'Accounts',
                'module_id' => $accountId,
                'link_field_name' => 'contacts',
                'related_ids' => array($contactId),
            );

            $relationship_account_contact_result = call('set_relationship', $relation_account_contact_Params, $url);
        }

        $name = $_POST['txtFirstName'] . " " . $_POST['txtLastName'];
        $occasion = $_POST['drpOccasion'];
        $dateOfOccasion =  $_POST["txtDateOfOccasion"];
        $requiredServices = $_POST["drpServicesRequires"]; 
        $readyTime = $_POST["txtReadyTime"]; 
        $countOfPeopleNeedService = $_POST["txtPeopleCount"]; 
        $whereDoYouHearAboutUs = $_POST["drpWhereDidYouHear"]; 
        $readyLocation = $_POST["txtReadyLocation"]; 
        $otherDetails = $_POST["txtOtherDetails"]; 
        $region = $_POST["drpRegion"]; 
        $phone = $_POST["txtPhone"]; 



        $set_entry_parameters = array(
             "session" => $session_id,
             "module_name" => "FCC_Enquires",
             "name_value_list" => array(
                  array("name" => "name", "value" => $name),
                  array("name" => "occasion", "value" => $occasion),
                  array("name" => "date_of_enquiry", "value" => date("Y-m-d")),
                  array("name" => "date_of_occasion", "value" =>$dateOfOccasion),
                  array("name" => "required_services", "value" => $requiredServices),
                  array("name" => "ready_time", "value" => $readyTime),
                  array("name" => "how_many_people_require_servic", "value" => $countOfPeopleNeedService),
                  array("name" => "where_did_you_hear_about_us", "value" => $whereDoYouHearAboutUs),
                  array("name" => "location_where_you_are_getting", "value" => $readyLocation),
                  array("name" => "region_c", "value" => $region),
                  array("name" => "description", "value" => $otherDetails),
             ),
        );
        

        $set_entry_result = call("set_entry", $set_entry_parameters, $url);

        
        $relation_enquiry_contact_Params = array(
            'session' => $session_id,
            'module_name' => 'FCC_Enquires',
            'module_id' => $set_entry_result->id,
            'link_field_name' => 'contacts_fcc_enquires_1',
            'related_ids' => array($contactId),
        );

        $relation_enquiry_account_Params = array(
            'session' => $session_id,
            'module_name' => 'FCC_Enquires',
            'module_id' => $set_entry_result->id,
            'link_field_name' => 'accounts_fcc_enquires_1',
            'related_ids' => array($accountId),
        );

        $relationship_enquiry_contact_result = call('set_relationship', $relation_enquiry_contact_Params, $url);
        $relationship_enquiry_account_result = call('set_relationship', $relation_enquiry_account_Params, $url);

        status_header(200);
        print_r("<span class='success'>Enquiry has seen saved successfully.</span>");
    }


} 

    function call($method, $parameters, $url)
    {
        ob_start();
        $curl_request = curl_init();

        curl_setopt($curl_request, CURLOPT_URL, $url);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl_request, CURLOPT_HEADER, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_request, CURLOPT_FOLLOWLOCATION, 0);

        $jsonEncodedData = json_encode($parameters);

        $post = array(
             "method" => $method,
             "input_type" => "JSON",
             "response_type" => "JSON",
             "rest_data" => $jsonEncodedData
        );

        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($curl_request);
        curl_close($curl_request);

        $result = explode("\r\n\r\n", $result, 2);
        $response = json_decode($result[1]);
        ob_end_flush();

        return $response;
    }

    function login()
    {
        $url = get_option('setting_sapphire_suitecrm_url') . "/service/v4_1/rest.php";
        $username = get_option('setting_sapphire_suitecrm_admin_username');
        $password =  get_option('setting_sapphire_suitecrm_admin_password');
       
        $login_parameters = array(
         "user_auth" => array(
              "user_name" => $username,
              "password" => md5($password),
              "version" => "1"
         ),
         "application_name" => "RestTest",
         "name_value_list" => array(),
        );

        $login_result = call("login", $login_parameters, $url);
        return $login_result->id;
    }

function run_sapphire_enquiry_form () {
	$instance = new sapphire_enquiry_form();
	return $instance;
}

run_sapphire_enquiry_form();

 ?>