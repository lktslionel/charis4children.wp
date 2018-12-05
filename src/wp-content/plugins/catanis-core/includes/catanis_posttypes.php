<?php
/************************************************
*  	1. POST TYPE - PORTFOLIO
*	2. POST TYPE - TEAMS
*	3. POST TYPE - TESTIMONIALS
************************************************/

/*============================================================================================*/
/*=== 1. POST TYPE - PORTFOLIO ===============================================================*/ 
class Catanis_Posttype_Portfolio{
	
	public static $_key_save_custom = 'cata_custom_port_term';
	var $_default_data = array();
	
	public function __construct(){
		$this->init();
	}
	
	private function init(){
	
		add_action( 'init', array( $this, 'register_post_type'), 5 );
		
		if ( is_admin() ) {
			add_action( 'admin_head', array( $this, 'add_custom_css' ) );
			
			add_filter( 'manage_edit-portfolio_columns', array( $this, 'custom_columns' ) );
			add_action( 'manage_posts_custom_column', array( $this, 'content_columns' ), 10, 2 );
			add_filter( 'manage_edit-portfolio_sortable_columns', array( $this, 'sortable_columns' ) );
		}
		
		/*Custom fields for category*/
		add_action( 'admin_enqueue_scripts', array( $this, 'load_custom_wp_admin_style' ), 30 );
		add_action( 'portfolio_category_add_form_fields', array( $this, 'add_form_fields' ), 20 );
		add_action( 'portfolio_category_edit_form_fields', array( $this, 'edit_form_fields' ), 10, 2 );
		add_action( 'edited_portfolio_category', array( $this, 'save_data' ), 10, 2 );
		add_action( 'created_portfolio_category', array( $this, 'save_data' ), 10, 2 );
		add_action( 'delete_portfolio_category', array( $this, 'delete_data' ), 10, 1 );
			
		$this->_default_data = array(
			'layout' 			=> 'default',
			'sidebar' 			=> 'sidebar-primary',
			'header_overlap' 	=> 'true',
			'breadcrumb_bg' 	=> '',
		);
	}
	
	/*=== Func: Get key save ===*/
	static public function get_key_save() {
		return self::$_key_save_custom;
	}
	
	/*=== Enqueue script style ===*/
	public function load_custom_wp_admin_style() {
		wp_enqueue_media();
		if( !wp_script_is('catanis-metabox-script-main')) {
			wp_register_script( 'catanis-metabox-script-main', CATANIS_FRAMEWORK_URL . 'js/cata-metabox.js', array(), '1.0', true );
			wp_enqueue_script( 'catanis-metabox-script-main');
		} 
	}
	
