<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
/* @var $this \CrazyCat\Base\Block\Form\Renderer\Hidden */
$field = $this->getField();
$value = $this->getValue();
?>
<input type="hidden"
       id="<?php echo $this->getFieldId(); ?>"
       name="<?php echo $this->getFieldName(); ?>"
       class="<?php echo $this->getClasses(); ?>"
       value="<?php echo htmlEscape( $value ); ?>"
       <?php
       foreach ( $this->getParams() as $k => $v ) :
           echo sprintf( '%s="%s"', $k, htmlEscape( $v ) );
       endforeach;
       ?> />