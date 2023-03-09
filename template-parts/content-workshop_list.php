<?php $post_id = get_the_ID();?>
<tr>
    <td>
        <a href="<?php echo get_the_permalink();?>"><?php the_title();?></a>
    </td>
    <td><?php echo get_field('status', $post_id)['label'];?></td>
    <td><button class="button update_workshop-js" data-workshop_id="<?php echo $post_id;?>">Update Workshop</button></td>
</tr>