<?php /* Originating Release: November 2014 */?>
<div id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
    <div class="rn_Title"><?=$this->data['attrs']['label_title'];?></div>
    <? if (count($this->data['topicWords']) > 0): ?>
    <rn:block id="preList"/>
    <dl id="rn_<?=$this->instanceID;?>_List">
        <rn:block id="listTop"/>
    <? foreach ($this->data['topicWords'] as $topicWord): ?>
        <rn:block id="listItem">
        <dt>
        <? if($this->data['attrs']['icon_path']):?>
            <img alt="" class="rn_FileTypeIcon" src="<?=$this->data['attrs']['icon_path']?>">
        <? elseif($this->data['attrs']['display_icon']):?>
            <?=$topicWord['icon'];?>
        <? endif; ?>
            <a href="<?=$topicWord['url'];?>" target="<?=$this->data['attrs']['target'];?>"><?=$topicWord['title']?></a>
        </dt>
        <dd>
            <rn:block id="itemText">
            <?=$topicWord['text'];?>
            </rn:block>
        </dd>
        </rn:block>
    <? endforeach; ?>
        <rn:block id="listBottom"/>
    </dl>
    <rn:block id="postList"/>
    <? endif; ?>
    <rn:block id="bottom"/>
</div>