	/*Register post type & taxonomy*/
	public function register_post_type() {
		$labels = array(
			'name' 					=> esc_html_x( 'Portfolio', 'portfolio type general name', 'catanis-core' ),
			'singular_name' 		=> esc_html_x( 'Portfolio Item', 'portfolio type singular name', 'catanis-core' ),
			'add_new' 				=> esc_html_x( 'Add New', 'portfolio', 'catanis-core' ),
			'add_new_item' 			=> esc_html__( 'Add New Item', 'catanis-core' ),
			'edit_item' 			=> esc_html__( 'Edit Item', 'catanis-core' ),
			'new_item' 				=> esc_html__( 'New Portfolio Item', 'catanis-core' ),
			'view_item' 			=> esc_html__( 'View Item', 'catanis-core' ),
			'search_items' 			=> esc_html__( 'Search Portfolio Items', 'catanis-core' ),
			'not_found' 			=> esc_html__( 'No portfolio items found', 'catanis-core' ),
			'not_found_in_trash' 	=> esc_html__( 'No portfolio items found in Trash', 'catanis-core' ),
			'parent_item_colon' 	=> ''
		);
		
		register_post_type(
			'portfolio',
			array(
				'labels' 			=> $labels,
				'singular_label' 	=> esc_html__( 'Portfolio', 'catanis-core' ),
				'public' 			=> true,
				'show_ui' 			=> true,
				'capability_type' 	=> 'post',
				'hierarchical' 		=> false,
				'show_in_menu' 		=> true,
				'show_in_nav_menus' => true,
				'publicly_queryable' => true,
				'exclude_from_search' => false,
				'has_archive' 		=> true,
				'query_var' 		=> true,
				'can_export' 		=> true,
				'menu_icon'			=> 'dashicons-screenoptions',
				'rewrite' 			=> array( 'slug' => 'portfolio', 'with_front' =>  false ),
				'taxonomies' 		=> array( 'portfolio_category' ),
				'supports' 			=> array( 'title', 'editor', 'thumbnail', 'comments', 'page-attributes' )
			)
		);

		$labels = array(
			'name' 			=> esc_html__( 'Portfolio Categories', 'catanis-core'),
			'singular_name' => esc_html__( 'Portfolio Category', 'catanis-core'),
			'search_items' 	=> esc_html__( 'Search Portfolio Categories', 'catanis-core'),
			'all_items' 	=> esc_html__( 'All Portfolio Categories', 'catanis-core'),
			'parent_item' 	=> esc_html__( 'Parent Portfolio Category', 'catanis-core'),
			'edit_item' 	=> esc_html__( 'Edit Portfolio Category', 'catanis-core'),
			'update_item' 	=> esc_html__( 'Update Portfolio Category', 'catanis-core'),
			'add_new_item'	=> esc_html__( 'Add New Portfolio Category', 'catanis-core'),
			'new_item_name' => esc_html__( 'New Portfolio Category', 'catanis-core'),
			'menu_name' 	=> esc_html__( 'Portfolio Categories', 'catanis-core')
		);
		register_taxonomy(
			'portfolio_category',
			array( 'portfolio' ),
			array(
				'label' 			=> esc_html__( 'Portfolio Categories', 'catanis-core' ),
				'singular_label' 	=> esc_html__( 'Portfolio Category', 'catanis-core' ),
				'labels' 			=> $labels,
				'hierarchical' 		=> true,
				'rewrite' 			=> true,
				'query_var' 		=> true,
				'has_archive' 		=> true,				
				'rewrite' => array( 'slug' => 'portfolio-category' )
			)
		);
		
		$labels = array(
			'name' 			=> esc_html__( 'Portfolio Tags', 'catanis-core'),
			'singular_name' => esc_html__( 'Portfolio Tag', 'catanis-core'),
			'search_items' 	=> esc_html__( 'Search Portfolio Tags', 'catanis-core'),
			'all_items' 	=> esc_html__( 'All Portfolio Tags', 'catanis-core'),
			'parent_item' 	=> esc_html__( 'Parent Portfolio Tag', 'catanis-core'),
			'edit_item' 	=> esc_html__( 'Edit Portfolio Tag', 'catanis-core'),
			'update_item' 	=> esc_html__( 'Update Portfolio Tag', 'catanis-core'),
			'add_new_item'	=> esc_html__( 'Add New Portfolio Tag', 'catanis-core'),
			'new_item_name' => esc_html__( 'New Portfolio Tag', 'catanis-core'),
			'menu_name' 	=> esc_html__( 'Portfolio Tags', 'catanis-core')
		);
		register_taxonomy(
			'portfolio_tags',
			array( 'portfolio' ),
			array(
			'label' 			=> esc_html__( 'Portfolio Tags', 'catanis-core' ),
			'singular_label' 	=> esc_html__( 'Portfolio Tag', 'catanis-core' ),
				'labels' 			=> $labels,
				'hierarchical' 		=> true,
				'rewrite' 			=> true,
				'query_var' 		=> true,
				'has_archive' 		=> true,
				'rewrite' => array( 'slug' => 'portfolio-tags' )
			)
		);
		
	}
	
