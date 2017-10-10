<?php /* Originating Release: May 2016 */?>
<div class="<?= $this->classList ?>">
    <rn:block id="top"/>
    <rn:block id="preBackUrl"/>
    <? if($this->data['attrs']['back_icon_path']):?>
        <a href="<?=$this->data['js']['backPageUrl'] . $this->data['appendedParameters'];?>" class="<?=$this->data['backClass'];?>"><img src="<?=$this->data['attrs']['back_icon_path'];?>" alt="<?=$this->data['attrs']['label_back'];?>"/></a>
    <? else:?>
        <a href="<?=$this->data['js']['backPageUrl'] . $this->data['appendedParameters'];?>" class="<?=$this->data['backClass'];?>"><?=$this->data['attrs']['label_back'];?></a>
    <? endif;?>
    <rn:block id="postBackUrl"/>
    <span class="rn_PageLinks">
        <rn:block id="listTop"/>
        <? for($i = $this->data['js']['startPage']; $i <= $this->data['js']['endPage']; $i++):?>
            <rn:block id="preListItem"/>
            <? if($i == $this->data['js']['currentPage']):?>
                <rn:block id="preCurrentPage"/>
                <span class="rn_CurrentPage"><?=$i;?></span>
                <rn:block id="postCurrentPage"/>
            <? else:?>
                <rn:block id="preOtherPage"/>
                <a href="<?=$this->data['js']['pageUrl'] . $i . $this->data['appendedParameters'];?>" title="<?printf($this->data['attrs']['label_page'], $i, $this->data['totalPages']);?>" class="test"><?=$i;?></a>
                <rn:block id="postOtherPage"/>
            <? endif;?>
            <rn:block id="postListItem"/>
        <? endfor;?>
        <rn:block id="listBottom"/>
    </span>
    <rn:block id="preForwardUrl"/>
    <? if($this->data['attrs']['forward_icon_path']):?>
        <a href="<?=$this->data['js']['forwardPageUrl'] . $this->data['appendedParameters'] . \RightNow\Utils\Url::sessionParameter();?>" class="<?=$this->data['forwardClass'];?>"><img src="<?=$this->data['attrs']['forward_icon_path']?>" alt="<?=$this->data['attrs']['label_forward']?>"/></a>
    <? else:?>
        <a href="<?=$this->data['js']['forwardPageUrl'] . $this->data['appendedParameters'] . \RightNow\Utils\Url::sessionParameter();?>" class="<?=$this->data['forwardClass'];?>"><?=$this->data['attrs']['label_forward']?></a>
    <? endif;?>
    <rn:block id="postForwardUrl"/>
    <rn:block id="bottom"/>
</div>
