function aPollSubmitForm(options) 
{
    var newForm = $(options['form']);
    newForm.submit(function() {
        var container = $(options['container'])
        $.post(options['url'], $(this).serialize(), function(data) { 
            container.html(data);
        },
        'html'
        );
        return false;
    });
}


function aPollSubmitPollForm(options)
{
    // to remove iframes created by recaptcha
    var x = $('iframe').get(-1);
    if ( x ) {
        $(x).remove();
    }
        
    aPollSubmitForm(options);
}

function aPollPreviewPoll(options)
{
    $(options['button']).click(function () {
        
        $.post(options['url'],options['id'], function(data) {
            $(options['container']).html(data);
        },
        'html'
        ); 
    });
    
    
    return false;
}

