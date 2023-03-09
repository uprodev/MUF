<?php
get_header();
$status = get_field('status');
$countries = get_field('country_list', get_the_ID());
$nomination_count = get_field('nomination_count');
?>
    <main>
        <div class="form">
            <?php if($status['value'] == 1):?>
                <form class="workshop-form">
                    <input type="hidden" name="workshop_id" value="<?php echo get_the_ID();?>">
                    <input type="text" name="first_name" placeholder="First Name" autocomplete="firstname">
                    <input type="text" name="last_name" placeholder="Last Name" autocomplete="lastname">
                    <input type="email" name="email" placeholder="E-mail" autocomplete="email">
                    <div class="search-wrapper">
                        <input type="hidden" name="ajax-crop-hidden" class="ajax-crop-hidden">
                        <input type="text" name="ajax_crop" placeholder="Crop EN common/scientific name" class="ajax-crop">
                        <div class="search-box">

                        </div>
                    </div>
                    <div class="search-wrapper">
                        <input type="hidden" name="ajax-target-hidden" class="ajax-target-hidden">
                        <input type="text" name="ajax_target" placeholder="Target EN common/scientific name" class="ajax-target">
                        <div class="search-box">

                        </div>
                    </div>
                    <select name="country" class="select_beauty" data-placeholder="Country">
                        <option value="" disabled selected>Country</option>
                        <?php foreach ($countries as $country):?>
                            <option value="<?php echo $country['value'];?>"><?php echo $country['label'];?></option>
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
                    <button type="submit" class="submit-workshop">Submit</button>
                </form>
            <?php elseif($status['value'] == 2):?>
                <form class="workshop-priorities">
                    <input type="hidden" name="workshop_id" value="<?php echo get_the_ID();?>">
                    <div class="form-row">
                        <div class="form-input">
                            <input type="text" name="first_name" placeholder="First Name" autocomplete="firstname">
                        </div>
                        <div class="form-input">
                            <input type="text" name="last_name" placeholder="Last Name" autocomplete="lastname">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-input">
                            <input type="email" name="email" placeholder="E-mail" autocomplete="email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-select">
                            <select name="country" class="select_beauty" data-placeholder="Country">
                                <option value="" disabled selected>Country</option>
                                <?php foreach ($countries as $country):?>
                                    <option value="<?php echo $country['value'];?>"><?php echo $country['label'];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="table">
                        <table>
                            <tr>
                                <th>Unique ID</th>
                                <th>Crop EN Common Name</th>
                                <th>Target EN Common Name</th>
                                <th>Target Scientific Name</th>
                                <th>Field/Greenhouse</th>
                                <th>Climate Zone</th>
                                <th>Discipline</th>
                                <th>Country</th>
                                <th>Nominated By</th>
                            </tr>
                            <?php
                            $args = array(
                                'post_type' => 'request',
                                'posts_per_page' => -1,
                                'meta_query' => array(
                                    array(
                                        'name' => 'workshop_id',
                                        'value' => get_the_ID()
                                    )
                                )
                            );
                            $post_groups = array();
                            $emails = array();
                            $posts = array();
                            query_posts($args);
                            while (have_posts()): the_post();
                                $crop_en = get_field('crop_en_commonscientific_name');
                                $crop_en_name = get_field('name', $crop_en);
                                $target_en = get_field('target_en_commonscientific_name');
                                $target_en_name = get_field('name', $target_en);
                                $target_name = '';
                                $field = get_field('field');
                                $climate_zone = get_field('climate_zone');
                                $discipline = get_field('discipline');
                                $country = get_field('country')['value'];
                                $email = get_field('email');
                                $group_key = $field . '|' . $climate_zone . '|' . $discipline . '|' . $country . '|' . $target_en . '|' . $crop_en;
                                if (!isset($post_groups[$group_key])) {
                                    $post_groups[$group_key] = array(
                                        'posts' => array(),
                                        'emails' => array(),
                                    );
                                }
                                $post_groups[$group_key]['posts'][] = get_post();
                                if (!empty($email)) {
                                    $post_groups[$group_key]['emails'][] = $email;
                                }
                                ?>

                            <?php endwhile;?>
