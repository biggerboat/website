$('#crew .left li').first().addClass('first')
$('#crew .right li').first().addClass('first');

$('.blogtop').first().addClass('first');
$('.blogfooter').last().addClass('last');

// requestAnim shim layer by Paul Irish
window.requestAnimFrame = (function() {
    return  window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        window.oRequestAnimationFrame ||
        window.msRequestAnimationFrame ||
        function(/* function */ callback, /* DOMElement */ element) {
            window.setTimeout(callback, 1000 / 60);
        };
})();

var canvas, context;


$.getJSON('http://api.twitter.com/1/statuses/user_timeline/abiggerboat.json?callback=?&include_entities=true',
    function(data) {
        $('.tweet .text').html(linkify_entities(data[0]));
    });

$(document).ready(function() {
    setTimeout(initApplication, 500);
});

function initApplication() {
    init();
    animate();
}

var counterWaveOne = 0;
var counterWaveTwo = 0;
var counterSin = 0;
var counterSinWaveTwo = 0;
var boatSin = 0;
var SPRITE_WIDTH = 96;

function openMailModal() {
    $('#modal-from-dom').modal('show');
}

function sendMail() {
    if ($("#contactForm").valid()) {

        $.post(THEME_URL + "mailer.php", {
            "nounce" : $('#nounce').attr('value'),
            "subject": $('#subject').attr('value'),
            "details": $('#details').attr('value'),
            "name": $('#name').attr('value'),
            "email": $('#email').attr('value'),
            "phone": $('#phone').attr('value')
        });

        $('#modal-from-dom').modal('hide');
    }

    $("label.error").remove();
}


function init() {
    $('#submit_mail').attr('href', "javascript:sendMail()");
    $('#mail_button').attr('href', "javascript:openMailModal()");

    if ($('html').hasClass('js')) {
        var top = $('#logo').position().top - 20;
        $.scrollTo(top);
        $('body').css('opacity', '1');
    }

    var left = $('#crew .left ul').outerHeight(true);
    var right = $('#crew .right  ul').outerHeight(true);

    if (left > right) {
        var diffence = left - right - 100 + 'px';
        $('#crew .right ul').append('<li class="filler" style="height: ' + diffence + ';"></li>');
    } else {
        var diffence = right - left + 100 + 'px';
        $('#crew .left ul').append('<li class="filler" style="height: ' + diffence + ';"></li>');
    }
}

function animate() {
    draw();
    requestAnimFrame(animate);
}

function draw() {
    counterWaveOne = counterWaveOne + 0.3;
    counterWaveTwo = counterWaveTwo + Math.random();
    counterSin = counterSin + 0.05;
    counterSinWaveTwo = counterSinWaveTwo + 0.04;
    boatSin = boatSin + 0.2;

    $("#firstwave").css('background-position', counterWaveOne % SPRITE_WIDTH + 'px ' + Math.sin(counterSin) * 2 + 'px');
    $("#secondwave").css('background-position', counterWaveTwo % SPRITE_WIDTH + 'px ' + Math.sin(counterSinWaveTwo) * 2 + 'px');
    $("#boat").css('background-position', '0px ' + (Math.sin(counterSinWaveTwo) * 4) + 'px');
}

/**
 * Ease to top..
 */
$(document).ready(function() {
    $('.bigbutton.gotoblog').click(function(e) {
        e.preventDefault();
        $.scrollTo('#main', 500, {easing: 'easeInOutExpo'});
    });
});

/**
 * Flora and fauna animations
 */
$(window).load(function() {

    var animContainer = $('#animationlayer').initAnimationLayer();

    /**
     * Adding clouds
     */
    var clouds = [
        {src:templatepaths.img + '/clouds/cloud1.png', direction:'LR'},
        {src:templatepaths.img + '/clouds/cloud2.png', direction:'LR'},
        {src:templatepaths.img + '/clouds/cloud2.png', direction:'RL'},
        {src:templatepaths.img + '/clouds/cloud3.png', direction:'LR'},
        {src:templatepaths.img + '/clouds/cloud3.png', direction:'RL'}
    ];
    animContainer.createStock(clouds, 0, $('#firstwave').offset().top - 100, 3000, 20000, 30000, 10);

    /**
     * Adding birds
     */
    var birds = [
        {src:templatepaths.img + '/birds/bird1.png', direction:'LR'},
        {src:templatepaths.img + '/birds/bird2.png', direction:'RL'}
    ];
    animContainer.createStock(birds, 0, $('#firstwave').offset().top - 100, 2000, 10000, 20000, 5);

    /**
     * Adding fishes
     */
    var fishes = [
        {src:templatepaths.img + '/fishes/fish1_left.png', direction:'RL'},
        {src:templatepaths.img + '/fishes/fish1_right.png', direction:'LR'},
        {src:templatepaths.img + '/fishes/fish2_left.png', direction:'RL'},
        {src:templatepaths.img + '/fishes/fish2_right.png', direction:'LR'},
        {src:templatepaths.img + '/fishes/fish3_left.png', direction:'RL'},
        {src:templatepaths.img + '/fishes/fish3_right.png', direction:'LR'},
        {src:templatepaths.img + '/fishes/shark_left.png', direction:'RL'},
        {src:templatepaths.img + '/fishes/shark_right.png', direction:'LR'},
    ];
    animContainer.createStock(fishes, $('#firstwave').offset().top + 100, $('body').height() - $('#firstwave').offset().top + 100, 2000, 12000, 25000, 10);

});


