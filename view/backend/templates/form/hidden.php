<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
/* @var $this \CrazyCat\Core\Block\Form\Renderer\Text */
$field = $this->getField();
$value = $this->getValue();
?>
<input type="hidden" name="data[<?php echo $field['name']; ?>]" value="<?php echo htmlEscape( $value ); ?>" />
