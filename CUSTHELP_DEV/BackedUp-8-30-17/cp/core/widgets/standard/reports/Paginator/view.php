<?php /* Originating Release: May 2016 */?>
<div id="rn_<?=$this->instanceID?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
    <rn:block id="preBackUrl"/>
    <a href="<?=$this->data['js']['backPageUrl'];?>" id="rn_<?=$this->instanceID;?>_Back" class="<?=$this->data['backClass'];?>">
    <rn:block id="postBackUrl"/>
    <? if($this->data['attrs']['back_icon_path']):?>
        <rn:block id="preBackIcon"/>
        <img src="<?=$this->data['attrs']['back_icon_path'];?>" alt="<?=$this->data['attrs']['label_back'];?>"/>
        <rn:block id="postBackIcon"/>
    <? else:?>
        <rn:block id="preBackLabel"/>
        <?=$this->data['attrs']['label_back'];?>
        <rn:block id="postBackLabel"/>
    <? endif;?>
    </a>
    <span id="rn_<?=$this->instanceID;?>_Pages" class="rn_PageLinks">
        <rn:block id="listTop"/>
        <? for($i = $this->data['js']['startPage']; $i <= $this->data['js']['endPage']; $i++):?>
            <rn:block id="preListItem"/>
            <? if($i == $this->data['js']['currentPage']):?>
                <rn:block id="preCurrentPage"/>
                <span class="rn_CurrentPage"><?=$i;?></span>
                <rn:block id="postCurrentPage"/>
            <? else:?>
                <rn:block id="preOtherPage"/>
                <a id="rn_<?=$this->instanceID . '_PageLink_' . $i;?>" href="<?=$this->data['js']['pageUrl'] . $i;?>" title="<?printf($this->data['attrs']['label_page'], $i, $this->data['totalPages']);?>">
                    <?=$i;?><span class="rn_ScreenReaderOnly"><?printf($this->data['attrs']['label_page'], $i, $this->data['totalPages']);?></span>
                </a>
                <rn:block id="postOtherPage"/>
            <? endif;?>
            <rn:block id="postListItem"/>
        <? endfor;?>
        <rn:block id="listBottom"/>
    </span>
    <rn:block id="preForwardUrl"/>
    <a href="<?=$this->data['js']['forwardPageUrl'];?>" id="rn_<?=$this->instanceID;?>_Forward" class="<?=$this->data['forwardClass'];?>">
    <rn:block id="postForwardUrl"/>
    <? if($this->data['attrs']['forward_icon_path']):?>
        <rn:block id="preForwardIcon"/>
        <img src="<?=$this->data['attrs']['forward_icon_path']?>" alt="<?=$this->data['attrs']['label_forward']?>"/>
        <rn:block id="postForwardIcon"/>
    <? else:?>
        <rn:block id="preForwardLabel"/>
        <?=$this->data['attrs']['label_forward']?>
        <rn:block id="postForwardLabel"/>
    <? endif;?>
    </a>
    <rn:block id="bottom"/>
</div>
