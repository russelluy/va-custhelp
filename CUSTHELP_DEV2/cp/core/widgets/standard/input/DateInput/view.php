<?php /* Originating Release: November 2014 */?>
<? if ($this->data['readOnly']): ?>
    <rn:widget path="output/FieldDisplay" left_justify="true">
<? else: ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<rn:block id="top"/>
<fieldset>
<? if ($this->data['attrs']['label_input']): ?>
    <legend id="rn_<?= $this->instanceID ?>_Legend" class="rn_Label"><?= $this->data['attrs']['label_input'] ?>
        <rn:block id="legendTop"/>
        <? if ($this->data['attrs']['required']): ?>
            <span class="rn_Required"><?= \RightNow\Utils\Config::getMessage(FIELD_REQUIRED_MARK_LBL) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage(REQUIRED_LBL)?></span>
        <? endif; ?>
        <rn:block id="legendBottom"/>
    </legend>
<? endif; ?>
<? if ($this->data['attrs']['hint']): ?>
    <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
<? endif; ?>
<? for ($i = 0; $i < 3; $i++): ?>

    <? /*Year*/ ?>
    <? if ($this->data['yearOrder'] === $i): ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Year" class="rn_ScreenReaderOnly"><?= $this->data['yearLabel']?></label>
    <rn:block id="preYearSelect"/>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Year" name="<?= $this->data['inputName'] ?>.year">
        <rn:block id="topYearSelect"/>
        <option value=''>--</option>
        <? for ($j = $this->data['attrs']['max_year']; $j >= $this->data['attrs']['min_year']; $j--): ?>
        <option value="<?= $j ?>" <?= $this->outputSelected(2, $j) ?>><?= $j ?></option>
        <? endfor; ?>
        <rn:block id="bottomYearSelect"/>
    </select>
    <rn:block id="postYearSelect"/>

    <? /*Month*/ ?>
    <? elseif ($this->data['monthOrder'] === $i): ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Month" class="rn_ScreenReaderOnly"><?= $this->data['monthLabel'] ?></label>
    <rn:block id="preMonthSelect"/>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Month" name="<?= $this->data['inputName']?>.month">
        <rn:block id="topMonthSelect"/>
        <option value=''>--</option>
        <? for ($j = 1; $j < 13; $j++): ?>
        <option value="<?= $j ?>" <?= $this->outputSelected(0, $j) ?>><?= $j ?></option>
        <? endfor; ?>
        <rn:block id="bottomMonthSelect"/>
    </select>
    <rn:block id="postMonthSelect"/>

    <? /*Day*/ ?>
    <? else: ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Day" class="rn_ScreenReaderOnly"><?= $this->data['dayLabel'] ?></label>
    <rn:block id="preDaySelect"/>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Day" name="<?= $this->data['inputName']?>.day">
        <rn:block id="topDaySelect"/>
        <option value=''>--</option>
        <? for ($j = 1; $j < 32; $j++): ?>
        <option value="<?= $j ?>" <?= $this->outputSelected(1, $j) ?>><?= $j ?></option>
        <? endfor; ?>
        <rn:block id="bottomDaySelect"/>
    </select>
    <rn:block id="postDaySelect"/>
    <? endif; ?>
<? endfor; ?>

<? if ($this->data['displayType'] === 'DateTime'): ?>

    <? /*Hour*/ ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Hour" class="rn_ScreenReaderOnly"><?= $this->data['hourLabel'] ?></label>
    <rn:block id="preHourSelect"/>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Hour" name="<?= $this->data['inputName']?>.hour">
        <rn:block id="topHourSelect"/>
        <option value=''>--</option>
        <? for ($j = 0; $j < 24; $j++): ?>
        <option value="<?= $j ?>" <?= $this->outputSelected(3, $j) ?>><?= $j ?></option>
        <rn:block id="bottomHourSelect"/>
        <? endfor; ?>
    </select>
    <rn:block id="postHourSelect"/>

    <? /*Minute*/ ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Minute" class="rn_ScreenReaderOnly"><?= $this->data['minuteLabel'] ?></label>
    <rn:block id="preMinuteSelect"/>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Minute" name="<?= $this->data['inputName']?>.minute">
        <rn:block id="topMinuteSelect"/>
        <option value=''>--</option>
        <? for ($j = 0; $j < 60; $j++): ?>
        <option value="<?= $j ?>" <?= $this->outputSelected(4, $j) ?>><?= $j ?></option>
        <? endfor; ?>
        <rn:block id="bottomMinuteSelect"/>
    </select>
    <rn:block id="postMinuteSelect"/>
<? endif; ?>
<? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
    <rn:block id="preHint"/>
    <span class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
    <rn:block id="postHint"/>
<? endif; ?>
</fieldset>
<rn:block id="bottom"/>
</div>
<? endif; ?>