	/*Custom  columns for list*/
	function custom_columns( $columns ) {
		$columns['ztype'] 		= esc_html__( 'Type', 'catanis-core' );
		$columns['zcategory'] 	= esc_html__( 'Portfolio Category', 'catanis-core' );
		$columns['zimage'] 		= esc_html__( 'Featured Image', 'catanis-core' );
	
		return $columns;
	}
	
	/*Content  columns for list*/
	function content_columns( $column_name, $post_ID ) {
		$data = (array) get_post_meta( $post_ID, 'meta_catanis_opts', true );
		switch ($column_name) {
			case 'zcategory':
				$cats = get_the_term_list( $post_ID, 'portfolio_category', '', ', ', '' );
				echo $cats;
				break;
				
			case 'ztype':
				echo $this->getPortType( @$data['port_type'] );
				break;
	
			case 'zimage':
				if ( ! empty( $data['portfolio_custom_thumbnail'] ) ) {
					echo '<img src="' . @$data['portfolio_custom_thumbnail'] . '" style="width:80px"/>';
				} else {
					$post_featured_image = Catanis_Core_Plugin::cata_get_featured_image( $post_ID );
					if ( $post_featured_image ) {
						echo '<img src="' . $post_featured_image . '" style="width:80px"/>';
					}
				}
				
				break;
				
			default:
				break;
		} 
	}
	
	/*Sort  columns data*/
	function sortable_columns( $columns ) {
	
		$columns['zimage'] 		= 'zimage';
		$columns['ztype'] 		= 'ztype';
		$columns['zcategory'] 	= 'zcategory';
	
		return $columns;
	}
	
	/*Add css for custom columns*/
	function add_custom_css() {
		echo '<style>
   				.widefat th.sortable.column-ztype,  .widefat th.sorted.column-ztype{width:150px}
   				.widefat th.sortable.column-zcategory,  .widefat th.sorted.column-zcategory{width:180px}
				.widefat th.sortable.column-zimage, .widefat th.sorted.column-zimage{width:140px}
  			</style>';
	}

	/*Get PostType By ID*/
	protected function getPortType( $id ) {
		$result 	= '';
		$arrType = array(
			array( 'id' => 'image', 'name' => 'Image' ),
			array( 'id' => 'slider', 'name' => 'Slider' ),
			array( 'id' => 'video', 'name' => 'Video' )
		);
		
		if (class_exists('Catanis_Default_Data')){
			$arrType = Catanis_Default_Data::metaOptions('portfolio-type');
		}
		
		foreach ( $arrType as $item ) {
			if ( $id == $item['id'] ) {
				$result = $item['name'];
				break;
			}
		}
			
		return $result;
	}

	/*=== Add fields for Portfolio Category in add layout ===*/
	public function add_form_fields(){
		
		$xhtml = '';
		$htmlObj =  new Catanis_Widget_Html();
	
		$inputID 	= 'layout';
		$inputValue = $this->_default_data[$inputID];
		$arr 		= array( 'class' =>'postform','id' => $inputID, 'style' =>'width:200px' );
		$opts 		= array( 'data' => $this->get_layout() );
		$xhtml 		.= $htmlObj->pt_generalItem_div(
				$htmlObj->labelTag( esc_html__('Category Layout', 'onelove' ), array( 'for' => $inputID ) ),
				$htmlObj->control( 'selectbox', $inputID, $inputValue, $arr, $opts )
		);
		
		$inputID 	= 'sidebar';
		$inputValue = $this->_default_data[$inputID];
		$arr 		= array( 'class' => 'postform', 'id' => $inputID, 'style' => 'width:200px' );
		$opts 		= array( 'data' => $this->get_sidebar() );
		$xhtml 		.= $htmlObj->pt_generalItem_div(
				$htmlObj->labelTag( esc_html__( 'Category Sidebar', 'onelove' ), array( 'for' => $inputID ) ),
				$htmlObj->control( 'selectbox', $inputID, $inputValue, $arr, $opts )
		);
		
		$inputID 	= 'header_overlap';
		$inputValue = $this->_default_data[$inputID];
		$arr 		= array( 'class' => 'postform', 'id' => $inputID, 'style' => 'width:200px' );
		$opts 		= array( 'data' => array('default' => esc_html__('Default', 'onelove'), 'true' => esc_html__('Yes', 'onelove'), 'false' => esc_html__('No', 'onelove') ));
		$xhtml 		.= $htmlObj->pt_generalItem_div(
				$htmlObj->labelTag( esc_html__( 'Header Integration (will be overlap into page title)', 'onelove' ), array( 'for' => $inputID ) ),
				$htmlObj->control( 'selectbox', $inputID, $inputValue, $arr, $opts )
		);
		
		$inputID 	= 'breadcrumb_bg';
		$xhtml 		.= $htmlObj->pt_generalItem_div(
				$htmlObj->labelTag( esc_html__('Page Title Background', 'onelove' ), array( 'for' => $inputID , 'style' => 'margin-bottom: 10px;' ) ),
				$htmlObj->taxonomy_upload_thumbnail()
		);
		
		echo $xhtml;
	}
	
