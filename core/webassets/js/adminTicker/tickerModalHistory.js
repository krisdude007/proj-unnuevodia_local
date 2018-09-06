var historyModalHandler = function(id) {
    $.ajax({
        url: '/adminTicker/tickerModalHistory',
        type: 'POST',
        data: ({
            'ticker_id': id,
            'CSRF_TOKEN': getCsrfToken()
        }),
        success: function(data) {
            modal.set('Ticker History', data);
            modal.show();
        }
    });
};
var cModal = function() {
    this.cover = $('<div id="cover" onclick="modal.close();"></div>');
    this.modal = $('<div id="modal"></div>');
    this.close = function() {
        this.modal.remove();
        this.cover.remove();
    };
    this.set = function(title, content) {
        $title = $('<div id="modalTitle"></div>');
        $x = $('<div id="modalX" onclick="modal.close();">X</div>');
        $content = $('<div id="modalContents"></div>');
        this.modal.hide();
        this.modal.empty();
        this.modal.append($x, $title, $content);
        // Open the modal
        //return function (content) {
        $title.html(title);
        $content.html(content);
        //};
    };
    this.hide = function() {
        this.modal.hide();
    };
    this.show = function() {
        $('body').append(this.cover);
        $('body').append(this.modal);
        this.modal.css({
            top: ($(window).height() - this.modal.outerHeight()) / 2,
            left: ($(window).width() - this.modal.outerWidth()) / 2
        });
        this.modal.show();
    };
};
var modal = new cModal();