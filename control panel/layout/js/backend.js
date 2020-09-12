$(function () {

    'use strict';
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
     //convert password field to text field on hover
     var passField = $('.password');

     $('.show-pass').hover(function () {
   
       passField.attr('type', 'text');
   
     }, function () {
   
       passField.attr('type', 'password');
   
     });
     // confirmation massege on bnt (delete)
     $('.confirm').click(function () {
     return confirm('Are you Sure ?');
    });
    // category view option
    $('.cat h3').click(function(){
      $(this).next('.full-view').fadeToggle(200)
    });
    $('.option span').click(function()
    {
      $(this).addClass('Active').siblings('span').removeClass('Active');
      if($(this).data('view')==='full'){
        $('.cat .full-view').fadeIn(200);

      }else{
        $('.cat .full-view').fadeOut(200);
      }
    });
    // show delete btn on child cat s
    // this me   next after shape 
    $('.child-link').hover(function(){
      $(this).find('.show-delete').fadeIn(400);
    },
      function(){ 
        $(this).find('.show-delete').fadeOut(400);


      });


    

    
   }); 