window.send = function (language, key, value) {
    row_name = key;
    document.getElementsByName(row_name).forEach(element => {
        element.classList.add('scale-out');
    });
    $.ajax({
        type: "POST",
        url: config.url,
        data: {
            language: language,
            key: key,
            value: value
        },
        dataType: 'json',
        success: function(){
            document.getElementsByName(row_name).forEach(element => {
                element.classList.add('hide');
            });
            M.toast({html: config.success_msg});
        },
        error: function(){
            alert(config.error_msg);
        }
    });
};