	/*=== Add fields for Portfolio Category in edit layout ===*/
	public function edit_form_fields( $term, $taxonomy ) {
		
		$xhtml = '';
		$htmlObj =  new Catanis_Widget_Html();
		
		/*Get data for display*/
		$option = get_option( self::$_key_save_custom );
		$image 	= CATANIS_FRONT_IMAGES_URL . 'placeholder.png';
		$thumbnail_id = 0;
		if( isset ($option[ $term->term_id ]['breadcrumb_id']) ){
				
			$thumbnail_id = $option[ $term->term_id ]['breadcrumb_id'];
			if ( $thumbnail_id ) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			}
		}
			
		$inputID 	= 'layout';
		$inputValue = $option[ $term->term_id ][$inputID];
		$arr 		= array( 'class' => 'postform', 'id' => $inputID, 'style' => 'width:200px' );
		$opts 		= array( 'data' => $this->get_layout());
		$xhtml 		.= $htmlObj->pt_generalItem_tr(
				$htmlObj->labelTag( esc_html__( 'Category Layout', 'catanis-core' ), array( 'for' => $inputID ) ),
				$htmlObj->control( 'selectbox', $inputID, $inputValue, $arr, $opts )
		);
			
		$inputID 	= 'sidebar';
		$inputValue = $option[ $term->term_id ][$inputID];
		$arr 		= array( 'class' => 'postform', 'id' => $inputID, 'style' => 'width:200px' );
		$opts 		= array( 'data' => $this->get_sidebar() );
		$xhtml 		.= $htmlObj->pt_generalItem_tr(
				$htmlObj->labelTag( esc_html__('Category Sidebar', 'catanis-core' ), array( 'for' => $inputID ) ),
				$htmlObj->control( 'selectbox', $inputID, $inputValue, $arr, $opts )
		);
			
		$inputID 	= 'header_overlap';
		$inputValue = $option[ $term->term_id ][$inputID];
		$arr 		= array( 'class' => 'postform', 'id' => $inputID, 'style' => 'width:200px' );
		$opts 		= array( 'data' => array('default' => esc_html__('Default', 'onelove'), 'true' => esc_html__('Yes', 'onelove'), 'false' => esc_html__('No', 'onelove') ));
		$xhtml 		.= $htmlObj->pt_generalItem_tr(
				$htmlObj->labelTag( esc_html__( 'Header Integration (will be overlap into page title)', 'onelove' ), array( 'for' => $inputID ) ),
				$htmlObj->control( 'selectbox', $inputID, $inputValue, $arr, $opts )
		);
		
		$inputID 	= 'breadcrumb_bg';
		$xhtml 		.= $htmlObj->pt_generalItem_tr(
				$htmlObj->labelTag( esc_html__('Page Title Background', 'onelove' ), array( 'for' => $inputID , 'style' => 'margin-bottom: 10px;' ) ),
				$htmlObj->taxonomy_upload_thumbnail( trim($image), $thumbnail_id )
		);
			
