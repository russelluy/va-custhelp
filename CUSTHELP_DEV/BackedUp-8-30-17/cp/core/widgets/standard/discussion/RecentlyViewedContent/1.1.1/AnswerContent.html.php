<li class="rn_AnswerContentItem">
    <a href="<?= \RightNow\Utils\Url::defaultAnswerUrl($content->ID) ?>">
        <?= $this->helper->getTitle($content, $this->data['attrs']['truncate_size']) ?>
    </a>
</li>