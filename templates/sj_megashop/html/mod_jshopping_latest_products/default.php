<div class="latest_products">
<?php foreach($last_prod as $curr){ ?>
   <div class="block_item">
       <?php if ($show_image) { ?>
       <div class="item_image">
           <a href="<?php print $curr->product_link?>"><img src = "<?php print $jshopConfig->image_product_live_path?>/<?php if ($curr->product_thumb_image) print $curr->product_thumb_image; else print $noimage?>" alt="" /></a>
       </div>
       <?php } ?>
       <div class="item_content">
       <div class="item_name">
           <a href="<?php print $curr->product_link?>"><?php print $curr->name?></a>
       </div>
       <?php if ($curr->_display_price){?>
       <div class="item_price">
           <?php print formatprice($curr->product_price);?>
       </div>
       <div class="item-review">
         <?php print showMarkStar($curr->average_rating); ?>
     </div>
       </div>
       <?php }?>
   </div>
<?php } ?>
</div>