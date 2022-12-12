
(function () {
    'use strict';


    var $mailForm = $("#email-form");

    var $saveMail = $mailForm.find("input[type=submit]");
       

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

}).apply(this, [jQuery]);
