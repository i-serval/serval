<?php

namespace backend\widgets\serval_menu;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

class ServalMenu extends Widget
{

    public $items = [];
    public $options = [];
    public $route;
    public $params;
    public $itemOptions = [];
    public $link_template = '<a id="menu-{id}" class="menu-item {classes}" href="{url}"  {script} >
                                <span>{label}</span>
                            </a>
                            {sub_menu}';

    public $sub_menu_link_template = '<a href="{url}" class="{class}">
                                        <span>{label}</span>
                                      </a>';

    public $active_css_class = 'active';
    public $default_submenu_css_class = 'submenu';
    public $default_submenu_title_css = 'submenu-title';
    public $default_submenu_close_item_css = 'close-submenu';
    public $default_submenu_cols_css = 'submenu-cols';
    public $default_submenu_block_css = 'submenu-block';
    public $default_submenu_block_items_css = 'submenu-block-items';
    public $default_submenu_block_item_title_css = 'submenu-block-title';
    public $default_submenu_block_item_css = 'submenu-block-item';

    public function init()
    {

        parent::init();

    }

    public function run()
    {

        if ( $this->route === null && Yii::$app->controller !== null ) {
            $this->route = Yii::$app->controller->getRoute();
        }

        if ( $this->params === null ) {
            $this->params = Yii::$app->request->getQueryParams();
        }

        if ( !empty( $this->items ) ) {

            $options = $this->options;
            $tag = ArrayHelper::remove( $options, 'tag', 'ul' );

            $this->prepareData();

            echo Html::tag( $tag, $this->renderItems(), $options ) . Html::tag( 'div', '', [ 'id' => 'fake-nav'] );

        }

    }

    protected function renderItems()
    {

        $lines = [];

        foreach ( $this->items as $i => $item ) {

            $options = array_merge( $this->itemOptions, ArrayHelper::getValue( $item, 'options', [] ) );
        
            $tag = ArrayHelper::remove( $options, 'tag', 'li' );

            $menu = $this->renderItem( $item );

            $lines[] = Html::tag( $tag, $menu, $options );

        }

        return implode( "\n", $lines );
    }

    protected function renderItem( &$menu_item )
    {

        $template = ArrayHelper::getValue( $menu_item, 'template', $this->link_template );

        $url = $menu_item[ 'url' ][0];
        $script = '';
        $sub_menu = '';
        $classes = [];

        if( $url != '#' ) {

            $url = Html::encode( Url::to( $url ) );

        } else {

            $script = ' onclick="return false;" ';

        }

        if( isset( $menu_item[ 'sub_menu'] ) ) {
            $sub_menu = $this->renderSubMenu( $menu_item[ 'sub_menu'] );
        }

        if( isset( $menu_item[ 'active' ] ) && $menu_item[ 'active' ] === true ) {
            $classes[] = $this->active_css_class;
        }


        return strtr( $template, [
            '{url}' => $url,
            '{label}' => $menu_item[ 'label' ],
            '{id}' => $menu_item[ 'id' ],
            '{script}' => $script,
            '{sub_menu}' => $sub_menu,
            '{classes}' => implode( ' ', $classes ),

        ]);

    }

    protected function renderSubMenu( &$item )
    {

        $options = ArrayHelper::remove( $item, 'options', [] );

        if( !isset( $options['class']  ) || $options['class'] === '' ) {
            $options['class'] = $this->default_submenu_css_class;
        }

        $sub_menu_label = '';
        $close_menu_btn = '';

        if( isset( $item[ 'label' ] ) ) {

            $label_options = ArrayHelper::remove( $item['label'], 'options', [] );
            $this->setDefaultOption( $label_options, 'class', $this->default_submenu_title_css );
            $sub_menu_label = Html::tag( 'span', $this->getValue( $item[ 'label' ] ), $label_options );
            $close_menu_btn = Html::tag( 'a', '', [ ' href' => '#', 'class' => $this->default_submenu_close_item_css, 'onclick' => 'return false;' ]  );

        }

        $tag = ArrayHelper::remove( $options, 'tag', 'div' );

        return Html::tag( $tag, $sub_menu_label . $close_menu_btn . $this->renderSubMenuCols( $item[ 'menu_items' ] ), $options );

    }

