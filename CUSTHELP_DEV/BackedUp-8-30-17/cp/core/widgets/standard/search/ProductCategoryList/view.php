<?php /* Originating Release: May 2016 */?>
<div id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>

    <?= $this->data['attrs']['label_title'] ? "<h2>{$this->data['attrs']['label_title']}</h2>" : "" ?>

    <? $index = 1;
    foreach($this->data['results'] as $key => $value):?>
    <rn:block id="preItem"/>
    <div class="rn_HierList rn_HierList_<?=$key;?> <? if($index % 2) echo 'rn_FloatLeft'; else echo 'rn_FloatRight';?>">
    <h3><a href="<?=$this->data['attrs']['report_page_url'] . $this->data['appendedParameters'] . \RightNow\Utils\Url::sessionParameter() . "/{$this->data['type']}/" . $value['hierList'];?>"><?=htmlspecialchars($value['label'], ENT_QUOTES, 'UTF-8');?></a></h3>
        <? if(count($value['subItems'])):?>
        <rn:block id="preSubList"/>
        <ul>
        <? for($i = 0; $i < count($value['subItems']); $i++):?>
        <rn:block id="listItem">
        <li><a href="<?=$this->data['attrs']['report_page_url'] . $this->data['appendedParameters'] . \RightNow\Utils\Url::sessionParameter() . "/{$this->data['type']}/" . $value['subItems'][$i]['hierList'];?>"><?=htmlspecialchars($value['subItems'][$i]['label'], ENT_QUOTES, 'UTF-8');?></a></li>
        </rn:block>
        <? endfor;?>
        </ul>
        <rn:block id="postSubList"/>
        <? endif;?>    
    </div>
    <rn:block id="postItem"/>
    <? $index++;
        endforeach;?>
    <rn:block id="bottom"/>
</div>
