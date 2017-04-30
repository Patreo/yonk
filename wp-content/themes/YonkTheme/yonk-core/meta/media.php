<?php defined('ABSPATH') or die('No script kiddies please!'); ?>

<tr>
    <th scope="row">
        <label for="<?php echo $name ?>"><?php echo $label ?></label>
    </th>
    <td>
        <input class="regular-text" id="<?php echo $name ?>" name="<?php echo $name ?>" type="text" value="<?php echo $value ?>" />
        <input class="button metabox-media" id="<?php echo $name ?>_button" name="<?php echo $name ?>_button" type="button" value="Upload" />
    </td>
</tr>