$(function () {
    UserDropDown.init();
    UserDropDown.run();
});

var UserDropDown = {

    'init': function () {
    },

    'run': function () {

        $('#user-dropdown-menu-btn').click(function (event) {

            UserDropDown.handleClick();

        });

        $(document).click(function (e) { // hide dropdown menu when click on other part of pages

            if (e.target.id != 'user-dropdown-menu-btn' && $(e.target).hasClass('user-dropdown-menu-item') != true) {

                $('#user-dropdown-menu ul').removeClass('user-menu-show');
                $('#user-dropdown-menu-btn').removeClass('active');

            }

        });

    },

    'handleClick': function (e) {

        if ($('#user-dropdown-menu ul').hasClass('user-menu-show')) {

            $('#user-dropdown-menu ul').removeClass('user-menu-show');
            $('#user-dropdown-menu-btn').removeClass('active');

        } else {

            $('#user-dropdown-menu ul').addClass('user-menu-show');
            $('#user-dropdown-menu-btn').addClass('active');
        }
    }
}
