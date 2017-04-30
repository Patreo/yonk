<?php defined('ABSPATH') or die('No script kiddies please!'); ?>

<tr>
    <?php if (strlen($label) != 0): ?>
        <th scope="row">
            <label for="<?php echo $name ?>"><?php echo $label ?></label>
        </th>
    <?php endif; ?>
    <td>
        <div id="Gallery_<?php echo $name ?>">
            <div class="gallery-view" style="height:380px;border:solid 1px #ddd;padding:10px;margin-bottom:10px;overflow-y:auto;"></div>
            <input type="hidden" id="<?php echo $name ?>" name="<?php echo $name ?>" value="<?php echo $value ?>" />
            <input type="button" class="gallery-media button-primary" value="Insert from Media" />
        </div>
    </td>
</tr>

<script type="text/javascript">
    (function($) {
        $(document).ready(function () {
            $('#Gallery_<?php echo $name ?>').gallery();
        })
    })(jQuery);
</script>