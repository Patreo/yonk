<?php defined('ABSPATH') or die('No script kiddies please!'); ?>

<tr>
    <th scope="row">
        <label for="<?php echo $name ?>"><?php echo $label ?></label>
    </th>
    <td>
        <input type="checkbox" id="<?php echo $name ?>" name="<?php echo $name ?>" class="widefat" value="1" <?php echo ($value == '1' ? 'checked' : ''); ?> />
    </td>
</tr>