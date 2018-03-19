$(function () {
    ServalMenu.init();
    ServalMenu.run();
});

var ServalMenu = {

    //class .cursor-active - current active menu item ( set as active from php side )
    //class .current-active -  active menu item ( set as active by js - user click )

    'init': function () {

        $('#ul-menu .menu-item.active').addClass('cursor-active');

    },

    'run': function () {

        $('#ul-menu').click(function (event) {
            ServalMenu.handleClick(event);
        });

    },

    'handleClick': function (e) {

        var target = e.target;

        if ($(target).hasClass('close-submenu')) {

            ServalMenu.subMenuCloseClick();
            return;
        }

        ServalMenu.menuClick(target);

    },

    'menuClick': function (target) {

        while (!$(target).hasClass('menu-item')) {
            target = target.parentNode;
        }

        if ($(target).attr('href') == '#') { // show submenu

            var current_active_menu = $('#ul-menu .menu-item.active');
            current_active_menu.removeClass('active');
            current_active_menu.siblings('div.submenu').removeClass('submenu-show');

            $(target).addClass('active current-active');
            $(target).siblings('div.submenu').addClass('submenu-show');

        } else { // hide submenu and set active clicked link

            $('#ul-menu .submenu.submenu-show').removeClass('submenu-show');
            $(target).addClass('active current-active');
            $('#ul-menu .menu-item.active.current-active').removeClass('active');

        }

    },

    'subMenuCloseClick': function () { //hide submenu and mark as active prev selected menu item

        $('#ul-menu .submenu.submenu-show').removeClass('submenu-show');
        $('#ul-menu .menu-item.active.current-active').removeClass('active');
        $('#ul-menu .menu-item.cursor-active').addClass('active');

    }

};
