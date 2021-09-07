jQuery( document ).ready( function(){
    jQuery( document ).on( "change", "#upl_layout", function(){
        var layoutID = jQuery(this).val();
        if( layoutID != '' ) {
            jQuery('.hide').show();
            jQuery.ajax({
                type: "post",
                url: readmelater_ajax.ajax_url,
                data:{
                    action : 'my_ajax_handler',
                    ajaxType : 'save_layout',
                    layoutIDS : layoutID
                    },
                success: function(result){
                    jQuery('.hide').hide();
                    console.log(result);                     
                }
            }); 
        }
    });
});