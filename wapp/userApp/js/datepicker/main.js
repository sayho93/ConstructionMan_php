window.createContainer = function () {
    var $container = $('<div class="calendarContainer">');

    $container.appendTo(document.body);

    return $container;
};

window.createInput = function (attrs) {
    var $input = $('<input type="text">');

    if (typeof attrs === 'object') {
        $input.attr(attrs);
    }

    window.createContainer().append($input);

    return $input;
};