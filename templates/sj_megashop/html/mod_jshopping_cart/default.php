<div class= "jmycart">
<div class="des-jshop-cart">
	   <a href = "<?php print SEFLink('index.php?option=com_jshopping&controller=cart&task=view', 1)?>"><i class="fa fa-shopping-cart"></i>
	   <span class="number-pro">
      	<span id = "jshop_quantity_products"><?php if($cart->count_product){print $cart->count_product.'&nbsp;'; }?></span><?php if($cart->count_product > 1){ print JText::_('JSHOP_ITEMS');}else if($cart->count_product > 0){print JText::_('JSHOP_ITEM');} else {print JText::_('MY_CART');}//print JText::_('PRODUCTS');?>
	   </span></a>
	</div>
</div>