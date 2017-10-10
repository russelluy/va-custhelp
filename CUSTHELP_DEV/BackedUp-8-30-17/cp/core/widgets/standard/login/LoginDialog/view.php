<?php /* Originating Release: May 2016 */?>
<div id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?> rn_Hidden">
    <rn:block id="top"/>
    <? if($this->data['attrs']['open_login_url']):?>
    <rn:block id="openLoginLink">
    <div class="rn_OpenLoginAlternative">
        <a id="rn_<?=$this->instanceID;?>_OpenLoginLink" href="<?=$this->data['attrs']['open_login_url'] . \RightNow\Utils\Url::sessionParameter();?>"><?=$this->data['attrs']['label_open_login_link'];?></a>
    </div>
    </rn:block>
    <? endif;?>
    <div id="rn_<?=$this->instanceID;?>_Content" class="rn_LoginDialogContent">
        <rn:block id="preErrorMessage"/>
        <div id="rn_<?=$this->instanceID;?>_ErrorMessage"></div>
        <rn:block id="postErrorMessage"/>
        <form id="rn_<?=$this->instanceID;?>_Form" onsubmit="return false;">
            <rn:block id="preUsername"/>
            <label for="rn_<?=$this->instanceID;?>_Username"><?=$this->data['attrs']['label_username'];?></label>
            <input id="rn_<?=$this->instanceID;?>_Username" type="text" maxlength="80" name="Contact.Login" autocorrect="off" autocapitalize="off" value="<?=$this->data['username'];?>"/>
            <rn:block id="postUsername"/>
        <? if(!$this->data['attrs']['disable_password']):?>
            <rn:block id="prePassword"/>
            <label for="rn_<?=$this->instanceID;?>_Password"><?=$this->data['attrs']['label_password'];?></label>
            <input id="rn_<?=$this->instanceID;?>_Password" type="password" name="Contact.Password" maxlength="20" <?=($this->data['attrs']['disable_password_autocomplete']) ? 'autocomplete="off"' : '' ?>/>
            <rn:block id="postPassword"/>
        <? endif;?>
        </form>
        <rn:block id="assistanceLink">
        <span><a href="<?=$this->data['attrs']['assistance_url'] . \RightNow\Utils\Url::sessionParameter();?>"><?=$this->data['attrs']['label_assistance'];?></a></span>
        </rn:block>
    </div>
    <rn:block id="bottom"/>
</div>
