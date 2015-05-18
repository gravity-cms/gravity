define(['jquery', 'bootstrap'], function ($, bs) {

    var _expanded = false,
        _this = this,
        $menu = $('#main-menu'),
        $menuToggle = $('#main-menu-toggle'),
        $body = $('body'),
        $navi = $menu.find('ul.navigation'),
        $dropdowns = $navi.find('> .mm-dropdown > ul'),
        menuTimer,

        fnHide = function () {
            this.removeClass('open');
            this.find('> ul').attr('style', '');
        },

        fnShow = function () {
            this.addClass('open');
            this.find('> ul').attr('style', '');
        },

        _handleClick = function () {
            var li = (this.type == 'li') ? $(this) : $(this).closest('li'),
                ul = li.find('> ul'),
                w = $body.width(),
                isOpen = li.hasClass('open');

            if (w > 768 || w < 480) {

                if (isOpen) {
                    ul.slideUp(300, $.proxy(fnHide, li));
                } else {
                    $navi.find('> .open').each(function () {
                        $lli = $(this);
                        if (li[0] != this)
                            $lli.find('> ul').slideUp(300, $.proxy(fnHide, $lli));
                    });
                    ul.slideDown(300, $.proxy(fnShow, li));
                }

            }

            return false;
        },

        _handleHover = function () {
            var li = (this.type == 'li') ? $(this) : $(this).closest('li'),
                ul = li.find('> ul'),
                w = $body.width(),
                isOpen = li.hasClass('open');

            if (w > 480 && w < 768 || $body.hasClass('mmc')) {

                if (isOpen) {
                    li.off('mouseenter mouseleave').on('mouseenter', (function (_li) {
                            return function () {
                                clearTimeout(_this.menuTimer);
                            };
                        })(li)).on('mouseleave', (function (_li) {
                            return function () {
                                return _this.menuTimer = setTimeout(function () {
                                    return _li.removeClass('open');
                                }, 200);
                            };
                        })(li));
                } else {
                    _this.menuTimer = undefined;
                    $navi.find('> .open').each(function () {
                        if (li[0] != this) {
                            fnHide.call($(this));
                        }
                    });

                    li.addClass('open');
                }

            }
        }

        ;

    $body.addClass('main-menu-animated animate-mm-sm animate-mm-md animate-mm-lg');
    $menu.find('.navigation > .mm-dropdown').addClass('mm-dropdown-root');

    $navi.find('> .mm-dropdown > ul').addClass('mmc-dropdown-delay animated');
    $navi.find('> li > a > .mm-text').addClass('mmc-dropdown-delay animated fadeIn');
    $menu.find('.menu-content').addClass('animated fadeIn');

    $navi.find('> li').each(function(){
        var $li = $(this),
            $ul = $li.find('> ul'),
            $title = $ul.find('> .mmc-title');
        if (!$title.length) {
            $title = $('<div class="mmc-title"></div>').text($li.find('> a > .mm-text').text());
            $ul.prepend($title);
        }
    });

    $dropdowns.addClass('mmc-dropdown-delay animated');
    if ($body.hasClass('main-menu-right') || ($body.hasClass('right-to-left') && !$body.hasClass('main-menu-right'))) {
        $dropdowns.addClass('fadeInRight');
    } else {
        $dropdowns.addClass('fadeInLeft');
    }

    $menuToggle.on('click', function () {
        var btn = $(this),
            isExpanded  = $body.hasClass('mme'),
            isCollapsed = $body.hasClass('mmc'),
            w = $body.width();
        if (w > 768) {
            $body.removeClass('mme');
            if(isCollapsed){
                $body.removeClass('mmc');
            } else {
                $body.addClass('mmc');
            }
        } else {
            $body.removeClass('mmc');
            if(isExpanded){
                $body.removeClass('mme');
            } else {
                $body.addClass('mme');
            }
        }
    });

    $menu.on('click', '.mm-dropdown > a', _handleClick);

    $menu.on('mouseenter', '.mm-dropdown > a', _handleHover)
        .on('mouseleave', '.mm-dropdown > a', _handleHover);


    var f = (function () {
        PixelAdmin.MainMenu = function () {
            this._screen = null;
            this._last_screen = null;
            this._animate = false;
            this._close_timer = null;
            this._dropdown_li = null;
            this._dropdown = null;
            return this;
        };


        /*
         * Initialize plugin.
         */

        PixelAdmin.MainMenu.prototype.init = function () {


            this.$menu.find('.navigation').on('mouseenter.pa.mm-dropdown', '.mm-dropdown-root',function () {
                self.clearCloseTimer();
                if (self._dropdown_li === this) {
                    return;
                }
                if (self._collapsed() && (!self._dropdown_li || !elHasClass(self._dropdown_li, 'freeze'))) {
                    return self.openDropdown(this);
                }
            }).on('mouseleave.pa.mm-dropdown', '.mm-dropdown-root', function () {
                return self._close_timer = setTimeout(function () {
                    return self.closeCurrentDropdown();
                }, PixelAdmin.settings.main_menu.dropdown_close_delay);
            });
            return this;
        };

        PixelAdmin.MainMenu.prototype.onResize = function () {
            this._screen = getScreenSize(this.$ssw_point, this.$tsw_point);
            this._animate = PixelAdmin.settings.main_menu.disable_animation_on.indexOf(screen) === -1;
            if (this._dropdown_li) {
                this.closeCurrentDropdown(true);
            }
            if ((this._screen === 'small' && this._last_screen !== this._screen) || (this._screen === 'tablet' && this._last_screen === 'small')) {
                document.body.className += ' disable-mm-animation';
                setTimeout((function (_this) {
                    return function () {
                        return elRemoveClass(document.body, 'disable-mm-animation');
                    };
                })(this), 20);
            }
            return this._last_screen = this._screen;
        };

        PixelAdmin.MainMenu.prototype.clearCloseTimer = function () {
            if (this._close_timer) {
                clearTimeout(this._close_timer);
                return this._close_timer = null;
            }
        };

        PixelAdmin.MainMenu.prototype._onAnimationEnd = function (e) {
            if (this._screen !== 'desktop' || e.target.id !== 'main-menu') {
                return;
            }
            return $(window).trigger('resize');
        };

        PixelAdmin.MainMenu.prototype.toggle = function () {
            var cls, collapse;
            cls = this._screen === 'small' || this._screen === 'tablet' ? 'mme' : 'mmc';
            if (elHasClass(document.body, cls)) {
                elRemoveClass(document.body, cls);
            } else {
                document.body.className += ' ' + cls;
            }
            if (cls === 'mmc') {
                if (PixelAdmin.settings.main_menu.store_state) {
                    this._storeMenuState(elHasClass(document.body, 'mmc'));
                }
                if (!$.support.transition) {
                    return $(window).trigger('resize');
                }
            } else {
                collapse = document.getElementById('');
                $('#main-navbar-collapse').stop().removeClass('in collapsing').addClass('collapse')[0].style.height = '0px';
                return $('#main-navbar .navbar-toggle').addClass('collapsed');
            }
        };


        PixelAdmin.MainMenu.prototype.collapseAllSubmenus = function (li) {
            var self;
            self = this;
            return $(li).parent().find('> .mm-dropdown.open').each(function () {
                return self.collapseSubmenu(this);
            });
        };

        PixelAdmin.MainMenu.prototype.openDropdown = function (li, freeze) {
            var $li, $title, $ul, $wrapper, max_height, min_height, title_h, top, ul, w_height, wrapper;
            if (freeze == null) {
                freeze = false;
            }
            if (this._dropdown_li) {
                this.closeCurrentDropdown(freeze);
            }
            $li = $(li);
            $ul = $li.find('> ul');
            ul = $ul[0];
            this._dropdown_li = li;
            this._dropdown = ul;
            $title = $ul.find('> .mmc-title');
            if (!$title.length) {
                $title = $('<div class="mmc-title"></div>').text($li.find('> a > .mm-text').text());
                ul.insertBefore($title[0], ul.firstChild);
            }
            li.className += ' mmc-dropdown-open';
            ul.className += ' mmc-dropdown-open-ul';
            top = $li.position().top;
            if (elHasClass(document.body, 'main-menu-fixed')) {
                $wrapper = $ul.find('.mmc-wrapper');
                if (!$wrapper.length) {
                    wrapper = document.createElement('div');
                    wrapper.className = 'mmc-wrapper';
                    wrapper.style.overflow = 'hidden';
                    wrapper.style.position = 'relative';
                    $wrapper = $(wrapper);
                    $wrapper.append($ul.find('> li'));
                    ul.appendChild(wrapper);
                }
                w_height = $(window).innerHeight();
                title_h = $title.outerHeight();
                min_height = title_h + $ul.find('.mmc-wrapper > li').first().outerHeight() * 3;
                if ((top + min_height) > w_height) {
                    max_height = top - $('#main-navbar').outerHeight();
                    ul.className += ' top';
                    ul.style.bottom = (w_height - top - title_h) + 'px';
                } else {
                    max_height = w_height - top - title_h;
                    ul.style.top = top + 'px';
                }
                if (elHasClass(ul, 'top')) {
                    ul.appendChild($title[0]);
                } else {
                    ul.insertBefore($title[0], ul.firstChild);
                }
                li.className += ' slimscroll-attached';
                $wrapper[0].style.maxHeight = (max_height - 10) + 'px';
                $wrapper.pixelSlimScroll({});
            } else {
                ul.style.top = top + 'px';
            }
            if (freeze) {
                this.freezeDropdown(li);
            }
            if (!freeze) {
                $ul.on('mouseenter', (function (_this) {
                        return function () {
                            return _this.clearCloseTimer();
                        };
                    })(this)).on('mouseleave', (function (_this) {
                        return function () {
                            return _this._close_timer = setTimeout(function () {
                                return _this.closeCurrentDropdown();
                            }, PixelAdmin.settings.main_menu.dropdown_close_delay);
                        };
                    })(this));
                this;
            }
            return this.menu.appendChild(ul);
        };

        PixelAdmin.MainMenu.prototype.closeCurrentDropdown = function (force) {
            var $dropdown, $wrapper;
            if (force == null) {
                force = false;
            }
            if (!this._dropdown_li || (elHasClass(this._dropdown_li, 'freeze') && !force)) {
                return;
            }
            this.clearCloseTimer();
            $dropdown = $(this._dropdown);
            if (elHasClass(this._dropdown_li, 'slimscroll-attached')) {
                elRemoveClass(this._dropdown_li, 'slimscroll-attached');
                $wrapper = $dropdown.find('.mmc-wrapper');
                $wrapper.pixelSlimScroll({
                    destroy: 'destroy'
                }).find('> *').appendTo($dropdown);
                $wrapper.remove();
            }
            this._dropdown_li.appendChild(this._dropdown);
            elRemoveClass(this._dropdown, 'mmc-dropdown-open-ul');
            elRemoveClass(this._dropdown, 'top');
            elRemoveClass(this._dropdown_li, 'mmc-dropdown-open');
            elRemoveClass(this._dropdown_li, 'freeze');
            $(this._dropdown_li).attr('style', '');
            $dropdown.attr('style', '').off('mouseenter').off('mouseleave');
            this._dropdown = null;
            return this._dropdown_li = null;
        };

        PixelAdmin.MainMenu.prototype.freezeDropdown = function (li) {
            return li.className += ' freeze';
        };

        PixelAdmin.MainMenu.prototype.setupAnimation = function () {
            var $mm, $mm_nav, d_body, dsbl_animation_on;
            d_body = document.body;
            dsbl_animation_on = PixelAdmin.settings.main_menu.disable_animation_on;
            d_body.className += ' dont-animate-mm-content';
            $mm = $('#main-menu');
            $mm_nav = $mm.find('.navigation');
            $mm_nav.find('> .mm-dropdown > ul').addClass('mmc-dropdown-delay animated');
            $mm_nav.find('> li > a > .mm-text').addClass('mmc-dropdown-delay animated fadeIn');
            $mm.find('.menu-content').addClass('animated fadeIn');
            if (elHasClass(d_body, 'main-menu-right') || (elHasClass(d_body, 'right-to-left') && !elHasClass(d_body, 'main-menu-right'))) {
                $mm_nav.find('> .mm-dropdown > ul').addClass('fadeInRight');
            } else {
                $mm_nav.find('> .mm-dropdown > ul').addClass('fadeInLeft');
            }
            d_body.className += dsbl_animation_on.indexOf('small') === -1 ? ' animate-mm-sm' : ' dont-animate-mm-content-sm';
            d_body.className += dsbl_animation_on.indexOf('tablet') === -1 ? ' animate-mm-md' : ' dont-animate-mm-content-md';
            d_body.className += dsbl_animation_on.indexOf('desktop') === -1 ? ' animate-mm-lg' : ' dont-animate-mm-content-lg';
            return window.setTimeout(function () {
                return elRemoveClass(d_body, 'dont-animate-mm-content');
            }, 500);
        };

        PixelAdmin.MainMenu.Constructor = PixelAdmin.MainMenu;

        PixelAdmin.addInitializer(function () {
            return PixelAdmin.initPlugin('main_menu', new PixelAdmin.MainMenu);
        });

    });
    //.call(this);

    // var init = [];
    //PixelAdmin.start(init);

});
