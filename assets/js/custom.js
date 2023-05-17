// JavaScript Document

//  $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
//        e.preventDefault();
//        $(this).siblings('a.active').removeClass("active");
//        $(this).addClass("active");
//        var index = $(this).index();
//       // $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
//        // $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
//  });

// $(document).ready(function () {
//     var navListItems = $('div.setup-panel div a'),
//             allWells = $('.setup-content'),
//             allNextBtn = $('.nextBtn');
//     allWells.hide();

//     navListItems.click(function (e) {
//         e.preventDefault();
//         var $target = $($(this).attr('href')),
//                 $item = $(this);

//         if (!$item.hasClass('disabled')) {
//             navListItems.removeClass('btn-primary').addClass('btn-default');
//             $item.addClass('btn-primary');
//             allWells.hide();
//             $target.show();
//             $target.find('input:eq(0)').focus();
//         }

//     });

//     allNextBtn.click(function () {
//         var curStep = $(this).closest(".setup-content"),
//                 curStepBtn = curStep.attr("id"),
//                 nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
//                 curInputs = curStep.find("input[type='text'],input[type='url']"),
//                 isValid = true;

//         $(".form-group").removeClass("has-error");
//         for (var i = 0; i < curInputs.length; i++) {
//             if (!curInputs[i].validity.valid) {
//                 isValid = false;
//                 $(curInputs[i]).closest(".form-group").addClass("has-error");
//             }
//         }

//         if (isValid)
//             nextStepWizard.removeAttr('disabled').trigger('click');
//     });

//     $('div.setup-panel div a.btn-primary').trigger('click');

// });

/*side-bar*/

$(document).ready(function () {
    $("#bord-university").click(function () {
        $("#add-bord-uni").fadeToggle();
    });

    $("#medium").click(function () {
        $("#add-medium-box").fadeToggle();
    });
    var menuRight = document.getElementById('cbp-spmenu-s2'),
        body = document.body;

    //    showRight.onclick = function ()
    //    {
    //        classie.toggle(this, 'active');
    //        classie.toggle(menuRight, 'cbp-spmenu-open');
    //        $(".content").toggleClass("active");
    //        //disableOther( 'close' );
    //    };
    //    $("#close").click(function (e) {
    //        e.preventDefault();
    //        $("#showRight").trigger("click");
    //    });

    function disableOther(button) {

        if (button !== 'close') {
            classie.toggle(showRight, 'disabled');
        }

    }

});

$(document).ready(function () {
    $(".navbar-header .bars").click(function () {
        $(".menu-container .menu ul.pullDown").fadeToggle();
    });
});

