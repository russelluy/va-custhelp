<?php /* Originating Release: May 2016 */?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>

    <? if ($this->data['js']['editingOwnAvatar']): ?>
        <h2><?= $this->data['attrs']['label_update_picture'] ?></h2>
    <? endif ?>

    <? if ($this->data['js']['socialUser']): ?>
        <rn:block id="prePreviewImage"/>
        <section class="rn_PreviewImage">
            <img class="<?= $this->data['currentAvatar']['url'] ? '' : 'rn_Hidden'?>" src="<?= $this->data['currentAvatar']['url'] ?: '#' ?>" alt=""/>
            <div class="rn_UserAvatar">
                <div class="rn_Avatar rn_Large rn_Placeholder">
                    <span class="rn_Default rn_DefaultColor<?= $this->data['js']['defaultAvatar']['color'] ?> <?= !$this->data['currentAvatar']['url'] ? '' : 'rn_Hidden'?>">
                        <span class="rn_Liner">
                            <?= $this->data['js']['defaultAvatar']['text'] ?>
                        </span>
                    </span>
                </div>
            </div>
        </section>
        <rn:block id="postPreviewImage"/>

        <rn:block id="preAvatarOptions"/>
        <section class="rn_AvatarOptions">
            <rn:block id="preDefaultOption"/>
            <div class="rn_DefaultOption rn_AvatarOption <?= !$this->data['currentAvatar']['url'] ? 'rn_ChosenAvatar' : '' ?>">
                <? if (!$this->data['currentAvatar']['url']): ?>
                    <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['label_using_default_avatar'] ?></span>
                <? endif; ?>
                <div id="rn_<?= $this->instanceID ?>_DefaultForm">
                    <label for="rn_<?= $this->instanceID ?>_SelectDefault"><?= $this->data['attrs']['label_default'] ?></label>
                    <button id="rn_<?= $this->instanceID ?>_SelectDefault" type="button"><?= $this->data['attrs']['label_apply_button'] ?></button>

                    <? if ($this->data['attrs']['label_default_hint'] || $this->data['attrs']['label_default_hint_user']): ?>
                    <rn:block id="preDefaultHint"/>
                    <div class="rn_HintText" id="rn_<?= $this->instanceID ?>_DefaultHint">
                        <?= $this->data['js']['editingOwnAvatar'] ? $this->data['attrs']['label_default_hint'] : $this->data['attrs']['label_default_hint_user'] ?>
                    </div>
                    <rn:block id="postDefaultHint"/>
                    <? endif; ?>
                </div>
            </div>
            <rn:block id="postDefaultOption"/>

            <? if ($this->data['js']['editingOwnAvatar'] && $this->data['attrs']['label_gravatar_account']): ?>
            <rn:block id="preGravatarOption"/>
            <div class="rn_Gravatar rn_AvatarOption <?= $this->data['currentAvatar']['type'] === 'gravatar' ? 'rn_ChosenAvatar' : '' ?>">
                <? if ($this->data['currentAvatar']['type'] === 'gravatar'): ?>
                    <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['label_chosen_gravatar'] ?></span>
                <? endif; ?>
                <div id="rn_<?= $this->instanceID ?>_GravatarForm">
                    <rn:block id="preGravatarLabel"/>
                    <label for="rn_<?= $this->instanceID ?>_SelectGravatar">
                        <?= $this->data['attrs']['label_gravatar_account'] ?>
                    </label>
                    <rn:block id="postGravatarLabel"/>

                    <div class="rn_GravatarAddress"><?= $this->data['js']['email']['address'] ?></div>
                    <button id="rn_<?= $this->instanceID ?>_SelectGravatar" type="button"><?= $this->data['attrs']['label_apply_button'] ?></button>

                    <? if ($this->data['attrs']['label_gravatar_hint']): ?>
                    <rn:block id="preGravatarHint"/>
                    <div class="rn_HintText" id="rn_<?= $this->instanceID ?>_GravatarHint">
                        <?= $this->data['attrs']['label_gravatar_hint'] ?>
                    </div>
                    <rn:block id="postGravatarHint"/>
                    <? endif; ?>
                </div>
            </div>
            <rn:block id="postGravatarOption"/>
            <? endif; ?>
        </section>
        <rn:block id="postAvatarOptions"/>
    <? else: ?>
        <div class="rn_NoSocialUser">
            <?= $this->data['attrs']['label_no_public_profile'] ?>
            <a href="javascript:void(0);" id="rn_<?= $this->instanceID ?>_AddSocialUser" class="rn_AddSocialUser"><?= $this->data['attrs']['label_add_public_profile'] ?></a>
        </div>
    <? endif; ?>
    <rn:block id="bottom"/>
</div>
