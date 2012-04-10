function aPollEnableNewForm()
{
    var newForm = $('.a-poll-admin-new-form');
    newForm.submit(function() {
        var form = $(this);
        $.post(form.attr('action'), $(this).serialize(), function(data) {
            $(document).append(data); 
        });
        return false;
    });
}



