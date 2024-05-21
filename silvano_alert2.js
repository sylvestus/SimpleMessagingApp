/**
 *@NApiVersion 2.0
 *@NScriptType ClientScript
 */

define(["N/ui/dialog"], function (dialog) {
    function welcome() {
        var options = {
            title: "Welcome!",
            message: "Welcome to Page",
        };

        try {
            dialog.alert(options);

            log.debug({
                title: "Success",
                details: "Alert displayed successfully",
            });
        } catch (e) {
            log.error({
                title: e.name,
                details: e.message,
            });
        }
    }

    return {
        pageInit: welcome,
    };
});
