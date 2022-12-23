
(function () {
    'use strict';


    var $mailForm = $("#email-form");

    var $saveMail = $mailForm.find("input[type=submit]");

    function waitForElm(selector) {
        return new Promise(resolve => {
            if (document.querySelector(selector)) {
                return resolve(document.querySelector(selector));
            }

            const observer = new MutationObserver(mutations => {
                if (document.querySelector(selector)) {
                    resolve(document.querySelector(selector));
                    observer.disconnect();
                }
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });
    }
       
    waitForElm('input[name="url"]').then(element => {

        $saveMail.on("click", function(e) {
            e.preventDefault();
            if($mailForm.valid()){
                $.ajax({
                    url: $mailForm.attr("action"),
                    type: $mailForm.attr("method"),
                    data: $mailForm.serialize(),
                    success: function (data) {
                        $mailForm.hide();
                        $('.w-form-done').show();
                        $('.w-form-fail').hide();
                    },
                    failure: function (response) {
                        $('.w-form-fail').show();
                    }
                });
            }else{
                $('.w-form-fail').show();
            }

        });
    })

}).apply(this, [jQuery]);
