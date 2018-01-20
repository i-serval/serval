$( function() {

    ServalMenu.init();
    ServalMenu.run();

    UserDropDown.init();
    UserDropDown.run();

});

var UserDropDown = {

    'init':function(){},

    'run':function(){

        $( '#user-dropdown-menu-btn' ).click( function( event ) {

            UserDropDown.handleClick();

        } );

        $( document ).click( function( e ) { // hide dropdown menu when click on other part of pages

            if( e.target.id != 'user-dropdown-menu-btn' &&  $( e.target ).hasClass('user-dropdown-menu-item') != true ) {

                $('#user-dropdown-menu ul').removeClass('user-menu-show');
                $('#user-dropdown-menu-btn').removeClass('active');

            }

        });

    },

    'handleClick': function( e ) {

        if( $( '#user-dropdown-menu ul' ).hasClass( 'user-menu-show' ) ){

            $( '#user-dropdown-menu ul' ).removeClass( 'user-menu-show' );
            $( '#user-dropdown-menu-btn' ).removeClass( 'active' );

        } else {

            $( '#user-dropdown-menu ul' ).addClass( 'user-menu-show' );
            $( '#user-dropdown-menu-btn' ).addClass( 'active' );

        }

    }



}

var ServalMenu = {

    //class .cursor-active - current active menu item ( set as active from php side )
    //class .current-active -  active menu item ( set as active by js - user click )

    'init':function() {

        $( '#ul-menu .menu-item.active' ).addClass( 'cursor-active' );

    },

    'run':function() {

        $( '#ul-menu' ).click( function( event ) {
            ServalMenu.handleClick( event );
        } );

    },

    'handleClick':function( e ) {

        var target = e.target;

        if ( $( target ).hasClass( 'close-submenu' ) ) {

            ServalMenu.subMenuCloseClick( );
            return;
        }

        ServalMenu.menuClick( target );

    },

    'menuClick':function( target ) {

        while ( ! $( target ).hasClass( 'menu-item' ) ) {
            target = target.parentNode;
        }

        if( $( target ).attr( 'href' ) == '#' ) { // show submenu

            var current_active_menu = $( '#ul-menu .menu-item.active' );
            current_active_menu.removeClass( 'active' );
            current_active_menu.siblings( 'div.submenu' ).removeClass( 'submenu-show' );

            $( target ).addClass('active current-active');
            $( target ).siblings( 'div.submenu' ).addClass( 'submenu-show' );

        } else { // hide submenu and set active clicked link

            $( '#ul-menu .submenu.submenu-show' ).removeClass( 'submenu-show' );
            $( target ).addClass('active current-active');
            $( '#ul-menu .menu-item.active.current-active' ).removeClass( 'active' );

        }

    },

    'subMenuCloseClick':function( ) { //hide submenu and mark as active prev selected menu item

        $( '#ul-menu .submenu.submenu-show' ).removeClass( 'submenu-show' );
        $( '#ul-menu .menu-item.active.current-active' ).removeClass( 'active' );
        $( '#ul-menu .menu-item.cursor-active' ).addClass( 'active' );

    }

};

