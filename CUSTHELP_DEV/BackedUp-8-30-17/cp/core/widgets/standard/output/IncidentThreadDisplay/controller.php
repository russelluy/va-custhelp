<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class IncidentThreadDisplay extends \RightNow\Libraries\Widget\Output
{
    function __construct($attrs)
    {
        parent::__construct($attrs);
    }

    function getData()
    {
        if(parent::getData() === false)
            return false;

        // Validate data type
        if (!\RightNow\Utils\Connect::isIncidentThreadType($this->data['value']))
        {
            echo $this->reportError(\RightNow\Utils\Config::getMessage(INCIDENTTHREADDISPLAY_DISP_THREAD_MSG));
            return false;
        }

        //Cast Connect array to a normal array. Connect fails if we need to call the array_reverse function
        //and we want to be consistent in what datatype we provide to the view
        $this->data['value'] = (array)$this->data['value'];
        //Connect apparently doesn't guarantee thread order, so order items to ensure consistency
        usort($this->data['value'], function($a, $b){
            if($a->CreatedTime === $b->CreatedTime){
                if($a->DisplayOrder === $b->DisplayOrder){
                    return 0;
                }
                return ($a->DisplayOrder > $b->DisplayOrder) ? -1 : 1;
            }
            return ($a->CreatedTime > $b->CreatedTime) ? -1 : 1;
        });
        if($this->data['value'] && $this->data['attrs']['thread_order'] === 'ascending')
        {
            $this->data['value'] = array_reverse($this->data['value']);
        }
    }

    /**
     * Returns the name of the author of the given thread.
     * A sama honorific (NAME_SUFFIX_LBL messagebase) is
     * added to the customer name; this value is populated
     * on Japanese interfaces.
     * @param Connect\Thread|null $thread Thread object
     * @return string String author name
     */
    function getAuthorName($thread) {
        switch ($thread->EntryType->ID) {
            case ENTRY_CUSTOMER:
                $name = $thread->Contact->LookupName;
                $suffix = \RightNow\Utils\Config::getMessage(NAME_SUFFIX_LBL);
                $name .= ($suffix) ? " $suffix" : '';
                break;
            case ENTRY_RULE_RESP:
                $name = '';
                break;
            default:
                $name = $thread->Account->DisplayName;
                break;
        }

        return $name;
    }

    /**
     * Determines if the given thread is private and should
     * not be displayed.
     * @param Connect\Thread|null $thread Thread object
     * @return boolean True if the thread is private
     *                      and shouldn't be displayed;
     *                      False if the thread should
     *                      be displayed
     */
    function threadIsPrivate($thread) {
        return !in_array($thread->EntryType->ID, array(
            ENTRY_STAFF,
            ENTRY_CUSTOMER,
            ENTRY_CUST_PROXY,
            ENTRY_RNL,
            ENTRY_RULE_RESP,
        ), true);
    }

    /**
     * Determines if the given thread is a customer or
     * customer proxy entry.
     * @param Connect\Thread|null $thread Thread object
     * @return Boolean True if the thread is a
     *                      customer or customer
     *                      proxy entry; False otherwise
     */
    function threadIsCustomerEntry($thread) {
        return $thread->EntryType->ID === ENTRY_CUSTOMER ||
               $thread->EntryType->ID === ENTRY_CUST_PROXY;
    }
}
