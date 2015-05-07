<?php
/**
 * Adds BridPlaylist_Widget widget.
 */
class BridPlaylist_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'brid_playlist_widget', // Base ID
			__('Brid Playlist Widget', 'text_domain' ), // Name
			array( 
				'description' => __( 'Embed a Brid player with your latest videos playlist.', 'text_domain' ), 

			) // Args
		);

		//Enqueue scripts only if widget is active
		add_action('wp_enqueue_scripts', array(__CLASS__ ,'add_widget_js'));
	}
	private function genRandId(){

    	$t = time();
    	$tl = strlen($t);
    	
    	return substr(time(),($tl-8),$tl).rand();
    }
    //Check enqueued scripts
    private static function checkScriptEnqueued($name, $handle){

         $list = 'enqueued';
         if (wp_script_is( $handle, $list )) {
           return;
         } else {
           wp_register_script( $name, $handle);
           wp_enqueue_script( $handle, $handle, array(), null, false);
         }
    }
    public static function add_widget_js(){
 
		 if ( is_active_widget( false, false, 'brid_playlist_widget', true ) ) {
				self::checkScriptEnqueued('brid.min.js', CLOUDFRONT.'player/build/brid.min.js');
				self::checkScriptEnqueued('brid.widget.min.js', BRID_PLUGIN_URL.'js/brid.widget.min.js');

			}
    }
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		$playerId = BridOptions::getOption('player');
		$siteId = BridOptions::getOption('site');
		$items = $instance['items'];
		$height = $instance['height'];
		$randId = $this->genRandId();
		$noImage = BRID_PLUGIN_URL.'/img/thumb_404.png';
		wp_enqueue_style('bridWidgetCss', BRID_PLUGIN_URL.'css/brid.widget.min.css'); //Add custom js

		 
		?>
		<!-- Wp Brid Playlist widget - Brid Ver. <?php echo BRID_PLUGIN_VERSION; ?>-->
		<div class="bridPlaylistWidget" style="height:<?php echo $height;?>px">

		  <div class="bridWidget" id="bridWidget-<?php echo $randId; ?>">
		    <div id="Brid_<?php echo $randId; ?>" class="brid" itemprop="video" itemscope itemtype="http://schema.org/VideoObject"> 
		    	<div id="Brid_<?php echo $randId; ?>_adContainer"></div> 
		    </div>
		    <div class="bridWidgetGoToLeft"><div class="brid-arrow-left"></div></div>
		    <div class="brid-pl"><div class="BridWidgetPlaylist" id="Brid_<?php echo $randId; ?>_playlist"></div></div>
		    <div class="bridWidgetGoToRight"><div class="brid-arrow-right"></div></div>
		  </div>
		</div>
		<script>
		$BridWidgets.init(
				{
					plugin_url : "<?php echo BRID_PLUGIN_URL; ?>", 
					noImage : 'img/thumb_404.png', 
					playlistType : <?php echo $instance['playlist_id']; ?>,
					height : <?php echo $height; ?>,
					items : <?php echo $items; ?>,
					playerId : "<?php echo $playerId; ?>",
					playlist : "<?php echo CLOUDFRONT; ?>services/dynamic/latest/0/<?php echo $siteId; ?>/1/<?php echo $items; ?>/<?php echo $instance['playlist_id']; ?>.json"
				});
		</script>
		<?php 

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'text_domain' );
		$playlist_id = ! empty( $instance['playlist_id'] ) ? $instance['playlist_id'] : __( 'Playlist', 'text_domain' );
		$items = ! empty( $instance['items'] ) ? $instance['items'] : __( '10', 'text_domain' );
		$height = ! empty( $instance['height'] ) ? $instance['height'] : __( '360', 'text_domain' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" placeholder="New Title" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Choose playlist:' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'playlist_id' ); ?>" name="<?php echo $this->get_field_name( 'playlist_id' ); ?>">
			<option value="0" <?php echo $playlist_id==0 ? 'selected' : ''; ?>>Latest Brid Videos</option>
			<option value="1" <?php echo $playlist_id==1 ? 'selected' : ''; ?>>Latest Youtube Videos</option>
		</select>
		<p>
		<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height:' ); ?></label> 
		<input class="widefat" placeholder="Widget height" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo esc_attr( $height ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'items' ); ?>"><?php _e( 'Items:' ); ?></label> 
		<input class="widefat" placeholder="Number of items to show" id="<?php echo $this->get_field_id( 'items' ); ?>" name="<?php echo $this->get_field_name( 'items' ); ?>" type="text" value="<?php echo esc_attr( $items ); ?>">
		</p>
		<!--<input   type="text" value="<?php echo esc_attr( $playlist_id ); ?>">-->
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['playlist_id'] = ( ! empty( $new_instance['playlist_id'] ) ) ? strip_tags( $new_instance['playlist_id'] ) : 0;
		$instance['items'] = ( ! empty( $new_instance['items'] ) ) ? strip_tags( $new_instance['items'] ) : 10;
		$defaultHeight = 360;
		if(! empty( $new_instance['height'] )){

			$h = strip_tags( intval($new_instance['height']));

			$h = $h>0 ? $h : $defaultHeight;

			if($h<260){ //Player 180 + thumbs
				$h = 260;
			}
			if($h>800){ //Player 180 + thumbs
				$h = 800;
			}
			$instance['height'] = $h;
		}else{
			//$instance['height']  = $defaultHeight;
		}

		//$instance['height'] = ( ! empty( $new_instance['height'] ) ) ? strip_tags( intval($new_instance['height'])!=0 ? intval($new_instance['height']) : 360) : 360;

		return $instance;
	}

} // class Foo_Widget