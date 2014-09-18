jQuery(document).ready(function($) {

  // Your JavaScript goes here
  $(".navbar a[href^='#']").on('click', function(e) {
    // prevent default anchor click behavior
    e.preventDefault();

    // store hash
    var hash = this.hash;

    // animate
    $('html, body').animate({
      scrollTop: $(this.hash).offset().top - 75
      }, 300, function(){
      window.location.hash = hash;
    });

  });


  $(window).load(function(){
      $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 120,
        itemMargin: 20,
        asNavFor: '#slider',
		start: function(slider) {
  if (slider.pagingCount == 1) slider.addClass('flex-centered');
}
      });

      $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
		directionNav: false,
        animationLoop: false,
        slideshow: true,
        sync: "#carousel",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });

    $("#about .pricing .panel-body .business:nth-child(2)").css("border","none");

    $(".btn-scroll").on('click', function(e) {
		      e.preventDefault();
		// animate
		    $('html, body').animate({
			         scrollTop: $(this.hash).offset().top - 75
		           }, 300, function(){

			         window.location.hash = hash;
		      });
	   });


      $('#subscribe').prop('disabled',true);

      $('#newsletter .form-inline input#fieldEmail,#newsletter .form-inline input#fieldName,#newsletter .form-inline input#fieldzsjj').keypress(function(){
        if($('#newsletter .form-inline input#fieldName').val() !== ''
          && $('#newsletter .form-inline input#fieldzsjj').val() !== ''){
              $('#subscribe').prop('disabled',false);
          }
      })

     /*end document ready */
});