    protected function renderSubMenuCols( &$menu_cols )
    {

        $cols = [];

        foreach ( $menu_cols as $i => $column ) {

            $cols[] = Html::tag( 'li', $this->renderSubMenuBlock( $column ) );

        }

        return Html::tag( 'ul', implode( "\n", $cols ), ['class' =>  $this->default_submenu_cols_css ] );

    }

    protected function renderSubMenuBlock( &$block_items ) {

        $li = [];

        foreach ( $block_items as $i => $item ) {

            $tag = ArrayHelper::remove( $options, 'tag', 'li' );

            $block = $this->renderSubMenuBlockItems( $item );

            $li[] = Html::tag( $tag, $block );

        }

        return Html::tag( 'ul', implode( "\n", $li ), ['class' =>  $this->default_submenu_block_css ] );

    }

    protected function renderSubMenuBlockItems( &$sub_block_items )
    {

        $block_label = '';

        if( isset( $sub_block_items[ 'label' ] ) ) {

            $block_label = Html::tag( 'span',
                                       Html::tag( 'span', $sub_block_items[ 'label' ] ),
                                        [ 'class' => $this->default_submenu_block_item_title_css ]
                                    );

            unset( $sub_block_items[ 'label' ] );

        }

        $li = [];

        foreach ( $sub_block_items as $i => $block_item ) {

            $li[] = $this->renderSubMenuBlockItem( $block_item );

        }

        return $block_label
                . Html::tag(
                    'div',
                    Html::tag(
                        'ul',
                        implode( "\n", $li ),
                        ['class' =>  $this->default_submenu_block_items_css ]
                    )
                );

    }

    protected function renderSubMenuBlockItem( &$block_item )
    {

        $template = ArrayHelper::getValue( $block_item, 'template', $this->sub_menu_link_template );

        return Html::tag( 'li', strtr( $template, [ '{label}' => $block_item[ 'label' ], '{url}' => $block_item[ 'url' ][0], '{class}'=> $this->default_submenu_block_item_css ] ) );

    }

    protected function prepareData( ) {

        foreach ( $this->items as $i => $menu_item ) {

            if( isset( $menu_item[ 'url' ] ) && is_array( $menu_item[ 'url' ] ) && isset( $menu_item[ 'url' ][ 0 ] ) ) { // check for menu

                if( $this->checkIsItemActive( $menu_item['url'] ) === true ) {
                    $this->items[$i]['active'] = true;
                    break;
                }
            }

            if( isset( $menu_item['sub_menu']['menu_items'] ) && is_array( $menu_item['sub_menu']['menu_items'] ) ) { // check in submenu

                foreach ( $menu_item['sub_menu']['menu_items'] as $menu_column ) {

                    foreach ( $menu_column as $menu_groups ) {

                        foreach ( $menu_groups as $group_item ){

                            if( isset( $group_item[ 'url' ] ) && is_array( $group_item[ 'url' ] ) && isset( $group_item[ 'url' ][ 0 ] ) ) { // check for submenu item

                                if( $this->checkIsItemActive( $group_item['url'] ) === true ) {
                                    $this->items[$i]['active'] = true;
                                    break;
                                }
                            }

                        }
                    }
                }
                
            }

        }

    }
    
    protected function checkIsItemActive( &$urls )
    {

        $route = Yii::getAlias( $urls[ 0 ] );

        if ( $route[ 0 ] !== '/' && Yii::$app->controller ) {

            $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;

        }

        if ( ltrim( $route, '/' ) == $this->route ) {
            return true;
        }

        unset( $urls[ 0 ] );

        foreach ( $urls as $url ){

            $current_url = [ $url ];

            if( $this->checkIsItemActive( $current_url ) === true ){

                return true;

            }

        }

        return false;

    }

    protected function setDefaultOption( &$options, $option_name, &$option_default_value ) {

        if ( ! isset( $options[ $option_name ] ) ) {

            $options[ $option_name ] = $option_default_value;

        }

    }

    protected function getValue( &$node_info ){

        if( is_array( $node_info ) ){
            return $node_info[ 0 ];
        }

        return $node_info;

    }

}
