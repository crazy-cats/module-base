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
       class="<?php echo $this->getClasses(); ?>"
       value="<?php echo htmlEscape( $value ); ?>"
       <?php
       foreach ( $this->getParams() as $key => $value ) :
           echo sprintf( '%s="%s"', $key, htmlEscape( $value ) );
       endforeach;
       ?>
       />