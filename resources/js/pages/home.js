import $ from "jquery";
import "bootstrap/js/src/alert";

const showAlert = (type, message) => {
    const alertHtml = `
    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`;
    $("#shortenAlert").html(alertHtml);
};

$("#shorten-form").on("submit", function (e) {
    e.preventDefault();
    const $form = $(this);
    const $btn = $form.find("button[type=submit]").prop("disabled", true);

    $("#originalUrl").removeClass("is-invalid");
    $form.find(".invalid-feedback").remove();
    $("#shortenAlert").empty();
    $("#shortenedResult").addClass("d-none");

    $.ajax({
        url: $form.attr("action"),
        method: "POST",
        data: {
            original_url: $("#originalUrl").val(),
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
    })
        .done((data) => {
            $("#shortenedResult").removeClass("d-none");
            $("#shortUrl").attr("href", data.short_url).text(data.short_url);
            showAlert("success", "Link has been successfully shortened!");
        })
        .fail((err) => {
            const msg =
                err.responseJSON?.errors?.original_url?.[0] ||
                err.responseJSON?.message ||
                "Something went wrong, please try again.";
            $("#originalUrl")
                .addClass("is-invalid")
                .after(`<div class="invalid-feedback">${msg}</div>`);
            showAlert("danger", msg);
        })
        .always(() => $btn.prop("disabled", false));
});

$(document).on("click", "#copyBtn", function () {
    const url = $("#shortUrl").text();
    if (!url) return;

    navigator.clipboard
        .writeText(url)
        .then(() => {
            showAlert("info", "Copied to clipboard");
        })
        .catch(() => {
            showAlert("warning", "Failed to copy to clipboard");
        });
});
