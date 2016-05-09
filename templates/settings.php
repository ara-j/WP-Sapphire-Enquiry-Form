<style>
    #sapphire_settings {
    }
        #sapphire_settings div {
            margin: 0 0 15px 0;
        }

            #sapphire_settings div label {
                display: block;
                font-size:16px;
                padding:4px 0px;
            }

            #sapphire_settings div input {
                padding:10px 10px;
            }
</style>
<div class="wrap">
    <h2 style="margin:4px 0 25px 0px">WP Sapphire Enquiry Forms Settings</h2>
    <p>Please fill your SuiteCRM URL and administrator login information in the following fields.</p>
    <p>Fill your WordPress page name as your welcome page. This page will be shown after the form submission.</p>
    <p>After saving the below information, you can use the Enquiry Form by adding <strong>[sapphire-enquiry-form]</strong> short code to any page or post.</p>
    <p>&nbsp;</p>
    <form method="post" action="options.php"> 
        <?php @settings_fields('sapphire_enquiry_form'); ?>
        <?php @do_settings_fields('sapphire_enquiry_form'); ?>

        <div id="sapphire_settings">  
            <div>
                <label for="setting_sapphire_suitecrm_url">SuiteCRM URL</label>
                <input type="text" name="setting_sapphire_suitecrm_url" style="width:80%" id="setting_sapphire_suitecrm_url" value="<?php echo get_option('setting_sapphire_suitecrm_url'); ?>" />
            </div>
            <div>
                <label for="setting_sapphire_suitecrm_admin_username">Admin Username</label>
                <input type="text" name="setting_sapphire_suitecrm_admin_username" id="setting_sapphire_suitecrm_admin_username" value="<?php echo get_option('setting_sapphire_suitecrm_admin_username'); ?>" />
            </div>
            <div>
                <label for="setting_sapphire_suitecrm_admin_password">Admin Password</label>
                <input type="password" name="setting_sapphire_suitecrm_admin_password" id="setting_sapphire_suitecrm_admin_password" value="<?php echo get_option('setting_sapphire_suitecrm_admin_password'); ?>" />
            </div>
            <hr />
            <div>
                <label for="setting_sapphire_suitecrm_admin_welcome_page">WordPress Welcome Page</label>
                <input type="text" name="setting_sapphire_suitecrm_admin_welcome_page"  style="width:80%" id="setting_sapphire_suitecrm_admin_welcome_page" value="<?php echo get_option('setting_sapphire_suitecrm_admin_welcome_page'); ?>" />
            </div>
        </div>

        <?php @submit_button(); ?>
    </form>
</div>