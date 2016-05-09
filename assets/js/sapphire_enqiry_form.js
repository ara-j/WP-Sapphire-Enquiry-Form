var formValidator = jQuery('#Enquiry-Form-f').validate({
    rules: {
        txtFirstName: {
            required: true
        },
        txtEmail: {
            required: true,
            email: true
        },
        drpOccasion: {
            required: true
        },
        drpServicesRequires: {
            required: true
        },
        txtDateOfOccasion: {
            required: true
        },
        txtPeopleCount: {
            required: true
        },
        txtReadyLocation: {
            required: true
        },
        drpRegion: {
            required: true
        },
        txtReadyTime: {
            required: true
        },
        drpWhereDidYouHear: {
            required: true
        }

    },
    messages: {
        txtFirstName: "Please enter a valid name.",
        txtEmail: "Please enter a valid email address.",
        drpOccasion: "Please specify occasion type.",
        drpServicesRequires: "Please select one of our services.",
        txtDateOfOccasion: "Please specify occasion date.",
        txtPeopleCount: "Please enter the number of people who need to our services.",
        txtReadyLocation: "Please enter the location.",
        drpRegion: "Please select the location.",
        txtReadyTime: "Please enter the time.",
        drpWhereDidYouHear: "Please help us by filling this field."

    }

});

function get_fomr_serialized_data() {
    var result = "";
    result =
        {
            'txtFirstName': jQuery("#txtFirstName").val(),
            'txtLastName': jQuery("#txtLastName").val(),
            'txtPhone': jQuery("#txtPhone").val(),
            'txtEmail': jQuery("#txtEmail").val(),
            'drpOccasion': jQuery("#drpOccasion").val(),
            'drpServicesRequires': jQuery("#drpServicesRequires").val(),
            'txtDateOfOccasion': jQuery("#txtDateOfOccasion").val(),
            'txtPeopleCount': jQuery("#txtPeopleCount").val(),
            'drpRegion': jQuery("#drpRegion").val(),
            'txtReadyLocation': jQuery("#txtReadyLocation").val(),
            'txtReadyTime': jQuery("#txtReadyTime").val(),
            'drpWhereDidYouHear': jQuery("#drpWhereDidYouHear").val(),
            'txtOtherDetails': jQuery("#txtOtherDetails").val(),
        };

    return result;

}

var enquiryForm = document.getElementById('Enquiry-Form-f');

if (enquiryForm != null) {

    enquiryForm.addEventListener('submit', function (event) {
        event.preventDefault();
        if (formValidator.valid()) {
            jQuery("#sapphire-loader").fadeIn(300);
            var url = jQuery("#site_url").val();
            var welcomepage = jQuery("#welcome_page_url").val();

            jQuery.ajax({
                url: url,
                type: 'POST',
                data: get_fomr_serialized_data(),
                error: function () {
                    alert('error');
                    jQuery("#sapphire-loader").fadeOut(300);
                },
                success: function (data) {
                    jQuery("#Enquiry-Form-f").fadeOut();

                    jQuery("#sapphire-result").html(data);

                    jQuery('html, body').animate({
                        scrollTop: jQuery("#Enquiry-Form").offset().top - 100
                    }, 1000);

                    setTimeout("window.location.href='" + welcomepage + "'", 4000);
                },
                done: function (date) {
                    jQuery("#sapphire-loader").fadeOut(300);
                }
            });

        }
        return false;
    }, false);
}