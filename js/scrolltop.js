jQuery(document).ready(function(){

jQuery(window).scroll(function() {  
if(jQuery(this).scrollTop() != 0) {
jQuery('#gtt_link').fadeIn();
} 
else { 
jQuery('#gtt_link').fadeOut(); 
}
});
jQuery('#gtt_link').click(function() {
jQuery('body,html').animate({scrollTop:0}, 800); 
});

})