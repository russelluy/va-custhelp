<div class='rn_SchemaAttributeValue'>
    <? if ($type === 'FILE') : ?>
        <a target='_blank' href="/ci/okcsFattach/get/<?=$this->data['value'];?>"><?=$this->data['fileName'];?></a>
    <? elseif($type === 'LIST') : ?>
        <? $listValues = explode(',', $value); ?>
        <? foreach ($listValues as $value): ?>
            <div class="rn_ListOption"><?= $value ?></div>
        <? endforeach; ?>
    <? elseif ($type !== 'CHECKBOX') : ?>
        <?= $value ?>
    <? endif; ?>
</div>