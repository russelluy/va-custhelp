<?php /* Originating Release: May 2016 */?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
        <? if ($this->data['docID'] !== null && $this->data['docType'] !== 'HTML') : ?>
            <div class="rn_AnswerDetail rn_AnswerHeader">
                <div class="rn_AnswerInfo">
                    <rn:widget path="okcs/AnswerField" answer_key="docID" label="#rn:php:$this->data['attrs']['label_doc_id']#" value="#rn:php:$this->data['docID']#" sub_id="docid" xpath="a/b"/> 
                    <rn:widget path="okcs/AnswerField" answer_key="version" label="#rn:php:$this->data['attrs']['label_version']#" value="#rn:php:$this->data['version']#" sub_id="version"/>
                    <rn:widget path="okcs/AnswerField" answer_key="status" label="#rn:php:$this->data['attrs']['label_status']#" value="#rn:php:$this->data['published']#" sub_id="status"/>
                    <? if($this->data['published'] === \RightNow\Utils\Config::getMessage(PUBLISHED_LBL)): ?>
                        <rn:widget path="okcs/AnswerField" answer_key="publishedDate" label="#rn:php:$this->data['attrs']['label_published_date']#" value="#rn:php:$this->data['publishedDate']#" sub_id="pubdate">
                    <? elseif($this->data['published'] === \RightNow\Utils\Config::getMessage(DRAFT_LBL)): ?>
                        <rn:widget path="okcs/AnswerField" answer_key="modifiedDate" label="#rn:php:$this->data['attrs']['label_modified_date']#" value="#rn:php:$this->data['publishedDate']#" sub_id="pubdate">
                    <? endif; ?>
                </div>
            </div>
        <? endif ?>
    <rn:block id="bottom"/>
</div>