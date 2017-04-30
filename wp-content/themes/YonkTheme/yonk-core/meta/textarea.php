<?php defined('ABSPATH') or die('No script kiddies please!'); ?>

<tr>
    <th scope="row">
        <label for="<?php echo $name ?>"><?php echo $label ?></label>
    </th>
    <td>
        <textarea id="<?php echo $name ?>" name="<?php echo $name ?>" class="widefat" rows="6" placeholder="<?php echo $label ?>"><?php echo $value ?></textarea>
    </td>
</tr>