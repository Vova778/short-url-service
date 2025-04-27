import $ from 'jquery';

$('#home-form').on('submit', function(e){
  e.preventDefault();
  let $btn = $(this).find('button').prop('disabled', true);
  $.post(route('home.shorten'), $(this).serialize())
    .done(data => {
      $('#home-result').html(
        `<div class="alert alert-success">
           <a href="/${data.short_code}">${data.short_code}</a>
         </div>`
      );
    })
    .fail(err => {
      $('#home-result').html(
        `<div class="alert alert-danger">${err.responseJSON.original_url?.[0] || err.responseJSON.message}</div>`
      );
    })
    .always(() => $btn.prop('disabled', false));
});
