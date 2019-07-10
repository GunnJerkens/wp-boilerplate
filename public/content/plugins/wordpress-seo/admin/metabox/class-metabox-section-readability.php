<?php
/**
 * WPSEO plugin file.
 *
 * @package WPSEO\Admin
 */

/**
 * Generates and displays the React root element for a metabox section.
 */
class WPSEO_Metabox_Section_Readability implements WPSEO_Metabox_Section {
	/**
	 * Name of the section, used as an identifier in the HTML.
	 *
	 * @var string
	 */
	public $name = 'readability';

	/**
	 * Outputs the section link.
	 */
	public function display_link() {
		printf(
			'<li role="tab"><a href="#wpseo-meta-section-%1$s" class="wpseo-meta-section-link">%2$s</a></li>',
			esc_attr( $this->name ),
			'<div class="wpseo-score-icon-container" id="wpseo-readability-score-icon"></div><span>' . __( 'Readability', 'wordpress-seo' ) . '</span>'
		);
	}

	/**
	 * Outputs the section content.
	 */
	public function display_content() {
		$html  = sprintf( '<div id="%1$s" class="wpseo-meta-section">', esc_attr( 'wpseo-meta-section-' . $this->name ) );
		$html .= '<div id="wpseo-metabox-readability-root" class="wpseo-metabox-root"></div>';
		$html .= '</div>';

		echo $html;
	}
}
