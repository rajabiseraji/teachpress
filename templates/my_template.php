<?php

/**
 * teachPress template file
 * @package teachpress\core\templates
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 * @since 6.0.0
 */

class My_Template implements TP_Publication_Template
{
    /**
     * Returns the settings of the template
     * @return array
     */
    public function get_settings()
    {
        return array(
            'name'                => 'TECI',
            'description'         => 'A new mobile friendly 4 line style template for publication lists.',
            'author'              => 'Moh Rajabi Seraji',
            'author_separator'    => ',',
            'version'             => '1.0',
            'link_style'          => 'direct',
            'button_separator'    => ' | ',
            'menu_label_tags'     => __('Tags') . ': ',
            'menu_label_links'    => __('Links', 'teachpress') . ': ',
            'meta_label_in'       => __('In', 'teachpress') . ' ',
            'citation_style'      => 'teachPress',
        );
    }

    /**
     * Returns the body element for a publication list
     * @param string $content   The content of the publication list itself
     * @param array $args       An array with some basic settings for the publication list 
     * @return string
     */
    public function get_body($content, $args = array())
    {
        return '<div class="teachpress_publication_list">' . $content . '</div>';
    }

    /**
     * Returns the headline for a publication list or a part of that
     * @param type $content     The content of the headline
     * @param type $args        An array with some basic settings for the publication list (source: shortcode settings)
     * @return string
     */
    public function get_headline($content, $args = array())
    {
        return '<h3 class="tp_h3" id="tp_h3_' . esc_attr($content) . '">' . $content . '</h3>';
    }

    /**
     * Returns the headline (second level) for a publication list or a part of that
     * @param string $content     The content of the headline
     * @param array $args         An array with some basic settings for the publication list (source: shortcode settings)
     * @return string
     */
    public function get_headline_sl($content, $args = array())
    {
        return '<h4 class="tp_h4" id="tp_h4_' . esc_attr($content) . '">' . $content . '</h4>';
    }

    /**
     * Returns the container for publication images
     * @param string $content               The image element
     * @param string $position              The image position: left, right or buttom
     * @param string $optional_attributes   Optional attributes for the framing container element
     * @return string
     */
    public function get_image($content, $position, $optional_attributes = '')
    {
        return '<div class="tp_pub_image_' . $position . '">' . $content . '</div>';
    }

    /**
     * Returns the single entry of a publication list
     * 
     * Contents of the interface data array (available over $interface->get_data()):
     *   'row'               => An array of the related publication data
     *   'title'             => The title of the publication (completely prepared for HTML output)
     *   'images'            => The images array (HTML code for left, bottom, right)
     *   'tag_line'          => The HTML tag string
     *   'settings'          => The settings array (shortcode options)
     *   'counter'           => The publication counter (integer)
     *   'all_authors'       => The prepared author string
     *   'keywords'          => An array of related keywords
     *   'container_id'      => The ID of the HTML container
     *   'template_settings' => The template settings array (name, description, author, citation_style)
     * 
     * @param object $interface     The interface object
     * @return string
     */
    public function get_entry($interface)
    {
        $real_type = $interface->get_type();
        if($real_type === 'Inproceedings' || str_contains($real_type, 'Inproceedings'))
            $real_type = str_replace('Inproceedings', 'Conference Proceedings', $real_type);

        $class = ' tp_publication_' . $interface->get_type('');
        $s = '<div class="tp_publication' . $class . '">';
        $s .= $interface->get_number('<div class="tp_pub_number">', '.</div>');
        $s .= $interface->get_images('left');
        $s .= '<div class="tp_pub_info">';
        $s .= $interface->get_author('<span class="tp_pub_author">', '. </span>');
        $s .= '<span class="tp_pub_year">'. $interface->get_year() . '. </span>';
        $s .= '<span class="tp_pub_title">' . $interface->get_title() . ' ' . $real_type . ' ' . $interface->get_label('status', array('forthcoming')) . '. </span>';
        $s .= '<span class="tp_pub_additional">' . $interface->get_meta() . '</span>';
        $s .= '<div class="tp_pub_menu">' . $interface->get_menu_line() . '</div>';
        $s .= $interface->get_infocontainer();
        $s .= $interface->get_images('bottom');
        $s .= '</div>';
        $s .= $interface->get_images('right');
        $s .= '</div>';
        return $s;
    }
}
