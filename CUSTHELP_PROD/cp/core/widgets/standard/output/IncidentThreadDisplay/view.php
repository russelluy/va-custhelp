<?php /* Originating Release: November 2014 */?>
<div id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
<? if ($this->data['attrs']['label']): ?>
    <rn:block id="label">
    <span class="rn_DataLabel"><?=$this->data['attrs']['label'];?> </span>
    </rn:block>
<? endif; ?>
<? if($this->data['value']): ?>
    <rn:block id="preList"/>
<? foreach($this->data['value'] as $thread): ?>
    <?
      // This is not a public note, so it should not be displayed.
      if ($this->threadIsPrivate($thread)) continue;

      $threadMetadata = $thread::getMetadata();
      $subclass = $this->threadIsCustomerEntry($thread) ? 'rn_Customer' : '';
    ?>
    <rn:block id="preListItem"/>
    <div class="rn_ThreadHeader <?=$subclass?>">
        <rn:block id="preThreadHeader"/>
        <span class="rn_ThreadAuthor">
            <rn:block id="threadAuthor">
            <?=$thread->EntryType->LookupName;?>
            <?= $this->getAuthorName($thread) ?>
            <? if($thread->Channel)
                printf(\RightNow\Utils\Config::getMessage(VIA_PCT_S_LBL), $thread->Channel->LookupName);
            ?>
            </rn:block>
        </span>
        <span class="rn_ThreadTime">
            <rn:block id="threadTime">
            <?=\RightNow\Libraries\Formatter::formatField($thread->CreatedTime, $threadMetadata->CreatedTime, $this->data['attrs']['highlight']);?>
            </rn:block>
        </span>
        <rn:block id="postThreadHeader"/>
    </div>
    <div class="rn_ThreadContent">
        <rn:block id="threadContent">
        <?=\RightNow\Libraries\Formatter::formatThreadEntry($thread, $this->data['attrs']['highlight']);?>
        </rn:block>
    </div>
    <rn:block id="postListItem"/>
<? endforeach; ?>
    <rn:block id="postList"/>
<? endif; ?>
    <rn:block id="bottom"/>
</div>
