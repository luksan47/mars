//TODO rewrite for materialize modal

function confirm(heading, question, cancelButtonTxt, okButtonTxt, callback) {
    // var confirmModal =
    //     $('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\n' +
    //         '    <div class="modal-dialog">\n' +
    //         '        <div class="modal-content">\n' +
    //         '            <div class="modal-header">\n' +
    //                         heading +
    //         '            </div>\n' +
    //         '            <div class="modal-body">\n' +
    //                         question +
    //         '            </div>\n' +
    //         '            <div class="modal-footer">\n' +
    //         '                <button type="button" class="btn btn-default" data-dismiss="modal">' + cancelButtonTxt + '</button>\n' +
    //         '                <button type="button" class="btn btn-danger" id="okButton">' + okButtonTxt + '</button>\n' +
    //         '            </div>\n' +
    //         '        </div>\n' +
    //         '    </div>\n' +
    //         '</div>');

    // confirmModal.find('#okButton').click(function(event) {
    //     callback();
    //     confirmModal.modal('hide');
    // });

    // confirmModal.modal('show');
};

function ajaxError(heading, generalMessage, okButton, error) {
    // var errorText = '';
    // try {
    //     errorText = JSON.stringify(error);
    // } catch (e) {}

    // var confirmModal =
    //     $('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\n' +
    //         '    <div class="modal-dialog">\n' +
    //         '        <div class="modal-content">\n' +
    //         '            <div class="modal-header">\n' +
    //         heading +
    //         '            </div>\n' +
    //         '            <div class="modal-body">\n' +
    //         generalMessage +
    //         '<br/><br/><br/><textarea rows="15" style="width: 100%">' + errorText + '</textarea>' +
    //         '            </div>\n' +
    //         '            <div class="modal-footer">\n' +
    //         '                <button type="button" class="btn btn-default" data-dismiss="modal">' + okButton + '</button>\n' +
    //         '            </div>\n' +
    //         '        </div>\n' +
    //         '    </div>\n' +
    //         '</div>');

    // confirmModal.modal('show');
};
