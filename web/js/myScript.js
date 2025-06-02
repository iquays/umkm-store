/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('ready pjax:success', function () {
    var current = '';
    var zoomed = 0;
    $('.viewSlider').bxSlider({
        autostart: false,
        startSlide: 0,
        controls: false,
        pagerCustom: '#viewPager',


        onSlideAfter: function (currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
            current = $('.viewSlider li.active img').attr('class');
            current = '.' + current;
            //  alert(current);

            //       $(current).elevateZoom({
            //         zoomEnabled: false
            //   });
            $('.viewSlider li').removeClass('active');


            $('.viewSlider li').eq(currentSlideHtmlObject + 1).addClass('active');
            current = $('.viewSlider li.active img').attr('class');
            current = '.' + current;
            //  alert(current);

            // $(current).elevateZoom({
            //     zoomEnabled: false,
            //     responsive: true, cursor: 'crosshair',
            //     zoomWindowHeight: 500, zoomWindowWidth: 500, zoomWindowOffetx: 5, borderSize: 1, borderColour: 'red',
            //     scrollZoom: true,
            //     zoomWindowFadeIn: 500, zoomWindowFadeOut: 500,
            //     easing: true
            // });

        },

        onSliderLoad: function () {
//            current = '.zoom0';

            $('.viewSlider>li:not(.bx-clone)').eq(0).addClass('active')
            current = $('.viewSlider li.active img').attr('class');
            current = '.' + current;
            //alert(current);

            //    $(current).on('click', function(event) {
            // $(current).elevateZoom({
            //     zoomEnabled: false,
            //     responsive: true, cursor: 'crosshair',
            //     zoomWindowHeight: 500, zoomWindowWidth: 500, zoomWindowOffetx: 5, borderSize: 1, borderColour: 'red',
            //     scrollZoom: true,
            //     zoomWindowFadeIn: 500, zoomWindowFadeOut: 500,
            //     easing: true
            // });
            //           });
        }
    });


    //$('.rupiah').priceFormat({
    //    prefix: 'Rp. ',
    //    centsSeparator: ',',
    //    thousandsSeparator: '.'
    //});

// Load Modal
//     $('#modalLink').click(function () {
//         $('#modal').modal('show')
//             .find('#modalContent')
//             .load($('#modalLink').attr('value'));
//     });

// Load Sent Message Modal
//     $('#sendMessageLink').click(function () {
//         $('#sendMessageModal').modal('show')
//             .find('#modalContent')
//             .load($('#sendMessageLink').attr('value'));
//     });

    $('.rupiah').priceFormat({
        prefix: 'Rp. ',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });


});