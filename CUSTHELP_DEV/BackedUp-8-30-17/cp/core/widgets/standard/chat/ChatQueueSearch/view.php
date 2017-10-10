<?php /* Originating Release: May 2016 */?>
<div id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?> rn_ScreenReaderOnly">
    <rn:block id="top"/>
    <form method="post" onsubmit="return false">
        <rn:block id="formTop"/>
        <rn:widget path="search/KeywordText" label_text="#rn:php:$this->data['attrs']['label_text']#"/>
        <rn:widget path="search/SearchButton" report_page_url="#rn:php:$this->data['attrs']['report_page_url']#" target="_blank"/>
        <rn:block id="formBottom"/>
    </form>
    <rn:block id="bottom"/>
</div>
