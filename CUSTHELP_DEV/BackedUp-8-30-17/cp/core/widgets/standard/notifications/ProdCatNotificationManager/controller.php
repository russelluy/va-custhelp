<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

use RightNow\Utils\Config;

class ProdCatNotificationManager extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        $this->data['js']['duration'] = \RightNow\Utils\Config::getConfig(ANS_NOTIF_DURATION);
        $this->data['js']['productsTable'] = HM_PRODUCTS;
        $this->data['js']['categoriesTable'] = HM_CATEGORIES;

        $notificationLists = $this->CI->model('Notification')->get(array('product', 'category'))->result;
        $allNotifications = array_merge($notificationLists['product'] ?: array(), $notificationLists['category'] ?: array());
        $allNotifications = \RightNow\Utils\Framework::sortBy($allNotifications, true, function($n) { return $n->StartTime; });

        $notifications = $this->data['js']['notifications'] = array();
        foreach($allNotifications as $notification) {
            if(\RightNow\Utils\Connect::isProductNotificationType($notification)) {
                $label = Config::getMessage(PRODUCT_LBL);
                $hierarchyType = 'ProductHierarchy';
                $notificationObject = 'Product';
                $urlKey = 'p';
                $filterType = HM_PRODUCTS;
            }
            else {
                $label = Config::getMessage(CATEGORY_LBL);
                $hierarchyType = 'CategoryHierarchy';
                $notificationObject = 'Category';
                $urlKey = 'c';
                $filterType = HM_CATEGORIES;
            }
            
            $labelChain = "$label - ";
            foreach($notification->$notificationObject->$hierarchyType as $parent) {
                $labelChain .= $parent->LookupName . ' / ';
            }
            $labelChain .= $notification->$notificationObject->LookupName;

            $this->data['notifications'][] = array(
                'startDate' => \RightNow\Utils\Framework::formatDate($notification->StartTime, 'default', null),
                'label' => $labelChain,
                'url' => $this->data['attrs']['report_page_url'] . "/$urlKey/" . $notification->$notificationObject->ID . \RightNow\Utils\Url::sessionParameter(),
                'expiresTime' => ($this->data['js']['duration'] > 0) ? $notification->ExpireTime : null
            );

            $this->data['js']['notifications'][] = array(
                'id' => $notification->$notificationObject->ID,
                'filter_type' => $filterType
            );
        }
    }
}
