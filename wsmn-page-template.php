<?php
/**
 * Template Name: Workshop Management
 */
get_header();?>
<main>
    <div class="container">
        <button class="button" data-fancybox data-src="#add_workshop">
            <?php _e('New', 'muf-theme');?>
        </button>
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $args = array(
                        'post_type' => 'workshop',
                        'posts_per_page' => -1,
                    );
                    query_posts($args);
                    while (have_posts()): the_post();
                        get_template_part( 'template-parts/content', 'workshop_list' );
                    endwhile;
                    wp_reset_postdata();?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<div class="add_workshop" id="add_workshop" style="display:none;max-width:500px;">
        <div class="form">
            <form class="workshop-management">
                <input required type="text" name="title" placeholder="Workshop Title">
                <textarea name="emails" placeholder="Email List"></textarea>
                <select required multiple name="countries[]" class="select2-country" data-placeholder="Country List">
                    <?php $countries = get_country_data();
                    foreach ($countries as $key => $country):?>
                        <option value="<?php echo $key;?>"><?php echo $country;?></option>
                    <?php endforeach;?>
                </select>
                <select required name="status">
                    <option value="" disabled selected>Status</option>
                    <?php $statuses = get_status_data();
                    foreach ($statuses as $key => $value):?>
                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                    <?php endforeach;?>
                </select>
                <button type="submit" class="submit-workshop"><?php _e('Save', 'muf-theme');?></button>
            </form>
        </div>
    </div>
<div class="update_workshop" id="update_workshop" style="display:none;max-width:500px;">
    <div class="form">
        <form class="workshop-management-update">
            <input name="workshop_id" type="hidden" value="">
            <input required type="text" name="title" placeholder="Workshop Title">
            <textarea name="emails" placeholder="Email List"></textarea>
            <select required multiple name="countries[]" class="select2-country" data-placeholder="Country List">
                <?php $countries = get_country_data();
                foreach ($countries as $key => $country):?>
                    <option value="<?php echo $key;?>"><?php echo $country;?></option>
                <?php endforeach;?>
            </select>
            <select required name="status">
                <option value="" disabled selected>Status</option>
                <?php $statuses = get_status_data();
                foreach ($statuses as $key => $value):?>
                    <option value="<?php echo $key;?>"><?php echo $value;?></option>
                <?php endforeach;?>
            </select>
            <button type="submit" class="update-workshop"><?php _e('Update', 'muf-theme');?></button>
        </form>
    </div>
</div>
<div class="success_box" id="success_box" style="display:none;max-width:500px;">
    <div class="success_text_1" style="display:none;">You successfully added the form</div>
    <div class="success_text_2" style="display:none;">You successfully update the form</div>
</div>
<?php get_footer();