/**
 * require is used for on demand loading of JavaScript
 *
 * require r1 // 2008.02.05 // jQuery 1.2.2
 *
 * // basic usage (just like .accordion)
 * $.require("comp1.js");
 *
 * @param  jsFiles string array or string holding the js file names to load
 * @param  params object holding parameter like browserType, callback, cache
 * @return The jQuery object
 * @author Manish Shanker
 */
// Require
(function ($) {
    $.require = function (jsFiles, params) {

        var params = params || {};
        var bType = params.browserType === false ? false : true;

        if (!bType) {
            return $;
        }

        var cBack = params.callBack || function () {
        };
        var eCache = params.cache === false ? false : true;

        if (!$.require.loadedLib) $.require.loadedLib = {};

        if (!$.scriptPath) {
            var path = $('script').attr('src');
            $.scriptPath = path.replace(/\w+\.js$/, '');
        }
        if (typeof jsFiles === "string") {
            jsFiles = new Array(jsFiles);
        }
        for (var n = 0; n < jsFiles.length; n++) {
            if (!$.require.loadedLib[jsFiles[n]]) {
                $.ajax({
                    type:"GET",
                    url:$.scriptPath + jsFiles[n],
                    success:cBack,
                    dataType:"script",
                    cache:eCache,
                    async:false
                });
                $.require.loadedLib[jsFiles[n]] = true;
            }
        }
        return $;
    };
})(jQuery);

$().ready(function () {
    $.scriptPath = '/assets/js/';
    $('.back').click(function () {
        history.back();
        return false;
    });

    $('.not-implements').click(function () {
        alert('功能还未实现');
        return false;
    });

    $('.delete').click(function () {
        if (!confirm("确认要删除？")) return false;
    });

    $('.ac').live('focus', function () {
        var obj = this;
        $(obj).autocomplete({
            serviceUrl:'/admin/api/autocomplete/' + $(obj).attr('ac-type'),
            minChars:1,
            maxHeight:400,
            width:300,
            zIndex:9999,
            deferRequestBy:0,
            params:{format:'json'},
            noCache:false,
            onSelect:function (value, data) {
                $($(obj).attr('ac-value')).val(value);
                $($(obj).attr('ac-data')).val(data);
            }
        });
    });

    if (validate && $('form.validate')) {
        $.require('jquery.validate.js');
        $.require('jquery.validate.add-methods.js');
        $.require('jquery.validate.messages_cn.js');
        $.validator.setDefaults({
            errorPlacement:function (error, element) {
                element.parent().parent().addClass('error');
                if (element.next('.help-inline')) {
                    element.next('.help-inline').replaceWith(error);
                    error.addClass('help-inline');
                }
                else {
                    error.insertAfter(element);
                }
            },
            errorElement:'span',
            success:function (error) {
                console.log(error);
                error.parent().parent().removeClass('error').addClass('success');
                error.remove();
            }
        });
        $('form.validate').validate(validate);
    }
});