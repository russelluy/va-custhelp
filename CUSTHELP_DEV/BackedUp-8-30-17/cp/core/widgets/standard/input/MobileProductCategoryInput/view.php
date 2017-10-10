<?php /* Originating Release: May 2016 */?>
<? if ($this->data['js']['readOnly']): ?>
<rn:widget path="output/ProductCategoryDisplay" name="#rn:php:'Incident.' . $this->data['attrs']['data_type']#" label="#rn:php:$this->data['attrs']['label_input']#" left_justify="true"/>
<? else: ?>
<? $i = 1; $id = "rn_{$this->instanceID}_{$this->data['attrs']['data_type']}"; ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
    <? /* Dialog Content */ ?>
    <rn:block id="preDialog"/>
    <div id="<?= $id ?>_Level1Input" class="rn_Hidden rn_Input rn_MobileProductCategoryInput rn_Level1">
        <rn:block id="dialogTop"/>
    <? foreach ($this->data['firstLevel'] as $item): ?>
        <div class="rn_Parent <?=$item['selected'] ? 'rn_Selected' : '';?>">
            <input type="radio" name="<?= $id ?>_Level1" id="<?= $id ?>_Input1_<?= $i ?>" value="<?= $item['id'] ?>"/>
                <? $class = ($item['hasChildren'] && $this->data['attrs']['max_lvl'] !== 1) ? 'rn_HasChildren' : ''; ?>
                <label class="<?= $class ?>" id="<?= $id ?>_Label1_<?= $i ?>" for="<?= $id ?>_Input1_<?= $i ?>"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?>
                <? if ($item['hasChildren']): ?><span class="rn_ParentMenuAlt"> <?= $this->data['attrs']['label_parent_menu_alt'] ?></span><? endif; ?>
                </label>
            </div>
        <? $i++;
         endforeach; ?>
         <rn:block id="dialogBottom"/>
    </div>
    <rn:block id="postDialog"/>
    <? /* Displayed on the page */ ?>
    <? if ($this->data['attrs']['label_input']): ?>
    <label class="rn_Label" id="<?= $id ?>_Label" for="<?= $id ?>_Launch">
        <rn:block id="labelTop"/>
        <?= $this->data['attrs']['label_input'] ?>
        <? if ($this->data['attrs']['required_lvl']): ?>
            <span class="rn_Required"> <?= \RightNow\Utils\Config::getMessage(FIELD_REQUIRED_MARK_LBL) ?></span>
            <span class="rn_ScreenReaderOnly"><?= \RightNow\Utils\Config::getMessage(REQUIRED_LBL) ?></span>
        <? endif; ?>
        <rn:block id="labelBottom"/>
    </label>
    <? endif; ?>
    <rn:block id="preDisplayButton"/>
    <button type="button" id="<?=$id;?>_Launch"><?= $this->data['promptLabel'] ?></button>
    <rn:block id="postDisplayButton"/>
    <rn:block id="bottom"/>
</div>
<? endif;?>
