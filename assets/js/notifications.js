//function progressMessage() {
//    Messenger.options = {
//        extraClasses: 'messenger-fixed messenger-on-top',
//        theme: 'flat'
//    }
//    var i = 0;
//    Messenger().run({
//        errorMessage: 'Error destroying alien planet',
//        successMessage: 'Alien planet destroyed!',
//        action: function (opts) {
//            if (++i < 3) {
//                return opts.error({
//                    status: 500,
//                    readyState: 0,
//                    responseText: 0
//                });
//            } else {
//                return opts.success();
//            }
//        }
//    });
//}
function showErrorMessage(msg) {
//    $.notifyClose('bottom-right');
    showNotification('bg-red', msg, 'bottom', 'right', "animated bounceIn", "animated bounceOut");
//    $(function () {
//        Messenger().post({
//            message: msg,
//            type: 'error',
//            showCloseButton: true
//        });
//
//        var loc = ['bottom', 'right'];
//        var style = 'flat';
//
//        var $output = $('.controls output');
//        var $lsel = $('.location-selector');
//        var $tsel = $('.theme-selector');
//
//        var update = function () {
//            var classes = 'messenger-fixed';
//
//            for (var i = 0; i < loc.length; i++)
//                classes += ' messenger-on-' + loc[i];
//
//            $.globalMessenger({extraClasses: classes, theme: style});
//            Messenger.options = {extraClasses: classes, theme: style};
//
//            $output.text("Messenger.options = {\n    extraClasses: '" + classes + "',\n    theme: '" + style + "'\n}");
//        };
//
//        update();
//
//
//
//    });
}
function showSuccess(msg) {
    showNotification('bg-green', msg, 'bottom', 'center', "animated bounceIn", "animated bounceOut");
//    $(function () {
//        Messenger().post({
//            message: msg,
//            showCloseButton: true
//        });
//
//        var loc = ['bottom', 'right'];
//        var style = 'flat';
//
//        var $output = $('.controls output');
//        var $lsel = $('.location-selector');
//        var $tsel = $('.theme-selector');
//
//        var update = function () {
//            var classes = 'messenger-fixed';
//
//            for (var i = 0; i < loc.length; i++)
//                classes += ' messenger-on-' + loc[i];
//
//            $.globalMessenger({extraClasses: classes, theme: style});
//            Messenger.options = {extraClasses: classes, theme: style};
//
//            $output.text("Messenger.options = {\n    extraClasses: '" + classes + "',\n    theme: '" + style + "'\n}");
//        };
//
//        update();
//
//
//
//    });
}