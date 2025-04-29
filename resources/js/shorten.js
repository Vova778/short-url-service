// resources/js/shorten.js

$(function () {
    const form = $("#newLinkForm");

    form.on("submit", function (e) {
        e.preventDefault();

        form.find(".is-invalid").removeClass("is-invalid");
        form.find(".invalid-feedback").text("");

        const payload = {
            _token: form.find('input[name="_token"]').val(),
            original_url: form.find('[name="original_url"]').val(),
            custom_code: form.find('[name="custom_code"]').val() || null,
            password: form.find('[name="password"]').val() || null,
            expires_at: form.find('[name="expires_at"]').val() || null,
        };

        $.ajax({
            url: form.attr("action"),
            method: "POST",
            data: payload,
            success(resp) {
                window.location.href = "/links/" + resp.link_id;
            },
            error(xhr) {
                if (xhr.status === 422) {
                    const errors =
                        (xhr.responseJSON && xhr.responseJSON.errors) || {};
                    $.each(errors, function (field, messages) {
                        const input = form.find(`[name="${field}"]`);
                        input.addClass("is-invalid");
                        form.find(`#error-${field}`).text(messages[0]);
                    });
                } else {
                    const msg =
                        xhr.responseJSON?.message || "Something went wrong";
                    alert(msg);
                }
            },
        });
    });
});
