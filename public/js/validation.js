$.validator.setDefaults({
    ignore: ".ignore",
    errorClass: "error-valid",
    focusInvalid: true,
    errorElement: "div",
    errorPlacement: function(error, element) {
        if (element.closest(".image-group").hasClass("image-group")) {
            error.insertAfter(element.closest(".image-group").find(".image-button"));
        } else if (element.closest(".file-group").hasClass("file-group")) {
            error.insertAfter(element.closest(".file-group").find(".file-preview"));
        } else if (
            element.closest(".textarea-editor").hasClass("textarea-editor")
        ) {
            error.appendTo(".textarea-error");
        } else if (
            element.closest(".form-check-input").hasClass("form-check-input")
        ) {
            error.appendTo("#type-err");
        } else if (element.closest(".form-percent").hasClass("form-percent")) {
            error.appendTo(element.closest(".form-percent"));
        } else {
            error.insertAfter(element);
        }
    },
    highlight: function(element, errorClass, validClass) {
        $(element).addClass("is-invalid");
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass("is-invalid");
    },
    invalidHandler: function() {},
    submitHandler: function(form) {
        $(form).find("button[type=submit]").prop("disabled", true);
        return true;
    },
});

function validation(formID, rules, messages) {
    $(formID).validate({
        rules: rules,
        messages: messages,
    });
};