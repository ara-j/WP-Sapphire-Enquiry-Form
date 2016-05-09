<div id="Enquiry-Form">
    <div id="sapphire-result">
    </div>

    <form method="post" id="Enquiry-Form-f">
        <div class="row">
            <div class="col col6 required">
                <label>First Name:</label>
                <input type="text" name="txtFirstName" id="txtFirstName" />
            </div>
            <div class="col col6">
                <label>Last Name:</label>
                <input type="text" name="txtLastName" id="txtLastName" value="" size="40" aria-invalid="false" />
            </div>
        </div>
        <div class="row">
            <div class="col col6">
                <label>Phone:</label>
                <input type="tel" name="txtPhone" id="txtPhone" value="" size="40" aria-invalid="false" />
            </div>
            <div class="col col6 required">
                <label>Email:</label>
                <input type="email" name="txtEmail" id="txtEmail" value="" size="40" aria-invalid="false" />
            </div>
        </div>
        <div class="row">
            <div class="col col6 required">
                <label>
                    Occasion
                </label>
                <select name="drpOccasion" id="drpOccasion" aria-invalid="false">
                    <option value="">Select One</option>
                    <option value="Wedding">Wedding</option>
                    <option value="School_Formal">School Formal</option>
                    <option value="Special_Occasion">Special Occasion</option>
                    <option value="Corporate Event">Corporate Event</option>
                </select>
            </div>
            <div class="col col6 required">
                <label>
                    Services required
                </label>
                <select name="drpServicesRequires" id="drpServicesRequires" aria-invalid="false">
                    <option value="">Select One</option>
                    <option value="Hair_and_Makeup">Hair &amp; Makeup</option>
                    <option value="Hair_Only">Hair Only</option>
                    <option value="F">Makeup Only</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col col12 required">
                <label>Date of Occasion</label>
                <input type="text" name="txtDateOfOccasion" id="txtDateOfOccasion" value="" style="width: 250px;" placeholder="yyyy-mm-dd" />

            </div>
        </div>
        <div class="row">
            <div class="col col12  required">
                <label>
                    How many people require services?
                </label>
                <input type="text" name="txtPeopleCount" id="txtPeopleCount" value="" size="5" style="width: 100px;" />
            </div>
        </div>
        <div class="row">
            <div class="col col12 required">
                <label>Suburb/location where you are getting ready?</label>
                <input type="text" name="txtReadyLocation" id="txtReadyLocation" value="" />
            </div>
        </div>
        <div class="row">
            <div class="col col12 required">
                <label>Region/State</label>
                <select name="drpRegion" id="drpRegion" style="width: 250px;">
                    <option value="Select One">Select One</option>
                    <option value="Brisbane &amp; Surrounds">Brisbane &amp; Surrounds</option>
                    <option value="Gold Coast/Tweed">Gold Coast/Tweed</option>
                    <option value="Sunshine Coast &amp; Surrounds">Sunshine Coast &amp; Surrounds</option>
                    <option value="Sydney &amp; Surrounds">Sydney &amp; Surrounds</option>
                    <option value="Hunter Valley/Newcastle">Hunter Valley/Newcastle</option>
                    <option value="Port Macquarie">Port Macquarie</option>
                    <option value="Melbourne &amp; Surrounds">Melbourne &amp; Surrounds</option>
                    <option value="Perth &amp; Surrounds">Perth &amp; Surrounds</option>
                    <option value="Canberra &amp; Surrounds">Canberra &amp; Surrounds</option>
                    <option value="Adelaide &amp; Surrounds">Adelaide &amp; Surrounds</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col col12 required">
                <label>What time do you need to be ready by?</label>
                <input type="text" name="txtReadyTime" id="txtReadyTime" value="" style="width: 100px;" />
            </div>
        </div>
        <div class="row">
            <div class="col col12 required">
                <label>Where did you hear about us?</label>
                <select name="drpWhereDidYouHear" id="drpWhereDidYouHear" style="width: 250px;">
                    <option value="Select One">Select One</option>
                    <option value="Google">Google</option>
                    <option value="Easy Weddings">Easy Weddings</option>
                    <option value="I-do.com.au">I-do.com.au</option>
                    <option value="Bride Online">Bride Online</option>
                    <option value="Car advertising">Car advertising</option>
                    <option value="Magazine advertising">Magazine advertising</option>
                    <option value="Refferedbyafriend">Refferedbyafriend</option>
                    <option value="Referredbyanotherbusiness">Referredbyanotherbusiness</option>
                    <option value="Other-pleasespecifiy">Other-pleasespecifiy</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col col12">
                <label>Any other details/ questions</label>
                <textarea name="txtOtherDetails" id="txtOtherDetails" cols="40" rows="10" aria-invalid="false"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col col12">
                <input type="submit" id="save-enquiry" value="Submit Enquiry" class="submit-form" />
            </div>
        </div>
        <div class="row">
            <div id="sapphire-loader">
                Please wait to book your enquiry...
                <img src="<?php global $sapphire_enquiry_form_url; echo $sapphire_enquiry_form_url ?>assets/img/loader.gif" />
            </div>
        </div>

    </form>

</div>
<input type="hidden" id="site_url" value="<?php global $sapphire_admin_url; echo $sapphire_admin_url ?>admin-post.php?action=send_enquiry" />
<input type="hidden" id="welcome_page_url" value="<?php echo get_option('setting_sapphire_suitecrm_admin_welcome_page'); ?>" />

