// add meta box for image upload using WordPress media uploader
jQuery(function($){
    /*
     * Select/Upload image(s) event
     */
    $('body').on('click', '.misha_upload_image_button', function(e){
        e.preventDefault();

            var button = $(this),
                custom_uploader = wp.media({
            title: 'Insert image',
            library : {
                // uncomment the next line if you want to attach image to the current post
                // uploadedTo : wp.media.view.settings.post.id, 
                type : 'image'
            },
            button: {
                text: 'Use this image' // button label text
            },
            multiple: false // for multiple image selection set to true
        }).on('select', function() { // it also has "open" and "close" events 
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:95%;display:block;" />').next().val(attachment.id).next().show();
            /* if you sen multiple to true, here is some code for getting the image IDs
            var attachments = frame.state().get('selection'),
                attachment_ids = new Array(),
                i = 0;
            attachments.each(function(attachment) {
                attachment_ids[i] = attachment['id'];
                console.log( attachment );
                i++;
            });
            */
        })
        .open();
    });

    /*
     * Remove image event
     */
    $('body').on('click', '.misha_remove_image_button', function(){
        $(this).hide().prev().val('').prev().addClass('button').html('Upload image');
        return false;
    });

});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function misha_include_myuploadscript() {
    /*
     * I recommend to add additional conditions just to not to load the scipts on each page
     * like:
     * if ( !in_array('post-new.php','post.php') ) return;
     */
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }

    wp_enqueue_script( 'myuploadscript', get_stylesheet_directory_uri() . '/customscript.js', array('jquery'), null, false );
}

add_action( 'admin_enqueue_scripts', 'misha_include_myuploadscript' );

function misha_image_uploader_field( $name, $value = '') {
    $image = ' button">Upload image';
    $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
    $display = 'none'; // display state ot the "Remove image" button

    if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {

        // $image_attributes[0] - image URL
        // $image_attributes[1] - image width
        // $image_attributes[2] - image height

        $image = '"><img src="' . $image_attributes[0] . '" style="max-width:95%;display:block;" />';
        $display = 'inline-block';

    } 

    return '
    <div>
        <a href="#" class="misha_upload_image_button' . $image . '</a>
        <input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
        <a href="#" class="misha_remove_image_button" style="display:inline-block;display:' . $display . '">Remove image</a>
    </div>';
}

/*
 * Add a meta box
 */
add_action( 'admin_menu', 'misha_meta_box_add' );

function misha_meta_box_add() {
    add_meta_box('mishadiv', // meta box ID
        'More settings', // meta box title
        'misha_print_box', // callback function that prints the meta box HTML 
        'post', // post type where to add it
        'normal', // priority
        'high' ); // position
}

/*
 * Meta Box HTML
 */
function misha_print_box( $post ) {
    $meta_key = 'second_featured_img';
    echo misha_image_uploader_field( $meta_key, get_post_meta($post->ID, $meta_key, true) );
}

/*
 * Save Meta Box data
 */
add_action('save_post', 'misha_save');

function misha_save( $post_id ) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
        return $post_id;

    $meta_key = 'second_featured_img';

    update_post_meta( $post_id, $meta_key, $_POST[$meta_key] );

    // if you would like to attach the uploaded image to this post, uncomment the line:
    // wp_update_post( array( 'ID' => $_POST[$meta_key], 'post_parent' => $post_id ) );

    return $post_id;
}