		echo $xhtml;
	}
	
	/*=== Save data for custom term ===*/
	public function save_data( $term_id, $tt_id ) {
	
		if ( isset( $_POST['_inline_edit'] ) ) {
			return $term_id;
		}
			
		$option = get_option( self::$_key_save_custom );
		$option[ $term_id ]['layout'] = isset( $_POST['layout'] ) ? wp_kses_data( $_POST['layout'] ) : $this->_default_data['layout'];
		$option[ $term_id ]['sidebar'] = isset( $_POST['sidebar'] ) ? wp_kses_data( $_POST['sidebar'] ) : $this->_default_data['sidebar'];
		$option[ $term_id ]['header_overlap'] = isset ( $_POST['header_overlap']) ? esc_html($_POST['header_overlap']) : $this->_default_data['header_overlap'];
		$option[ $term_id ]['breadcrumb_id'] = isset ( $_POST['category_thumbnail_id']) ? absint( $_POST['category_thumbnail_id'] ) : 0;
		update_option( self::$_key_save_custom, $option );
	}
	
	/*=== Delete data for custom term ===*/
	public function delete_data( $term_id ) {
		$option = get_option( self::$_key_save_custom );
		unset( $option[ $term->term_id ] );
		update_option( self::$_key_save_custom, $option );
	}
	
	private function get_layout() {
	
		return array(
			'default'	=> esc_html__( 'Default', 'onelove' ),
			'full' 		=> esc_html__( 'No sidebar (Full width)', 'onelove' ),
			'left' 		=> esc_html__( 'Left sidebar', 'onelove' ),
			'right'		=> esc_html__( 'Right sidebar', 'onelove' )
		);
	}
	
	private function get_sidebar(){
		$sidebars 	= catanis_get_content_sidebars( 'default' );
		$result 	= array();
		if ( sizeof( $sidebars ) ) {
			foreach ( $sidebars as $sb ) {
				$result[$sb['id']] = $sb['name'];
			}
		}
	
		return $result;
	}
	
}

new Catanis_Posttype_Portfolio();

/*============================================================================================*/
/*=== 2. POST TYPE - TEAM ====================================================================*/ 
class Catanis_Posttype_Team{
	
	public function __construct(){
		$this->init();
	}
	
	private function init(){
	
		add_action( 'init', array( $this, 'register_post_type' ), 10 );
		
		if ( is_admin() ) {
			add_action( 'admin_head', array( $this, 'add_custom_css' ) );
			
			add_filter( 'manage_edit-team_columns', array( $this, 'custom_columns' ) );
			add_action( 'manage_team_posts_custom_column', array( $this, 'content_columns' ), 10, 2 );
			add_filter( 'manage_edit-team_sortable_columns', array( $this, 'sortable_columns' ) );
		}
	}
	
	/*Register post type*/
	public function register_post_type(){
		$labels = array(
			'name' 					=> esc_html_x( 'Team', 'team type general name', 'catanis-core' ),
			'singular_name' 		=> esc_html_x( 'Team Item', 'team type singular name', 'catanis-core' ),
			'add_new' 				=> esc_html_x( 'Add New', 'team', 'catanis-core' ),
			'add_new_item' 			=> esc_html__( 'Add New Item', 'catanis-core' ),
			'edit_item' 			=> esc_html__( 'Edit Item', 'catanis-core' ),
			'new_item' 				=> esc_html__( 'New Team Item', 'catanis-core' ),
			'view_item' 			=> esc_html__( 'View Item', 'catanis-core' ),
			'search_items' 			=> esc_html__( 'Search Team Items', 'catanis-core' ),
			'not_found' 			=> esc_html__( 'No team items found', 'catanis-core' ),
			'not_found_in_trash' 	=> esc_html__( 'No team items found in Trash', 'catanis-core' ),
			'parent_item_colon' 	=> ''
		);
		
		register_post_type(
			'team',
			array(
				'labels' 			=> $labels,
				'singular_label' 	=> esc_html__( 'Team', 'catanis-core' ),
				'public' 			=> true,
				'show_ui' 			=> true,
				'capability_type' 	=> 'post',
				'hierarchical' 		=> false,
				'show_in_menu' 		=> true,
				'show_in_nav_menus' => false,
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'has_archive' 		=> false,
				'query_var' 		=> false,
				'can_export' 		=> true,
				'menu_icon'			=> 'dashicons-groups',
				'rewrite' 			=> array( 'slug' => 'team', 'with_front' => false ),
				'supports' 			=> array( 'title', 'thumbnail', 'page-attributes' )
			)
		);
	}
	
