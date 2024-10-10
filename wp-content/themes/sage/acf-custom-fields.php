<?php
add_action( 'acf/init', function () {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }
    acf_add_local_field_group( array(
        'key'      => 'group_custom_post_type_1',
        'title'    => 'Custom Fields for CPT 1',
        'fields'   => array(
            array(
                'key'   => 'text_for_custom_type1',
                'label' => 'Custom Text Field',
                'name'  => 'custom_text_field',
                'type'  => 'text',
            ),
            array(
                'key'       => 'field_relation_cpt1',
                'label'     => 'Related CPT 2',
                'name'      => 'related_cpt2',
                'type'      => 'relationship',
                'post_type' =>  'my-custom-type-2',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'my-custom-type-1',
                ),
            ),
        ),
    ) );

    acf_add_local_field_group( array(
        'key'      => 'group_custom_post_type_2',
        'title'    => 'Custom Fields for CPT 2',
        'fields'   => array(
            array(
                'key'     => 'field_select_cpt2',
                'label'   => 'Custom Select Field',
                'name'    => 'custom_select_field',
                'type'    => 'select',
                'choices' => array(
                    'type_1' => 'Type 1',
                    'type_2' => 'Type 2',
                    'type_3' => 'Type 3',
                ),
            ),
            array(
                'key'        => 'field_taxonomy_cpt2',
                'label'      => 'Related Taxonomy',
                'name'       => 'related_taxonomy',
                'type'       => 'taxonomy',
                'taxonomy'   => 'section',
                'field_type' => 'multi_select',
                'allow_null' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'my-custom-type-2',
                ),
            ),
        ),
    ) );

    acf_add_local_field_group( array(
        'key'      => 'group_taxonomy_fields',
        'title'    => 'Custom Fields for Taxonomy',
        'fields'   => array(
            array(
                'key'           => 'field_image_taxonomy',
                'label'         => 'Taxonomy Image',
                'name'          => 'taxonomy_image',
                'type'          => 'image',
                'instructions'  => 'Image width should be 48px, and height should be max 100px.',
                'return_format' => 'array',
                'min_width'     => 48,
                'max_height'    => 100,
            ),
            array(
                'key'   => 'field_toggle_taxonomy',
                'label' => 'Toggle Field',
                'name'  => 'toggle_field',
                'type'  => 'true_false',
                'ui'    => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'taxonomy',
                    'operator' => '==',
                    'value'    => 'section',
                ),
            ),
        ),
    ) );

} );
add_filter('acf/fields/relationship/query/key=field_relation_cpt1', function($args, $field, $post_id) {
    $args['meta_query'] = [
        [
            'key'     => 'custom_select_field',
            'value'   => 'type_2',
            'compare' => '=='
        ]
    ];
    return $args;
}, 10, 3);

add_filter('acf/fields/relationship/result/key=field_relation_cpt1', function($title, $post, $field, $post_id) {
    return $title . ' (' . $post->ID . ')';
}, 10, 4);
