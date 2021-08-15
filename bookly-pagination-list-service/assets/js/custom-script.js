// when update the new bookly plugin its not show bookly-js-select-service nad bookly-js-select-category in js file 
// so as per old version its functioning either new version try to anotehr approach(finding...)
jQuery(".class_a").click(function() {
    jQuery(".bookly-js-select-service").val(jQuery(this).attr("id"));
    jQuery(".bookly-js-select-category").val(jQuery(this).attr("cat_id"));
});