<?php/** * Main admin class * * @author Your Inspiration Themes * @package YITH Footer Banner * @version 1.0.3 */if ( !defined( 'YITH_FBANNER' ) ) { exit; } // Exit if accessed directlyglobal $yith_fbanner_options;$yith_fbanner_options = array(    //tab general    'general' => array(        'label' => __('General', 'yit'),        'sections' => array(            'general' => array(                'title' =>  __('General Settings', 'yit'),                'description' => '',                'fields' => array(                    'yith_fbanner_enable' => array(                        'title' => __('Enable Footer Banner', 'yit'),                        'description' => __( 'Enable the footer banner. (Default: Off)', 'yit' ),                        'type' => 'checkbox',                        'std' => false                    ),                    'yith_fbanner_image' => array(                        'title' => 'Logo',                        'description' => __( 'If you want, you can set here a logo image to show on the left side.', 'yit' ),                        'type' => 'upload',                        'std' => YITH_FBANNER_URL . 'assets/images/iconposta.png'                    ),                    'yith_fbanner_message' => array(                        'title' => __('Title', 'yit'),                        'description' => __( 'The title displayed. You can also use HTML code.', 'yit' ),                        'type' => 'text',                        'std' => __( 'Join our community', 'yit' )                    ),                    'yith_fbanner_sub_message' => array(                        'title' => __('Subtitle', 'yit'),                        'description' => __( 'The message displayed. You can also use HTML code.', 'yit' ),                        'type' => 'text',                        'std' => __( "Simply insert your email address here to be notified", 'yit' )                    ),                    'yith_fbanner_link' => array(                        'title' => __('Link', 'yit'),                        'description' => __( 'Would you like to wrap logo, title and subtitle in a link? Write it here.', 'yit' ),                        'type' => 'text',                        'std' => __( "http://yithemes.com/?ap_id=yith-fbanner", 'yit' )                    ),                    'yith_fbanner_hide_message' => array(                        'title' => __('Hide button', 'yit'),                        'description' => __( 'The text displayed as hiding button.', 'yit' ),                        'type' => 'text',                        'std' => __( "Hide", 'yit' )                    ),                    'yith_fbanner_hide_forever_message' => array(                        'title' => __('Hide forever button', 'yit'),                        'description' => __( 'The text displayed as hide forever button.', 'yit' ),                        'type' => 'text',                        'std' => __( "Hide forever", 'yit' )                    ),                    'yith_fbanner_custom_style' => array(                        'title' => 'Custom style',                        'description' => __( 'Insert here your custom CSS style.', 'yit' ),                        'type' => 'textarea',                        'std' => ''                    ),                )            ),            'typography' => array(                'title' =>  __('Typography', 'yit'),                'description' => '',                'fields' => array(                    'yith_fbanner_title_font' => array(                        'title' =>  __('Title font of message', 'yit'),                        'description' => __('Choose the font type, size and color for the titles inside the message text.', 'yit'),                        'type' => 'typography',                        'std' => array(                            'size' => 25,                            'unit' => 'px',                            'family' => 'Roboto',                            'style' => 'bold',                            'color' => '#FFFFFF',                        ),                    ),                    'yith_fbanner_paragraph_font' => array(                        'title' =>  __('Paragraph font of message', 'yit'),                        'description' => __('Choose the font type, size and color for the paragraphs inside the message text.', 'yit'),                        'type' => 'typography',                        'std' => array(                            'size' => 12,                            'unit' => 'px',                            'family' => 'Roboto',                            'style' => 'regular',                            'color' => '#FFFFFF',                        ),                    ),                    'yith_fbanner_hide_font' => array(                        'title' =>  __('Hiding buttons fonts', 'yit'),                        'description' => __('Choose the font type, size and color for the footer banner hiding buttons.', 'yit'),                        'type' => 'typography',                        'std' => array(                            'size' => 10,                            'unit' => 'px',                            'family' => 'Roboto',                            'style' => 'regular',                            'color' => '#FFFFFF',                        ),                    )                )            ),        )    ),    //tab background    'background' => array(        'label' => __('Background', 'yit'),        'sections' => array(            'background' => array(                'title' =>  __('Background Settings', 'yit'),                'description' => __('Customize the background of footer banner', 'yit'),                'fields' => array(                    'yith_fbanner_background_image' => array(                        'title' =>  __('Background image', 'yit'),                        'description' => __("Upload or choose from your media library the background image, if you don't need it anymore simply delete it.", 'yit'),                        'type' => 'upload',                        'std' => YITH_FBANNER_URL . 'assets/images/pattern.png',                    ),                    'yith_fbanner_background_color' => array(                        'title' =>  __('Background Color', 'yit'),                        'description' => __('Choose a background color', 'yit'),                        'type' => 'colorpicker',                        'std' => '#0c445b',                    ),                    'yith_fbanner_background_border' => array(                        'title' =>  __('Customize the border', 'yit'),                        'description' => __("Choose border's color.", 'yit'),                        'type' => 'colorpicker',                        'std' => '#01313b',                    ),                    'yith_fbanner_background_repeat' => array(                        'title' =>  __('Background Repeat', 'yit'),                        'description' => __( 'Select the repeat mode for the background image.', 'yit' ),                        'type' => 'select',                        'std' => apply_filters( 'yith_fbanner_background_repeat_std', 'repeat' ),                        'options' => array(                            'repeat' => __( 'Repeat', 'yit' ),                            'repeat-x' => __( 'Repeat Horizontally', 'yit' ),                            'repeat-y' => __( 'Repeat Vertically', 'yit' ),                            'no-repeat' => __( 'No Repeat', 'yit' ),                        )                    ),                    'yith_fbanner_background_position' => array(                        'title' =>  __('Background Position', 'yit'),                        'description' =>  __( 'Select the position for the background image.', 'yit' ),                        'type' => 'select',                        'options' => array(                            'center' => __( 'Center', 'yit' ),                            'top left' => __( 'Top left', 'yit' ),                            'top center' => __( 'Top center', 'yit' ),                            'top right' => __( 'Top right', 'yit' ),                            'bottom left' => __( 'Bottom left', 'yit' ),                            'bottom center' => __( 'Bottom center', 'yit' ),                            'bottom right' => __( 'Bottom right', 'yit' ),                        ),                        'std' => apply_filters( 'yith_fbanner_background_position_std', 'top left' )                    ),                    'yith_fbanner_background_attachment' => array(                        'title' =>  __('Background Attachment', 'yit'),                        'description' => __( 'Select the attachment for the background image.', 'yit' ),                        'type' => 'select',                        'options' => array(                            'scroll' => __( 'Scroll', 'yit' ),                            'fixed' => __( 'Fixed', 'yit' ),                        ),                        'std' => apply_filters( 'yith_fbanner_background_attachment_std', 'scroll' )                    )                )            )        )    ),    //tab container    'newsletter' => array(        'label' => __('Newsletter', 'yit'),        'sections' => array(            'newsletter' => array(                'title' =>  __('Newsletter', 'yit'),                'description' => __('Add a newsletter form in your footer banner.', 'yit'),                'fields' => array(                    'yith_fbanner_enable_newsletter_form' => array(                        'title' =>  __('Enable Newsletter form', 'yit'),                        'description' => __('Choose if you want to enable the newsletter form in the footer banner.', 'yit'),                        'type' => 'checkbox',                        'std' => true                    ),                    'yith_fbanner_newsletter_top_text' => array(                        'title' =>  __('Top Text', 'yit'),                        'description' => __('Write here a text to be shown over the newsletter fields.', 'yit'),                        'type' => 'text',                        'std' => 'Fill the forms to signup'                    ),                    'yith_fbanner_newsletter_top_text_font' => array(                        'title' =>  __('Top Text Font', 'yit'),                        'description' => __('Choose the font type, size and color for the text font.', 'yit'),                        'type' => 'typography',                        'std' => array(                            'size' => 10,                            'unit' => 'px',                            'family' => 'Roboto',                            'style' => 'bold',                            'color' => '#ffffff',                        ),                    ),                    'yith_fbanner_newsletter_submit_font' => array(                        'title' =>  __('Newsletter Submit Font', 'yit'),                        'description' => __('Choose the font type, size and color for the email submit button.', 'yit'),                        'type' => 'typography',                        'std' => array(                            'size' => 10,                            'unit' => 'px',                            'family' => 'Roboto',                            'style' => 'bold',                            'color' => '#ffffff',                        ),                    ),                    'yith_fbanner_newsletter_email_font' => array(                        'title' =>  __('Newsletter Name and Email Inputs Font', 'yit'),                        'description' => __('Choose the font type, size and color for the name and email inputs field.', 'yit'),                        'type' => 'typography',                        'std' => array(                            'size' => 10,                            'unit' => 'px',                            'family' => 'Roboto',                            'style' => 'regular',                            'color' => '#8f8f8f',                        ),                    ),                    'yith_fbanner_newsletter_submit_background' => array(                        'title' =>  __('Newsletter submit background', 'yit'),                        'description' => __('The submit button background.', 'yit'),                        'type' => 'colorpicker',                        'std' => '#ff9c00',                    ),                    'yith_fbanner_newsletter_submit_background_hover' => array(                        'title' =>  __('Newsletter submit hover background', 'yit'),                        'description' => __('The submit button hover background.', 'yit'),                        'type' => 'colorpicker',                        'std' => '#f7b957',                    )                )            ),           'newsletter_configuration' => array(                'title' =>  __('Form configuration', 'yit'),                'description' => __('Configure the form and each field, to integrate the newsletter features of an external service.', 'yit'),                'fields' => array(                    'yith_fbanner_newsletter_action' => array(                        'title' =>  __('Action URL', 'yit'),                        'description' => __('Set the action url of the form.', 'yit'),                        'type' => 'text',                        'std' => ''                    ),                    'yith_fbanner_newsletter_method' => array(                        'title' =>  __('Form method', 'yit'),                        'description' => __('Set the method for the form request.', 'yit'),                        'type' => 'select',                        'options' => array(                            'POST' => 'POST',                            'GET'  => 'GET',                        ),                        'std' => 'POST'                    ),                    'yith_fbanner_newsletter_name_label' => array(                        'title' =>  __('"Name" field label', 'yit'),                        'description' => __('The label for the name field, if it is empty no name field will be printed', 'yit'),                        'type' => 'text',                        'std' => 'Name',                    ),                    'yith_fbanner_newsletter_name_name' => array(                        'title' =>  __('"Name" field name', 'yit'),                        'description' => __('The "name" attribute for the name field', 'yit'),                        'type' => 'text',                        'std' => 'name',                    ),                    'yith_fbanner_newsletter_email_label' => array(                        'title' =>  __('"Email" field label', 'yit'),                        'description' => __('The label for the email field', 'yit'),                        'type' => 'text',                        'std' => 'Email',                    ),                    'yith_fbanner_newsletter_email_name' => array(                        'title' =>  __('"Email" field name', 'yit'),                        'description' => __('The "name" attribute for the email field', 'yit'),                        'type' => 'text',                        'std' => 'email',                    ),                    'yith_fbanner_newsletter_submit_label' => array(                        'title' =>  __('Submit button label', 'yit'),                        'description' => __('The label for the submit button', 'yit'),                        'type' => 'text',                        'std' => __( 'SUBSCRIBE', 'yit' ),                    ),                    'yith_fbanner_newsletter_hidden_fields' => array(                        'title' =>  __('Newsletter Hidden fields', 'yit'),                        'description' => __('Set the hidden fields to include in the form. Use the form: field1=value1&field2=value2&field3=value3', 'yit'),                        'type' => 'text',                        'std' => '',                   )                )            )        )    ),);