	/*Custom  columns for list*/
	function custom_columns( $columns ) {
	
		$columns = array(
			'cb' 		=> '<input type="checkbox" />',
			'title' 	=> esc_html__( 'Author', 'catanis-core' ),
			'avatar' 	=> esc_html__( 'Image', 'catanis-core' ),
			'zinfo' 	=> esc_html__( 'Infomation', 'catanis-core' ),
			'date' 		=> esc_html__( 'Date', 'catanis-core' )
		);
	
		return $columns;
	}
	
	/*Content  columns for list*/
	function content_columns( $column_name, $post_ID ) {
		$data = (array) get_post_meta( $post_ID, Catanis_Meta::$meta_key, true );
		switch ($column_name) {
			case 'avatar':
				$post_featured_image = Catanis_Core_Plugin::cata_get_featured_image( $post_ID );
				if ( $post_featured_image ) {
					echo '<img src="' . $post_featured_image . '" style="width:80px" class="img-team"/>';
				}
				break;
	
			case 'zinfo':
				if ( ! empty( $data['position'] ) )
					echo '<p><strong>' . esc_html__( 'Position', 'catanis-core' ).': </strong>' . @$data['position'] . '</p>';
				if ( ! empty( $data['personal_url'] ) )
					echo '<p><strong>' . esc_html__( 'URL', 'catanis-core').': </strong>' . @$data['personal_url'] . '</p>';
				if ( ! empty( $data['email'] ) )
					echo '<p><strong>' . esc_html__( 'Email', 'catanis-core').': </strong>' . @$data['email'] . '</p>';
				break;
				
			default:
				break;
		} 
	}
	
	/*Sort  columns data*/
	function sortable_columns( $columns ) {
		return $columns;
	}
	
	/*Add css for custom columns*/
	function add_custom_css() {
		echo '<style type="text/css">
				.widefat th.sortable.column-zimage, .widefat th.sorted.column-zimage{width:140px}
  			</style>';
	}
	
}

new Catanis_Posttype_Team();


/*============================================================================================*/
/*=== 3. POST TYPE - TESTIMONIALS ============================================================*/ 
class Catanis_Posttype_Testimonials{
	
	public function __construct(){
		$this->init();
	}
	
	private function init(){
	
		add_action( 'init', array( $this, 'register_post_type' ), 10 );
		
		if ( is_admin() ) {
			add_action( 'admin_head', array( $this, 'add_custom_css' ) );
			
			add_filter( 'manage_edit-testimonials_columns', array( $this, 'custom_columns' ) );
			add_action( 'manage_testimonials_posts_custom_column', array( $this, 'content_columns' ), 10, 2 );
			add_filter( 'manage_edit-testimonials_sortable_columns', array( $this, 'sortable_columns' ) );
		}
	}
	
