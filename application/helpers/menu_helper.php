<?php
class Menu {

    private static $items = array('dashboard' => '',
                                'users' => '',
                                'members' => '',
                                'admins' => '',
                                'codes' => '',
                                'generate' => '',
                                'listings' => '',
                                'transfer' => '',
                                'settings' => '',
                                'maintenance' => '',
                                'announcement' => '',
                                'gsc' => '',
                                'leadership' => '',
                                'encashment' => '',
                            );

    public static function setSelected($active_item)
    {
        self::$items[$active_item] = 'active open';
    }

    public static function getSelected($active_item)
    {
        return self::$items[$active_item];
    }
} 