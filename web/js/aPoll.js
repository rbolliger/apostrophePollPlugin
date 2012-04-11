function aPollEnableNewForm()
{
    var newForm = $('#a-poll-admin-new-form');
    newForm.submit(function() {
        var form = $(this);
        var container = form.closest('#a-poll-admin-new-form-container')
        $.post(form.attr('action'), $(this).serialize(), function(data) {
            //$(document).append(data); 
            container.html(data);
        });
        return false;
    });
}



