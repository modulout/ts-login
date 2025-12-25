jQuery(document).ready(function($){
    $('.tsl_colorpicker').wpColorPicker();

    /* Reset colors to default */
    $('#tsl_reset_colors').on('click', function() {
        if (confirm('Are you sure you want to reset all colors to default values?')) {
            $('.tsl_colorpicker').each(function() {
                var defaultColor = $(this).data('default-color');
                $(this).val(defaultColor);
                $(this).wpColorPicker('color', defaultColor);
            });
        }
    });

    /* Logout options */
    var tsl_logout = $("#tsl_logout_option").find(":selected").val();
    if(tsl_logout == 2) {
        $(".tsl_logout_1").hide();
    } else {
        $(".tsl_logout_2").hide();
    }

    $("#tsl_logout_option").on("change", function(){
        $(".tsl_logout_1").toggle();
        $(".tsl_logout_2").toggle();
    });

    /* Form style */
    var tsl_form_style = $("#tsl_form_template").find(":selected").val();
    if(tsl_form_style === "1") {
        $(".tsl_form_img").hide();
    }

    $("#tsl_form_template").on("change", function(){
        if($(this).find(":selected").val() > 1) {
            $(".tsl_form_img").show();
        } else {
            $(".tsl_form_img").hide();
        }
    });
});