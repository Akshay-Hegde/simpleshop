<section class="title">
    <h4 class="breadcrumbs">
        <?php echo simpleshop_category_breadcrumbs($viewing_category_node, true); ?>
        <?php echo $page_title; ?>
    </h4>
</section>

<section class="item">

<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div class="form_inputs">
    <ul>
        <li class="<?php echo alternator('', 'even'); ?>">
            <label for="title"><?php echo lang('simpleshop.products.title_label'); ?> <span>*</span></label>
            <div class="input"><?php echo form_input('title', set_value('title', $product->getTitle()), 'id="title" maxlength="130"'); ?></div>
        </li>

        <li class="<?php echo alternator('', 'even'); ?>">
            <label for="price"><?php echo lang('simpleshop.products.price_label'); ?></label>
            <div class="input">
                <?php echo Settings::get('currency'); ?>
                <?php echo form_input('price', set_value('price', $product->getPrice()), 'id="price"'); ?>
            </div>
        </li>

        <li class="<?php echo alternator('', 'even'); ?>">
            <label for="stock"><?php echo lang('simpleshop.products.stock_label'); ?></label>
            <div class="inline input"><?php echo form_input('stock', set_value('stock', $product->getStock()), 'id="stock"'); ?></div>

            <input type="checkbox" class="inline-checkbox" name="unlimited_stock" id="unlimited_stock" value="1" <?php echo set_checkbox('unlimited_stock', '1', $product->getUnlimitedStock()); ?> />
            <label for="unlimited_stock" class="inline-checkbox"><?php echo lang('simpleshop.products.unlimited_stock_label'); ?></label>
        </li>

        <li class="editor <?php echo alternator('', 'even'); ?>">
            <label for="description"><?php echo lang('simpleshop.products.description_label'); ?></label>
            <br style="clear: both;" />
            <?php echo form_textarea(array(
                'id' => 'description',
                'name' => 'description',
                'value' => set_value('description', $product->getDescription()),
                'rows' => 10,
                'class' => 'wysiwyg-simple'));
            ?>
        </li>

        <li class="inline-checkbox product-categories <?php echo alternator('', 'even'); ?>">
            <h4><?php echo lang('simpleshop.products.categories_label'); ?></h4>

            <?php if (empty($root_categories)): ?>
                <p><?php echo lang('simpleshop.no_categories') . ' ' . anchor('admin/simpleshop/categories/create', lang('simpleshop.create_category_nowcreate_category_now')); ?></p>
            <?php endif; ?>

            <ul>
            <?php
            foreach ($root_categories as $root_category) {
                $category_tree = $nsm->fetchTreeAsArray($root_category->getId());

                foreach ($category_tree as $node_wrapper) {
                    $selected = '';
                    $node = $node_wrapper->getNode();
                    $default_selected = $product->getCategories()->contains($node) || $viewing_category == $node;

                    $data = array(
                        'type' => 'checkbox',
                        'name' => "categories[{$node->getId()}]",
                        'id' => "category-{$node->getId()}",
                        'selected' => "selected"
                    );

                    echo '<li style="padding-left: ' . $node_wrapper->getLevel() * 20 . 'px;">';
                    echo form_input($data, $node->getId(), set_checkbox("categories[{$node->getId()}]", $node->getId(), $default_selected));
                    echo form_label($node->getTitle(), "category-{$node->getId()}");
                    echo '</li>';
                }
            }
            ?>
            </ul>
        </li>
    </ul>
</div>

<div class="buttons float-right padding-top" style="clear: both;">
    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
</div>

<?php echo form_close(); ?>

</section>
