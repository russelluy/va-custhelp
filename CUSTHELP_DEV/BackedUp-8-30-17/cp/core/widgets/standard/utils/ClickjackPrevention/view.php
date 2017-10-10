<?php /* Originating Release: May 2016 */?>
<?
// frame busting code added here to support widget use across all page sets
if ($this->data['attrs']['frame_options'] === "DENY"):
?>
    <script type="text/javascript">
    <!--
    if (parent !== self) {
        top.location.href = location.href;
    }
    else if (top !== self) {
        top.location.href = self.document.location;
    }
    //-->
    </script>
<? endif; ?>
