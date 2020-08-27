window.send = function (language, key, lang) {
    document.getElementsByName(key).forEach(element => {
        element.classList.add('scale-out');
    });
    $.ajax({
        type: "POST",
        url: config.url,
        data: {
            language: language,
            key: key,
            value: document.getElementById(lang+'.'+key).value
        },
        dataType: 'json',
        success: function(){
            document.getElementsByName(key).forEach(element => {
                element.classList.add('hide');
            });
            M.toast({html: config.success_msg});
        },
        error: function(){
            alert(config.error_msg);
        }
    });
};