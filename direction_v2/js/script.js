
$(window).on("load", function () {
  $(".loader").fadeOut();

});

// $(window).scroll(function () {
//   var $height = $(window).scrollTop();
//   if ($height > 1) {
//     $('header').addClass('active');
// 	$('.nav_profile').addClass('custom_Top');

//   } else {
//     $('header').removeClass('active');
// 	$('.nav_profile').removeClass('custom_Top');

//   }
// });

$(window).resize(function(){

  if ($(window).width() <= 767) {  
    $(".menu").hide();
  }    

});
$(document).ready(function () {

  //nav
  var touch = $('#resp-menu');
  var menu = $('.menu');

  $(touch).on('click', function (e) {
      e.preventDefault();
      menu.slideToggle();
  });

  $(window).resize(function () {
      var w = $(window).width();
      if (w > 767 && menu.is(':hidden')) {
          menu.removeAttr('style');
      }
  });
// nav click
$(".MainNav>Courses").click(function()  {
    $(".MainNav>Courses>ul").css("visibility", "visible", "opacity", "1");
});
$(".owl-prev").click(function() {
  alert();
});
  // news
  $(function () {
    $('.js-conveyor-example').jConveyorTicker({ reverse_elm: false });
  });
  //   news
    

  // slider

    $(document).ready(function () {
      $('#Takebox').owlCarousel({
        loop: true,
        autoplay:true,
        margin: 10,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1,
            nav: true
          },
          600: {
            items: 2,
            nav: false
          },
          1000: {
            items: 2,
            nav: true,
            loop: false,
            margin: 20
          },
          1199: {
            items: 3,
            nav: true,
            loop: false,
            margin: 20
          }
          
        }
      })
    })
    
    $(document).ready(function () {
      $('.General').owlCarousel({
        loop: true,
        margin: 10,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1,
            nav: true
          },
          600: {
            items: 2,
            nav: false
          },
          1000: {
            items: 2,
            nav: true,
            loop: false,
            margin: 20
          },
          
          1199: {
            items: 2,
            nav: true,
            loop: false,
            margin: 20
          },
          1440: {
            items: 3,
            nav: true,
            loop: false,
            margin: 10
          },
          1920: {
            items: 3,
            nav: true,
            loop: false,
            margin: 20
          }
        }
      })
    })
    

  // slide panel fixed box
  $("#msg_click").click(function(){
    $(".box").animate({
      width: "toggle"
    });
  });
  // icon toggle
  $("#msg_click").click(function () {
    $("#info_msg").toggle();
    $("#info_close").toggle();
    $(this).find(".fixed_msg").toggleClass("fixed_msg_rotate");
    $(".msg_wrapper").toggle();
});
  // verticalTicker
  $(function () {
    $(".demo1").bootstrapNews({
        newsPerPage: 3,
        autoplay: true,
        pauseOnHover: true,
        direction: 'up',
        newsTickerInterval: 4000,
        onToDo: function () {
            //console.log(this);
        }
    });
  
  });

// verticalTicker



//Multilevel Dropdown Hover
(function($){
	$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
	  if (!$(this).next().hasClass('show')) {
		$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
	  }
	  var $subMenu = $(this).next(".dropdown-menu");
	  $subMenu.toggleClass('show');

	  $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
		$('.dropdown-submenu .show').removeClass("show");
	  });

	  return false;
	});
});
   
//$('.slick-carousel').slick({
//  infinite: false,
//  vertical: true,
//  verticalSwiping: true,
//  slidesToShow: 3,
//  slidesToScroll: 3,
//  prevArrow: $('.top-arrow'),
//  nextArrow: $('.bottom-arrow')
//});

	blueimp.Gallery(
//		document.getElementById('links').getElementsByTagName('a'),
		document.getElementById('links'),
		{
			container: '#blueimp-gallery',
			carousel: true,
			onslide: function (index, slide) {
                var unique_id = this.list[index].getAttribute('data-unique-id');
                console.log(unique_id);
			}
		}
  );
  
  
});


