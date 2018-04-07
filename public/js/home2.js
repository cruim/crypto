

var PieMenuController = (function() {
    
    var $boundEl,
        $allSlices,
        activeSliceCount = 0;
    
    function bind($element) {
        $boundEl = $element;
        $allSlices = $boundEl.find('.pie-slice');
        $allSlices.on('click', onSliceClick);
        $boundEl.on('click', '.close-slice', closeSlice);
    }
    
    function onSliceClick(e) {
        $allSlices.removeClass('active');
        
        var $slice = $(this);
        if ($slice.hasClass('active')) return;
        $slice.addClass('active');
        //activeSliceCount += 1;
        //$slice.css({ 'z-index': activeSliceCount * 2 });
        
    }
    
    function closeSlice(e) {
        var $slice = $(this).parent();
        $slice.removeClass('active');
        //activeSliceCount -= 1;
    }
    
    return {
        bind: bind
    }
}());

$(document).ready(function() {
    var $pieMenu = $('.pie-ui.interactive');
    PieMenuController.bind($pieMenu);
});

$(document).on("click", "#user_home", function(e) {
    window.location.replace("/profile");
});

$(document).on("click", "#scheduller_home", function(e) {
    window.location.replace("/scheduller");
});

$(document).on("click", "#target_home", function(e) {
    window.location.replace("/target");
});

$(document).on("click", "#faq_home", function(e) {
    window.location.replace("/faq");
});