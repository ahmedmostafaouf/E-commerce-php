$(function () {

    'use strict';
    // Switch Between Login & Signup

	$('.login-page h1 span').click(function () {

		$(this).addClass('selected').siblings().removeClass('selected');

		$('.login-page form').hide();

		$('.' + $(this).data('class')).fadeIn(100);

	});
    // Dashboard 

	$('.toggel-info').click(function () {

    // كلاس الانفو لما ادوس عليه كلك الاب بتاعه هيخش ع الي بعده ويقوم خافي الي فيه وبعد كده اما يخفي هعملخ كلاس اسمو سيليكتد
		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

		if ($(this).hasClass('selected')) {
      // لو اسبان فيها كلاس سيلكتد اعملها مينص

			$(this).html('<i class="fa fa-minus fa-lg"></i>');

		} else {

			$(this).html('<i class="fa fa-plus fa-lg"></i>');

    }

	});

    //triger selectbox
   
    //Hide placeholder on form focus
   //اول اما اضغط عليه يحصل ايه البلاس بتاعي بيعمل اتربيوت داتا تيكست جوا اتربيوت يحطه جوه البلاس هولدر
    $('[placeholder]').focus(function () {
     $(this).attr('data-text', $(this).attr('placeholder'));
     $(this).attr('placeholder', '');
    }) .blur(function () {
      $(this).attr('placeholder', $(this).attr('data-text'));
     });
     // add asterisk on required faild
     $('input').each(function(){
       if($(this).attr('required') === 'required'){
          $(this).after('<span class = "asterisk"> * </span>');
       }

     });
     
     // confirmation massege on bnt (delete)
     $('.confirm').click(function () {
     return confirm('Are you Sure ?');
    });
   
    $('.live-name').keyup(function(){
       $('.live-preview .caption h3').text($(this).val()); 
    });
    $('.live-desc').keyup(function(){
      $('.live-preview .caption p').text($(this).val()); 
   });
   $('.live-price').keyup(function(){
    $('.live-preview .price-tag').text('$' + $(this).val()); 
 });
 
    
   }); 
   