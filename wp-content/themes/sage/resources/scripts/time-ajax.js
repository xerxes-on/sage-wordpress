jQuery(document).ready(function ($) {
  $('#time-locale-form').on('submit', function (e) {
    e.preventDefault();
    if (typeof timeAjax === 'undefined') {
      console.error('timeAjax object is not defined.');
      return;
    }
    let locale = $('#locale-select').val();
    $.ajax({
      url: timeAjax.ajaxurl,
      type: 'POST',
      data: {
        action: 'get_time_in_locale',
        locale: locale,
        nonce: timeAjax.nonce
      },
      success: function (response) {
        if (response.success) {
          $('#time-result').val(response.data);
        } else {
          $('#time-result').val('Error: ' + response.data);
        }
      },
      error: function (xhr, status, error) {
        console.error('AJAX Error:', status, error);
        console.log('Response Text:', xhr.responseText);
        $('#time-result').val('Error occurred while fetching time. Check console for details.');
      }
    });
  });
});
