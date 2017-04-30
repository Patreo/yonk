<?php defined('ABSPATH') or die('No script kiddies please!'); ?>

<tr>
    <th scope="row">
        <label for="<?php echo $name ?>"><?php echo $label ?></label>
    </th>
    <td>
        <input type="date" id="<?php echo $name ?>" name="<?php echo $name ?>" value="<?php echo $value ?>" />
    </td>
</tr>