<!--                            <pre>-->
<!--                            --><?php //var_dump($post_groups);?>
<!--                            </pre>-->
                            <?php foreach ($post_groups as $group_key => $group) {
                                $posts = $group['posts'];
                                $emails = $group['emails'];
                                usort($posts, function ($a, $b) {
                                    return strtotime($a->post_date) < strtotime($b->post_date);
                                });
                                $group_key_parts = explode('|', $group_key);
                                $group_title = implode(' | ', $group_key_parts);
                                $post = end($posts);
                                $crop_en = get_field('crop_en_commonscientific_name', $post->ID);
                                $target_en = get_field('target_en_commonscientific_name', $post->ID);
                                $crop_en_name = get_field('name', $crop_en);
                                $target_en_name = get_field('name', $target_en);
                                $target_name = '';
                                $field = get_field('field', $post->ID);
                                $climate_zone = get_field('climate_zone', $post->ID);
                                $discipline = get_field('discipline', $post->ID);
                                $country = get_field('country', $post->ID);
                                ?>
                                <tr>
                                    <td><?php echo $post->ID;?></td>
                                    <td><?php echo $crop_en_name;?></td>
                                    <td><?php echo $target_en_name;?></td>
                                    <td><?php echo $target_name;?></td>
                                    <td><?php echo $field;?></td>
                                    <td><?php echo $climate_zone;?></td>
                                    <td><?php echo $discipline;?></td>
                                    <td><?php echo $country['label'];?></td>
                                    <td><?php echo implode(', ', $emails);?></td>
                                </tr>
                            <?php }
                            ?>
                        </table>
                    </div>
                    <?php $count_posts = count($post_groups);
                    if($count_posts < $nomination_count){
                        $nomination_count = $count_posts;
                    }?>
                    <div class="table">
                        <table>
                            <tr>
                                <th>Priority</th>
                                <th>Unique ID</th>
                            </tr>
                            <?php
                            for ($i = 1; $i <= $nomination_count; $i++):?>
                                <tr>
                                    <td><?php echo $i;?> Priority</td>
                                    <td>
                                        <select class="priority_select" name="priority[<?php echo $i;?>]">
                                            <?php foreach ($post_groups  as $group_key => $group):
                                                $posts = $group['posts'];
                                                $post = end($posts);
                                                $crop_en = get_field('crop_en_commonscientific_name', $post->ID);
                                                $target_en = get_field('target_en_commonscientific_name', $post->ID);
                                                $crop_en_name = get_field('name', $crop_en);
                                                $target_en_name = get_field('name', $target_en);?>
                                                <option value="<?php echo $post->ID;?>"><?php echo $post->ID;?> - <?php echo $crop_en_name .' / '. $target_en_name;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </table>
                    </div>
                    <button type="submit" class="submit-priorities">Submit</button>
                </form>
            <?php elseif($status['value'] == 3):?>
                <form class="workshop-rating">
                    <input type="hidden" name="workshop_id" value="<?php echo get_the_ID();?>">
                    <div class="form-row">
                        <div class="form-input">
                            <input type="text" name="first_name" placeholder="First Name" autocomplete="firstname">
                        </div>
                        <div class="form-input">
                            <input type="text" name="last_name" placeholder="Last Name" autocomplete="lastname">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-input">
                            <input type="email" name="email" placeholder="E-mail" autocomplete="email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-select">
                            <select name="country" class="select_beauty" data-placeholder="Country">
                                <option value="" disabled selected>Country</option>
                                <?php foreach ($countries as $country):?>
                                    <option value="<?php echo $country['value'];?>"><?php echo $country['label'];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="table">
                        <table>
                            <tr>
                                <th>Unique ID</th>
                                <th>Crop EN Common Name</th>
                                <th>Target EN Common Name</th>
                                <th>Target Scientific Name</th>
                                <th>Field/Greenhouse</th>
                                <th>Countries Expressing Interest</th>
                                <th>Total Points</th>
                                <th>Rank</th>
                            </tr>
                            <?php
                            $args = array(
                                'post_type' => 'potential_solution',
                                'posts_per_page' => -1,
                                'meta_query' => array(
                                    'relation' => 'AND',
                                    array(
                                        'name' => 'workshop_id',
                                        'value' => get_the_ID()
                                    ),
                                )
                            );
                            $post_groups = array();
                            $countries_list = array();
                            $posts = array();
                            query_posts($args);
                            while (have_posts()): the_post();
                                $country = get_field('country')['label'];
                                while (have_rows('priorities')): the_row();
                                    $requests_id = get_sub_field('requests_id');
                                    $priority = get_sub_field('priority');
                                    $prev_value = $post_groups[$requests_id]['posts'] ? $post_groups[$requests_id]['posts'] : 0;
                                    $post_groups[$requests_id]['posts'] = $priority + $prev_value;
                                    if(empty($post_groups[$requests_id]['country'])){
                                        $post_groups[$requests_id]['country'][] = $country;
                                    }
                                    else{
                                        if(!in_array($countries, $post_groups[$requests_id]['country'])){
                                            $post_groups[$requests_id]['country'][] = $country;
                                        }
                                    }

                                endwhile;
                                ?>
                            <?php endwhile;
                            wp_reset_postdata();
                            uasort($post_groups, function ($a, $b) {
                                return $b["posts"] - $a["posts"];
                            });
                            ?>
                            <?php $count_posts = count($post_groups);
                            if($count_posts < $nomination_count){
                                $nomination_count = $count_posts;
                            }?>
                            <?php for ($i = 0; $i < $nomination_count; $i++):
                                $posts = array_keys($post_groups);
                                $post = $posts[$i];
                                $post_object = $post_groups[$post];
                                $crop_en = get_field('crop_en_commonscientific_name', $post);
                                $target_en = get_field('target_en_commonscientific_name', $post);
                                $crop_en_name = get_field('name', $crop_en);
                                $target_en_name = get_field('name', $target_en);
                                $field = get_field('field', $post);
                                $country_list = $post_object['country'];
                                $total_points = $post_object['posts'];
                                $rank = $i + 1;
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $post;?>
                                    </td>
                                    <td>
                                        <?php echo $crop_en_name;?>
                                    </td>
                                    <td>
                                        <?php echo $target_en_name;?>
                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <?php echo $field;?>
                                    </td>
                                    <td>
                                        <?php echo implode('; ', $country_list);?>
                                    </td>
                                    <td>
                                        <?php echo $total_points;?>
                                    </td>
                                    <td>
                                        <?php echo $rank;?>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </table>
                    </div>

                    <button type="submit" class="submit-priorities">Submit</button>
                </form>
            <?php endif;?>
        </div>
    </main>
    <div class="success_box" id="success_box" style="display:none;max-width:500px;">
        <div class="success_text_3" style="display:none;">You successfully added request</div>
        <div class="success_text_4" style="display:none;">You successfully added priorities</div>
    </div>
<?php get_footer();
