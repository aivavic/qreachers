if (!RedactorPlugins)
    var RedactorPlugins = {};

(function ($)
{
    RedactorPlugins.blocklist = function ()
    {
        return {
            init: function ()
            {
                this.blocklist.addLangs();
                var button = this.button.addAfter('backcolor', 'blocklist', this.lang.get('blocklist'));
                this.button.addCallback(button, this.blocklist.show);
            },
            addLangs: function () {
                this.opts.curLang['blocklist'] = 'blocklist';
                this.opts.curLang['blacklist_html_code'] = 'Type your list here';

            },
            show: function ()
            {
                //console.log(this.blocklist.getTemplate());
                this.modal.addTemplate('blocklist', this.blocklist.getTemplate());
                this.modal.load('blocklist', this.lang.get('blocklist'), 700);

                //buttons
                this.modal.createCancelButton();

                var button = this.modal.createActionButton(this.lang.get('insert'));
                button.on('click', this.blocklist.insert);

                //save
                this.selection.save();
                this.modal.show();

            },
            showEdit: function ($image)
            {
                var $link = $image.closest('a', this.$editor[0]);

                this.modal.load('imageEdit', this.lang.get('edit'), 705);

                this.modal.createCancelButton();
                this.image.buttonDelete = this.modal.createDeleteButton(this.lang.get('_delete'));
                this.image.buttonSave = this.modal.createActionButton(this.lang.get('save'));

                this.image.buttonDelete.on('click', $.proxy(function ()
                {
                    this.image.remove($image);

                }, this));

                this.image.buttonSave.on('click', $.proxy(function ()
                {
                    this.image.update($image);

                }, this));

                $('#redactor-image-title').val($image.attr('alt'));

                if (!this.opts.imageLink)
                    $('.redactor-image-link-option').hide();
                else
                {
                    var $redactorImageLink = $('#redactor-image-link');

                    $redactorImageLink.attr('href', $image.attr('src'));
                    if ($link.length !== 0)
                    {
                        $redactorImageLink.val($link.attr('href'));
                        if ($link.attr('target') == '_blank')
                            $('#redactor-image-link-blank').prop('checked', true);
                    }
                }

                if (!this.opts.imagePosition)
                    $('.redactor-image-position-option').hide();
                else
                {
                    var floatValue = ($image.css('display') == 'block' && $image.css('float') == 'none') ? 'center' : $image.css('float');
                    $('#redactor-image-align').val(floatValue);
                }

                this.modal.show();

            },
            setFloating: function ($image)
            {
                var floating = $('#redactor-image-align').val();

                var imageFloat = '';
                var imageDisplay = '';
                var imageMargin = '';

                switch (floating)
                {
                    case 'left':
                        imageFloat = 'left';
                        imageMargin = '0 ' + this.opts.imageFloatMargin + ' ' + this.opts.imageFloatMargin + ' 0';
                        break;
                    case 'right':
                        imageFloat = 'right';
                        imageMargin = '0 0 ' + this.opts.imageFloatMargin + ' ' + this.opts.imageFloatMargin;
                        break;
                    case 'center':
                        imageDisplay = 'block';
                        imageMargin = 'auto';
                        break;
                }

                $image.css({'float': imageFloat, display: imageDisplay, margin: imageMargin});
                $image.attr('rel', $image.attr('style'));
            },
            update: function ($image)
            {
                this.image.hideResize();
                this.buffer.set();

                var $link = $image.closest('a', this.$editor[0]);

                $image.attr('alt', $('#redactor-image-title').val());

                this.image.setFloating($image);

                // as link
                var link = $.trim($('#redactor-image-link').val());
                if (link !== '')
                {
                    // test url (add protocol)
                    var pattern = '((xn--)?[a-z0-9]+(-[a-z0-9]+)*\\.)+[a-z]{2,}';
                    var re = new RegExp('^(http|ftp|https)://' + pattern, 'i');
                    var re2 = new RegExp('^' + pattern, 'i');

                    if (link.search(re) == -1 && link.search(re2) === 0 && this.opts.linkProtocol)
                    {
                        link = this.opts.linkProtocol + '://' + link;
                    }

                    var target = ($('#redactor-image-link-blank').prop('checked')) ? true : false;

                    if ($link.length === 0)
                    {
                        var a = $('<a href="' + link + '">' + this.utils.getOuterHtml($image) + '</a>');
                        if (target)
                            a.attr('target', '_blank');

                        $image.replaceWith(a);
                    }
                    else
                    {
                        $link.attr('href', link);
                        if (target)
                        {
                            $link.attr('target', '_blank');
                        }
                        else
                        {
                            $link.removeAttr('target');
                        }
                    }
                }
                else if ($link.length !== 0)
                {
                    $link.replaceWith(this.utils.getOuterHtml($image));

                }

                this.modal.close();
                this.observe.images();
                this.code.sync();


            },
            setEditable: function ($image)
            {
                if (this.opts.imageEditable)
                {
                    $image.on('dragstart', $.proxy(this.image.onDrag, this));
                }

                $image.on('mousedown', $.proxy(this.image.hideResize, this));
                $image.on('click.redactor touchstart', $.proxy(function (e)
                {
                    this.observe.image = $image;

                    if (this.$editor.find('#redactor-image-box').length !== 0)
                        return false;

                    this.image.resizer = this.image.loadEditableControls($image);

                    $(document).on('click.redactor-image-resize-hide.' + this.uuid, $.proxy(this.image.hideResize, this));
                    this.$editor.on('click.redactor-image-resize-hide.' + this.uuid, $.proxy(this.image.hideResize, this));

                    // resize
                    if (!this.opts.imageResizable)
                        return;

                    this.image.resizer.on('mousedown.redactor touchstart.redactor', $.proxy(function (e)
                    {
                        this.image.setResizable(e, $image);
                    }, this));


                }, this));
            },
            setResizable: function (e, $image)
            {
                e.preventDefault();

                this.image.resizeHandle = {
                    x: e.pageX,
                    y: e.pageY,
                    el: $image,
                    ratio: $image.width() / $image.height(),
                    h: $image.height()
                };

                e = e.originalEvent || e;

                if (e.targetTouches)
                {
                    this.image.resizeHandle.x = e.targetTouches[0].pageX;
                    this.image.resizeHandle.y = e.targetTouches[0].pageY;
                }

                this.image.startResize();


            },
            startResize: function ()
            {
                $(document).on('mousemove.redactor-image-resize touchmove.redactor-image-resize', $.proxy(this.image.moveResize, this));
                $(document).on('mouseup.redactor-image-resize touchend.redactor-image-resize', $.proxy(this.image.stopResize, this));
            },
            moveResize: function (e)
            {
                e.preventDefault();

                e = e.originalEvent || e;

                var height = this.image.resizeHandle.h;

                if (e.targetTouches)
                    height += (e.targetTouches[0].pageY - this.image.resizeHandle.y);
                else
                    height += (e.pageY - this.image.resizeHandle.y);

                var width = Math.round(height * this.image.resizeHandle.ratio);

                if (height < 50 || width < 100)
                    return;

                var height = Math.round(this.image.resizeHandle.el.width() / this.image.resizeHandle.ratio);

                this.image.resizeHandle.el.attr({width: width, height: height});
                this.image.resizeHandle.el.width(width);
                this.image.resizeHandle.el.height(height);

                this.code.sync();
            },
            stopResize: function ()
            {
                this.handle = false;
                $(document).off('.redactor-image-resize');

                this.image.hideResize();
            },
            onDrag: function (e)
            {
                if (this.$editor.find('#redactor-image-box').length !== 0)
                {
                    e.preventDefault();
                    return false;
                }

                this.$editor.on('drop.redactor-image-inside-drop', $.proxy(function ()
                {
                    setTimeout($.proxy(this.image.onDrop, this), 1);

                }, this));
            },
            onDrop: function ()
            {
                this.image.fixImageSourceAfterDrop();
                this.observe.images();
                this.$editor.off('drop.redactor-image-inside-drop');
                this.clean.clearUnverified();
                this.code.sync();
            },
            fixImageSourceAfterDrop: function ()
            {
                this.$editor.find('img[data-save-url]').each(function ()
                {
                    var $el = $(this);
                    $el.attr('src', $el.attr('data-save-url'));
                    $el.removeAttr('data-save-url');
                });
            },
            hideResize: function (e)
            {
                if (e && $(e.target).closest('#redactor-image-box', this.$editor[0]).length !== 0)
                    return;
                if (e && e.target.tagName == 'IMG')
                {
                    var $image = $(e.target);
                    $image.attr('data-save-url', $image.attr('src'));
                }

                var imageBox = this.$editor.find('#redactor-image-box');
                if (imageBox.length === 0)
                    return;

                if (this.opts.imageEditable)
                {
                    this.image.editter.remove();
                }

                $(this.image.resizer).remove();

                imageBox.find('img').css({
                    marginTop: imageBox[0].style.marginTop,
                    marginBottom: imageBox[0].style.marginBottom,
                    marginLeft: imageBox[0].style.marginLeft,
                    marginRight: imageBox[0].style.marginRight
                });

                imageBox.css('margin', '');
                imageBox.find('img').css('opacity', '');
                imageBox.replaceWith(function ()
                {
                    return $(this).contents();
                });

                $(document).off('click.redactor-image-resize-hide.' + this.uuid);
                this.$editor.off('click.redactor-image-resize-hide.' + this.uuid);

                if (typeof this.image.resizeHandle !== 'undefined')
                {
                    this.image.resizeHandle.el.attr('rel', this.image.resizeHandle.el.attr('style'));
                }

                this.code.sync();

            },
            loadResizableControls: function ($image, imageBox)
            {
                if (this.opts.imageResizable && !this.utils.isMobile())
                {
                    var imageResizer = $('<span id="redactor-image-resizer" data-redactor="verified"></span>');

                    if (!this.utils.isDesktop())
                    {
                        imageResizer.css({width: '15px', height: '15px'});
                    }

                    imageResizer.attr('contenteditable', false);
                    imageBox.append(imageResizer);
                    imageBox.append($image);

                    return imageResizer;
                }
                else
                {
                    imageBox.append($image);
                    return false;
                }
            },
            loadEditableControls: function ($image)
            {
                var imageBox = $('<span id="redactor-image-box" data-redactor="verified">');
                imageBox.css('float', $image.css('float')).attr('contenteditable', false);

                if ($image[0].style.margin != 'auto')
                {
                    imageBox.css({
                        marginTop: $image[0].style.marginTop,
                        marginBottom: $image[0].style.marginBottom,
                        marginLeft: $image[0].style.marginLeft,
                        marginRight: $image[0].style.marginRight
                    });

                    $image.css('margin', '');
                }
                else
                {
                    imageBox.css({'display': 'block', 'margin': 'auto'});
                }

                $image.css('opacity', '.5').after(imageBox);


                if (this.opts.imageEditable)
                {
                    // editter
                    this.image.editter = $('<span id="redactor-image-editter" data-redactor="verified">' + this.lang.get('edit') + '</span>');
                    this.image.editter.attr('contenteditable', false);
                    this.image.editter.on('click', $.proxy(function ()
                    {
                        this.image.showEdit($image);
                    }, this));

                    imageBox.append(this.image.editter);

                    // position correction
                    var editerWidth = this.image.editter.innerWidth();
                    this.image.editter.css('margin-left', '-' + editerWidth / 2 + 'px');
                }

                return this.image.loadResizableControls($image, imageBox);

            },
            remove: function (image)
            {
                var $image = $(image);
                var $link = $image.closest('a', this.$editor[0]);
                var $figure = $image.closest('figure', this.$editor[0]);
                var $parent = $image.parent();
                if ($('#redactor-image-box').length !== 0)
                {
                    $parent = $('#redactor-image-box').parent();
                }

                var $next;
                if ($figure.length !== 0)
                {
                    $next = $figure.next();
                    $figure.remove();
                }
                else if ($link.length !== 0)
                {
                    $parent = $link.parent();
                    $link.remove();
                }
                else
                {
                    $image.remove();
                }

                $('#redactor-image-box').remove();

                if ($figure.length !== 0)
                {
                    this.caret.setStart($next);
                }
                else
                {
                    this.caret.setStart($parent);
                }

                // delete callback
                this.core.setCallback('imageDelete', $image[0].src, $image);

                this.modal.close();
                this.code.sync();
            },
            insert: function ()
            {
                var text = $('#redactor-insert-blocklist-area').val();
                
                var data = '';

                $.each(text.split('\n'), function (k, v) {
                    data = data + '<li>' + v + '</li>';
                });
                
                data =  '<div class="content-wrap"><ol>' + data + '</ol></div>';

                this.selection.restore();
                this.modal.close();

                var current = this.selection.getBlock() || this.selection.getCurrent();

                if (current) {
                    $(current).after(data);
                }
                else
                {
                    this.insert.html(data);
                }

                this.code.sync();
            },
            getTemplate: function ()
            {
                return String()
                        + '<section id="redactor-modal-blocklist-insert">'
                        + '<label>' + this.lang.get('blacklist_html_code') + '</label>'
                        + '<textarea id="redactor-insert-blocklist-area" style="height: 160px;"></textarea>'
                        + '</section>';
            },
        };
    };
})(jQuery);