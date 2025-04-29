import $ from "jquery";

$("#shorten-form").on("submit", function (e) {
    e.preventDefault();
    const $btn = $(this).find("button[type=submit]").prop("disabled", true);

    $("#originalUrl").removeClass("is-invalid");
    $("#shorten-form .invalid-feedback").remove();

    $.ajax({
        url: $(this).attr("action"),
        method: "POST",
        data: {
            original_url: $("#originalUrl").val(),
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
    })
        .done((data) => {
            $("#shortenedResult").removeClass("d-none");
            $("#shortUrl").attr("href", data.short_url).text(data.short_url);
        })
        .fail((err) => {
            const msg =
                err.responseJSON?.errors?.original_url?.[0] ||
                err.responseJSON?.message ||
                "Error";
            $("#originalUrl")
                .addClass("is-invalid")
                .after(`<div class="invalid-feedback">${msg}</div>`);
        })
        .always(() => $btn.prop("disabled", false));
});

$(document).on("click", "#copyBtn", function () {
    const url = $("#shortUrl").text();
    if (!url) return;

    navigator.clipboard
        .writeText(url)
        .then(() => {
            alert("Скопійовано в буфер обміну");
        })
        .catch(() => {
            alert("Не вдалося скопіювати");
        });
});
