<?php /* Originating Release: May 2016 */?>
<div id="rn_<?= $this->instanceID; ?>" class="<?= $this->classList; ?>">
    <rn:block id="top"/>
    <ul>
        <rn:block id="topResultList"/>
        <? foreach ($this->data['results'] as $answer): ?>
            <rn:block id="resultListItem">
            <li>
                <span class="rn_Title">
                    <?  $target = '';
                        if($answer->URL){
                            $target = "target='{$this->data['attrs']['url_type_target']}'";
                        }
                    ?>
                    <a href="<?=$this->data['attrs']['answers_detail_url'] . "/a_id/$answer->ID" . \RightNow\Utils\Url::sessionParameter();?>" <?=$target;?>><?=\RightNow\Utils\Text::escapeHtml($answer->Title, false);?></a>
                </span>
            <? if($this->data['attrs']['show_excerpt']): ?>
                <span class="rn_Excerpt"><?=\RightNow\Utils\Text::escapeHtml($answer->Excerpt, false);?></span>
            <? endif; ?>
            </li>
            </rn:block>
        <? endforeach; ?>        
        <rn:block id="bottomResultList"/>
    </ul>
    <rn:block id="bottom"/>
</div>