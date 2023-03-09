<?php
/**
 * Template Name: Workshop template
 */
get_header();?>
<main>
    <div class="form">
        <form class="workshop-form">
            <input type="text" name="first_name" placeholder="First Name" autocomplete="firstname">
            <input type="text" name="last_name" placeholder="Last Name" autocomplete="lastname">
            <input type="email" name="email" placeholder="E-mail" autocomplete="email">
            <input type="text" name="ajax_crop" placeholder="Crop EN common/scientific name" class="ajax-crop">
            <input type="text" name="ajax_target" placeholder="Target EN common/scientific name" class="ajax-target">
            <select name="solution" class="select_beauty" data-placeholder="Country">
                <option value="" disabled selected>Country</option>
                <?php $countries = get_country_data();
                foreach ($countries as $key => $country):?>
                    <option value="<?php echo $key;?>"><?php echo $country;?></option>
                <?php endforeach;?>
            </select>
            <p>Field, Greenhouse *</p>
            <label>
                Field
                <input checked type="radio" name="field" value="Field">
            </label>
            <label>
                Greenhouse
                <input type="radio" name="field" value="Greenhouse">
            </label>
            <p>Climate Zone</p>
            <label>
                Temperate
                <input checked type="radio" name="zone" value="Temperate">
            </label>
            <label>
                Tropical
                <input type="radio" name="zone" value="Tropical">
            </label>
            <label>
                Greenhouse
                <input type="radio" name="zone" value="Greenhouse">
            </label>
            <p>Discipline</p>
            <label>
                Entomology
                <input checked type="radio" name="discipline" value="Entomology">
            </label>
            <label>
                Gastropoda
                <input type="radio" name="discipline" value="Gastropoda">
            </label>
            <label>
                Herbology
                <input type="radio" name="discipline" value="Herbology">
            </label>
            <?php $solution_args = array('post_type' => 'solution', 'posts_per_page' => -1);
            query_posts( $solution_args );
            if(have_posts()):?>
                <label>
                    Potential Solution
                    <select name="solution" class="select_beauty" data-placeholder="Potential Solution List">
                        <option value="" disabled selected>Potential Solution</option>
                        <?php while (have_posts()): the_post();?>
                            <option value="<?php echo get_the_ID();?>"><?php echo get_the_title();?></option>
                        <?php endwhile;?>
                    </select>
                </label>
            <?php endif;?>
            <?php wp_reset_postdata();?>
        </form>
    </div>
</main>
<?php get_footer();
