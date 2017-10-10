<?php /* Originating Release: May 2016 */?>
<?$this->addHeadContent('<link rel="alternate" type="application/rss+xml" title="' . $this->data['attrs']['feed_title'] . '" href="' . \RightNow\Utils\Url::getCachedContentServer() . '/ci/cache/rss' . $this->data['feedParms'] . '" />');?>

<?if($this->data['attrs']['icon_path']):?>
    <span id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
        <rn:block id="link">
        <a href="<?=\RightNow\Utils\Url::getCachedContentServer()?>/ci/cache/rss<?=$this->data['feedParms']?>">
            <img src="<?=$this->data['attrs']['icon_path'];?>" alt="<?=$this->data['attrs']['feed_title'];?>" />
        </a>
        </rn:block>
    <rn:block id="bottom"/>
    </span>
<?endif;?>
