<?php /* Originating Release: November 2014 */?>
<div id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
    <div id="rn_<?=$this->instanceID;?>_Alert" role="alert" class="rn_ScreenReaderOnly"></div>
    <rn:block id="preLoadingIndicator"/>
    <div id="rn_<?=$this->instanceID;?>_Loading"></div>
    <rn:block id="postLoadingIndicator"/>
    <div id="rn_<?=$this->instanceID;?>_Content" class="rn_Content">
        <rn:block id="topContent"/>
        <? if (is_array($this->data['reportData']['data']) && count($this->data['reportData']['data']) > 0): ?>
        <rn:block id="preResultList"/>
        <? if ($this->data['reportData']['row_num']): ?>
            <ol start="<?=$this->data['reportData']['start_num'];?>">
        <? else: ?>
            <ul>
        <? endif; ?>
        <rn:block id="topResultList"/>
        <? $reportColumns = count($this->data['reportData']['headers']);
           foreach ($this->data['reportData']['data'] as $value): ?>
            <rn:block id="resultListItem">
            <li>
                <span class="rn_Element1"><?=$value[0];?></span>
                <? if($value[1]): ?>
                <span class="rn_Element2"><?=$value[1];?></span>
                <? endif; ?>
                <span class="rn_Element3"><?=$value[2];?></span>
                <? for ($i = 3; $i < $reportColumns; $i++): ?>
                    <? $header = $this->data['reportData']['headers'][$i]; ?>
                    <? if ($this->showColumn($value[$i], $header)): ?>
                    <span class="rn_ElementsHeader"><?=$this->getHeader($header);?></span>
                    <span class="rn_ElementsData"><?=$value[$i];?></span>
                    <? endif; ?>
                <? endfor; ?>
            </li>
            </rn:block>
        <? endforeach; ?>
        <rn:block id="bottomResultList"/>
        <? if ($this->data['reportData']['row_num']): ?>
            </ol>
        <? else: ?>
            </ul>
        <? endif; ?>
        <rn:block id="postResultList"/>
        <? endif; ?>
        <rn:block id="bottomContent"/>
    </div>
    <rn:block id="bottom"/>
</div>
