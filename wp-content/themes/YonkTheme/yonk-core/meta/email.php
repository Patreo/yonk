<?php defined('ABSPATH') or die('No script kiddies please!'); ?>

<tr>
    <th scope="row">
        <label for="<?php echo $name ?>"><?php echo $label ?></label>
    </th>
    <td>
        <input type="email" id="<?php echo $name ?>" name="<?php echo $name ?>" class="widefat" value="<?php echo $value ?>" placeholder="<?php echo $label ?>" />
    </td>
</tr>