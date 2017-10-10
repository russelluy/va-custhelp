<?php /* Originating Release: May 2017 */ ?>

<a href="#" id="rn_<?=$this->instanceID;?>_Link">
  <span class="accessible-hidden-label"><?=$this->data['attrs']['link_label'];?></span>
</a>

<div id="rn_<?=$this->instanceID;?>_leavingSiteModal" class="leavingSiteModal rn_Hidden">
  <div class="bd">
    <div class="content">
      <h1 class="title" tabindex="-1" class="ModalTitle">You are about to leave virginamerica.com</h1>
      <p class="size1">You are about to be re-directed to an external website that may not follow the same accessibility policies as virginamerica.com.</p>

      <div class="fd">
        <button alt="Compose the message" name="continue" class="ExternalLink">Continue</button>
      </div>
      <p class="size1">or <a class="yui3-button-close" href="#">stay on virginamerica.com</a></p>
    </div>
  </div>
  <a class="yui3-button-close container-close" href="#">Close</a>
</div>
