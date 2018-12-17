<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
/* @var $this \CrazyCat\Core\Block\Form\Renderer\Hidden */
$field = $this->getField();
$value = $this->getValue();
?>
<input type="hidden"
       id="<?php echo $this->getFieldId(); ?>"
       name="<?php echo $this->getFieldName(); ?>"
       value="<?php echo htmlEscape( $value ); ?>" />