function aPollEnableNewForm()
{
    var newForm = $('#a-poll-admin-new-form');
    newForm.submit(function() {
        var form = $(this);
        var container = form.closest('#a-poll-admin-new-form-container')
        $.post(form.attr('action'), $(this).serialize(), function(data) { 
            container.html(data);
        });
        return false;
    });
}


function aPollSubmitPollForm(options)
{
    var newForm = $(options['form']);
    newForm.submit(function() {
        //var form = $(this);
        var container = $(options['container'])
        $.post(options['url'], $(this).serialize(), function(data) { 
            container.html(data);
        },
        'html'
        );
        return false;
    });
}



