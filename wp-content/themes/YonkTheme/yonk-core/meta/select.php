<?php defined('ABSPATH') or die('No script kiddies please!'); ?>

<tr>
    <th scope="row">
        <label for="<?php echo $name ?>"><?php echo $label ?></label>
    </th>
    <td>
        <select id="<?php echo $name ?>" name="<?php echo $name ?>">
            <?php foreach ($options as $key => $text) { ?>
            <option value="<?php echo $key; ?>" <?php echo (($value == NULL ? $default : $value) == strval($key) ? 'selected' : ''); ?>><?php echo $text; ?></option>
            <?php } ?>
        </select>
    </td>
</tr>