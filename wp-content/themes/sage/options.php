<?php
add_action( 'admin_menu', function () {
    add_menu_page(
        'My Option 1 Settings',
        'My custom options settings',
        'administrator',
        'my_options_page',
        'options_settings_page'
    );

    add_action( 'admin_init', function () {
        register_setting( 'options-group', 'full_name' );
        register_setting( 'options-group', 'gender' );
        register_setting( 'options-group', 'photo' );
    } );
} );


function options_settings_page(): void {
    ?>
    <div class="wrap">
        <h1>Options Page Form</h1>
        <form method="post" enctype="multipart/form-data" >
            <?php settings_fields( 'options-group' );
            do_settings_sections( 'options-group' ); ?>
            <input type="text" name="full_name" id="name"
                   value="<?php echo  get_option( 'full_name' ); ?>"/>
            <input type="hidden" name="uploaded" value="1"/>
            <label for="gender">Gender</label>
            <select name="gender" id="gender">
                <option value="male"
                    <?php echo  get_option( 'gender' )== 'male' ? 'selected' : '' ?>>
                    Male</option>
                <option value="female"
                    <?php echo get_option( 'gender' )  == 'female' ? 'selected' : '' ?>>
                    Female</option>
                <option value="no"
                    <?php echo  get_option( 'gender' )  == 'no' ? 'selected' : '' ?>>
                    Prefer not to state</option>
            </select>

            <label for="photo">Upload Photo</label>
            <input type="file" id="photo" name="photo">

            <img src="<?php echo get_option( 'photo' ) ?>" alt="upload_to_see"
                 style="max-width: 50%">
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

add_action( 'init', function () {
    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }
    if ( isset( $_POST['uploaded'] ) ) {
        $file = wp_handle_upload( $_FILES['photo'], [ 'test_form' => false ] );
        update_option( 'photo', $file['url'] );
        update_option('full_name', $_POST['full_name']);
        update_option('gender', $_POST['gender']);
    }
} )


?>
