import '../scss/milo.scss';

// Vendor
import 'bootstrap';
import '@fortawesome/fontawesome-free/js/all'
import timeago from 'timeago.js';
import MediumEditor from 'medium-editor';

// Navbar behaviour
$(window).scroll(function() {
  onScroll();
});

function onScroll(){
  if( $(this).scrollTop() > 0 ) {
   $(".navbar").addClass("fixed-top navbar-dark bg-black");
   $(".navbar").removeClass("absolute-top navbar-light bg-white");
 } else {
   $(".navbar").addClass("absolute-top navbar-light bg-white");
   $(".navbar").removeClass("fixed-top navbar-dark bg-black");
 }
}

onScroll();

// Search input behaviour
$('.js-search')
  .on('focus', function(){
    $(this).data('placeholder', $(this).attr('placeholder')); // Store for blur
    $(this).attr('placeholder', $(this).attr('title'));
  })
  .on('blur', function(){
    $(this).attr('placeholder', $(this).data('placeholder'));
  });

// Timeago
timeago().render(document.querySelectorAll('.timeago'));

// Medium editor
new MediumEditor('.js-editable')
