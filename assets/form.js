// Multi-step form logic and AJAX submission for Site Agent
jQuery(document).ready(function($){
  let currentStep = 1;
  const $form = $('#site-agent-form');
  const $steps = $form.find('.form-step');

  function showStep(step) {
    $steps.hide();
    $steps.filter('[data-step="'+step+'"]').show();
  }
  showStep(currentStep);

  $form.on('click', '.next', function(){
    if(currentStep < $steps.length) {
      currentStep++;
      showStep(currentStep);
    }
  });
  $form.on('click', '.prev', function(){
    if(currentStep > 1) {
      currentStep--;
      showStep(currentStep);
    }
  });

  $form.on('submit', function(e){
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('action', 'site_agent_save');
    formData.append('nonce', siteAgentAjax.nonce);
    $.ajax({
      url: siteAgentAjax.ajax_url,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response){
        $('#site-agent-status').html('<div class="updated">'+response.data+'</div>');
      },
      error: function(xhr){
        $('#site-agent-status').html('<div class="error">'+xhr.responseJSON.data+'</div>');
      }
    });
  });
});
