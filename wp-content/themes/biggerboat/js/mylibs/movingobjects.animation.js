/*!
 * Moving Objects - Animations
 * Moves an element from a certain position to another, uses css3 where capable
 *
 * @author Patrick Brouwer <patrick@inlet.nl>
 */
(function($) {

    /**
     * Init the animation layer
     * @return container element
     */
    $.fn.initAnimationLayer = function() {
        
        $(this).css({
//            background: 'red',
//            opacity: 0.5,
            position: 'absolute',
            top: '0px',
            left: '0px',
            width: '100%',
            height: $('body').height() + 'px',
            'z-index': 1,
            overflow: 'hidden'
        });

        // local refs
        var container = $(this);
        var stockId = 0;

        return {

            /**
             * Create a living loop with animations based on given list
             *
             * @param list
             *      Array of objects:
             *      {
             *          src: path.to.img.png,
             *          direction: RL or LR
             *      }
             *
             * @param offsetY
             *      Starting Y of animation container
             *
             * @param offsetHeight
             *      Total animation container height
             *
             * @param interval
             *      Loop of recurring object picked random from list
             */
            createStock: function( list, offsetY, offsetHeight, interval, speedMin, speedMax, maxItems ) {

                stockId++;
                var myStockId = stockId;

                container.append('<div id="stock' + myStockId + '"></div>');
                var stock = container.find('#stock' + myStockId);

                /**
                 * ANIMATION LOOP. CONTINIOUSLY!
                 */
                var animationLoop = function() {
                    var itemData = list[ Math.floor(Math.random()*list.length) ];
                    if (stock.find('img').length < maxItems) {
                        stock.append('<img src="' + itemData.src + '">');
                        var item = stock.find('img:last');
                        item.css({
                            position: 'absolute',
                            top: offsetY + Math.random()*offsetHeight,
                            left: itemData.direction == 'LR' ? -200 : $('body').width() + 200
                        }).animate({left: itemData.direction == 'LR' ? $('body').width() + 200 : -200 }, speedMin + Math.random()*(speedMax - speedMin), 'linear', function(){
                            item.remove();
                        });
                    }
                    setTimeout(animationLoop, interval);
                };
                animationLoop();
            }
        };
    };


})(jQuery);