	/*Register post type & taxonomy*/
	public function register_post_type(){
		$labels = array(
			'name' 					=> esc_html_x( 'Testimonials', 'testimonials type general name', 'catanis-core' ),
			'singular_name' 		=> esc_html_x( 'Testimonial Item', 'testimonial type singular name', 'catanis-core' ),
			'add_new' 				=> esc_html_x( 'Add New', 'testimonial', 'catanis-core' ),
			'add_new_item' 			=> esc_html__( 'Add New Item', 'catanis-core' ),
			'edit_item' 			=> esc_html__( 'Edit Item', 'catanis-core' ),
			'new_item' 				=> esc_html__( 'New Testimonial Item', 'catanis-core' ),
			'view_item' 			=> esc_html__( 'View Item', 'catanis-core' ),
			'search_items' 			=> esc_html__( 'Search Testimonial Items', 'catanis-core' ),
			'not_found' 			=> esc_html__( 'No testimonial items found', 'catanis-core' ),
			'not_found_in_trash' 	=> esc_html__( 'No testimonial items found in Trash', 'catanis-core' ),
			'parent_item_colon' 	=> ''
		);
	
		register_post_type(
			'testimonials',
			array(
				'labels' 			=> $labels,
				'singular_label' 	=> esc_html__( 'Testimonial', 'catanis-core' ),
				'public' 			=> true,
				'show_ui' 			=> true,
				'capability_type' 	=> 'post',
				'hierarchical' 		=> false,
				'show_in_menu' 		=> true,
				'show_in_nav_menus' => false,
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'has_archive' 		=> false,
				'query_var' 		=> false,
				'can_export' 		=> true,
				'menu_icon'			=> 'dashicons-format-quote',
				'rewrite' 			=> array( 'slug' => 'testimonials', 'with_front' => true ),
				'taxonomies' 		=> array( 'testimonials_category' ),
				'supports' 			=> array( 'title', 'page-attributes')
			)
		);
	
		register_taxonomy(
			'testimonials_category',
			array( 'testimonials' ),
			array(
				'label' 			=> 'Testimonial Categories',
				'singular_label' 	=> 'Testimonial Category',
				'hierarchical' 		=> true,
				'show_in_menu' 		=> true,
				'show_in_nav_menus' => false,
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'rewrite' 			=> true,
			)
		);
	
	}
	
	/*Add two columns to list*/
	function custom_columns_auto( $defaults ) {
		$defaults['genre']  = esc_html__( 'First Column','catanis-core' );
		$defaults['date']  	= esc_html__( 'Second Column','catanis-core' );
		
		return $defaults;
	}
	
	/*Custom  columns for list*/
	function custom_columns( $columns ) {
	
		$columns = array(
			'cb' 		=> '<input type="checkbox" />',
			'title' 	=> esc_html__( 'Title','catanis-core' ),
			'zimage' 	=> esc_html__( 'Author Image','catanis-core' ),
			'zauthor' 	=> esc_html__( 'Author','catanis-core' ),
			'zcontent' 	=> esc_html__( 'Testimonial','catanis-core' ),
			'date' 		=> esc_html__( 'Date','catanis-core' )
		);
	
		return $columns;
	}
	
	/*Content  columns for list*/
	function content_columns( $column_name, $post_ID ) {
		$data = (array) get_post_meta( $post_ID, Catanis_Meta::$meta_key, true);
		
		switch ( $column_name ) {
			case 'zauthor':
				echo @$data['author'] . '<br /><a href="' .  @$data['organization_url'] .'">' .  @$data['organization_url'] .'</a>';
				break;
	
			case 'zimage':
				echo '<img src="' . @$data['thumbnail'] . '" style="width:80px"/>';
				break;
	
			case 'zcontent':
				echo @$data['testimonial'];
				break;
				
			default:
				break;
		} 
	}
	
	/*Sort  columns data*/
	function sortable_columns( $columns ) {
	
		$columns['zimage'] 		= 'zimage';
		$columns['zauthor'] 	= 'zauthor';
		$columns['zcontent'] 	= 'zcontent';
	
		return $columns;
	}
	
	/*Add css for custom columns*/
	function add_custom_css() {
		echo '<style type="text/css">
   				.widefat th.sortable.column-zauthor,  .widefat th.sorted.column-zauthor{width:150px}
				.widefat th.sortable.column-zimage, .widefat th.sorted.column-zimage{width:140px}
  			</style>';
	}
	
}

new Catanis_Posttype_Testimonials();

?>