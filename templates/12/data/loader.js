/*global $, confirm, window, alert, SqueezeBox */

var artHelper = {};

$.noConflict()(function ($) {
    'use strict';

    var button = $('button.modal'),
        id = (1 === $('#jform_id-lbl').length) ? parseInt($.trim(
            $('#jform_id-lbl').parent().find('span').text()
        ), 10) : '';
    function log(msg, color) {
        SqueezeBox.close();
        $('#log').append($('<div></div>').text(msg).css('color', color));
    }

    function requestParams(action) {
        var data = { 'action' : action };
        if ('' !== id) {
            data.id = id;
        }
        return data;
    }

    /**
     * Sends the request to the content loader script and handles the result.
     *
     * @param  data
     * @param  callback
     */
    function request(data, callback) {
        $.ajax({
            url: artHelper.dataFolder + '/install.php',
            data : data,
            dataType : 'text',
            success : function (data) {
                if (data.match(/^result:/)) {
                    callback(data.substring('result:'.length));
                } else if (data.match(/^params:/)) {
                    callback(data.substring('params:'.length));
                } else if (data.match(/^error:/)) {
                    log(data.split(':').pop());
                } else {
                    log(data);
                }
            },
            error : function (xhr, textStatus, errorThrown) {
                log('Request failed: ' + xhr.status, 'red');
            }
        });
    }

    function check(callback) {
        request(requestParams('check'), function (data) {
            callback('1' === data);
        });
    }

    function run() {
        request(requestParams('run'), function () {
            request(requestParams('params'), function (data) {
                var parameters = data.split(';');
                $.each(parameters, function (index, value) {
                    var parts = value.split(':');
                    $('#' + parts[0]).val(parts[1]);
                });
                SqueezeBox.fromElement(artHelper.dataFolder + '/success.html', {
                    size: { x : 290, y : 100 },
                    onUpdate: function (container) {
                        $('#continue', container.firstChild.contentDocument).bind('click', function () {
                            SqueezeBox.close();
                        });
                    }
                });
            });
        });
    }

    button.bind('click', function (event) {
        event.preventDefault();
        // Clear log container
        $('#log').html('');

        check(function (installed) {
            var dialogWidth = 455,
                dialogHeight = installed ? 190 : 145;
            SqueezeBox.fromElement(artHelper.dataFolder + '/warning.html', {
                size : {x : dialogWidth, y : dialogHeight},
                iframePreload: true,
                handler : 'iframe',
                onOpen : function (container, showContent) {
                    var ifrDoc = container.firstChild.contentDocument;
                    $('#item2', ifrDoc).css('display', !installed ? 'none' : '');
                    $('#load', ifrDoc).off().bind('click', function () {
                        $(this).attr('disabled', 'disabled');
                        run();
                    });
                    $('#cancel', ifrDoc).bind('click', function () {
                        SqueezeBox.close();
                    });
                    container.setStyle('display', showContent ? '' : 'none');
                }
            });
            window.setTimeout(function () {
                SqueezeBox.fireEvent('onOpen', [SqueezeBox.content, true]);
            }, 1000);
        });
    });
});
