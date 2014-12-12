(function ($) {
    $.fn.jnotifyInizialize = function (options) {
        var element = this;
        var defaults = {
            oneAtTime: false,
            appendType: 'prepend'
        };
        var options = $.extend({}, defaults, options);
        this.addClass('notify-wrapper');
        if (options.oneAtTime) this.addClass('notify-wrapper-oneattime');
        if (options.appendType == 'prepend' && options.oneAtTime == false) this.addClass('notify-wrapper-prepend');
        return this;
    };
    $.fn.jnotifyAddMessage = function (options) {

        var notifyWrapper = this;

        if (notifyWrapper.hasClass('notify-wrapper')) {

            var defaults = {
                text: '',
                type: '',
                permanent: false,
                disappearTime: 2000
            };

            var options = $.extend({}, defaults, options);
            var styleClass;

            switch (options.type) {
                case 'info':
                    styleImg = '<span class="glyphicon glyphicon-info-sign"></span>';
					styleClass = 'alert-info';
                    break;
                case 'success':
					styleImg = '<span class="glyphicon glyphicon-ok-sign"></span>';
                    styleClass = 'alert-success';
                    break;
                case 'warning':
					styleImg = '<span class="glyphicon glyphicon-exclamation-sign"></span>';
                    styleClass = 'alert-warning';
                    break;
                case 'error':
					styleImg = '<span class="glyphicon glyphicon-remove-sign"></span>';
                    styleClass = 'alert-danger';
                    break;
                default:
					styleImg = '<span class="glyphicon glyphicon-ok-sign"></span>';
                    styleClass = 'alert-success';
                    break;
            }

            if (notifyWrapper.hasClass('notify-wrapper-oneattime')) {
                this.children().remove();
            }

            var notifyItemWrapper = $('<div class="jnotify-item-wrapper"></div>');
            var notifyItem = $('<div class="alert">' + styleImg + '&nbsp;&nbsp;</div>').addClass(styleClass);

            if (notifyWrapper.hasClass('notify-wrapper-prepend')) {
                notifyItem.prependTo(notifyWrapper);
			} else {
				notifyItem.appendTo(notifyWrapper);
			}

            notifyItem.wrap(notifyItemWrapper);
            $('<span></span>').html(options.text).appendTo(notifyItem);
            $('<button type="button" class="close">&times;</button>').prependTo(notifyItem).click(function () { remove(notifyItem) });

            if (!options.permanent) {
                setTimeout(function () { remove(notifyItem); }, options.disappearTime);
            }
        }

        function remove(obj) {
            obj.animate({
				opacity: '0',
				marginLeft: '100px',
				marginRight: '-100px'
			}, 600, function () {
                obj.parent().animate({ height: '0px' }, 300, function () {
                    obj.parent().remove();
                });
            });
        }
    };
})($);
