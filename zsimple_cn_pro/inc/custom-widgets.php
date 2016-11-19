<?php
// -----------------------------------------------
// Custom Widgets
// -----------------------------------------------

/**
 * Adds zoo_widget_recent_comments widget.
 */
class zoo_widget_recent_comments extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'zoo_widget_recent_comments', // Base ID
			'zSimple: 最新评论', // Name
			array( // Args
				'description' => '带头像显示的最新评论',
			)
		);
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
		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		$number = 5;
		if ( !empty( $instance['number'] ) && $instance['number'] > 0 ) {
			$number = $instance['number'];
		}
		?>

		<ul class="zsimple-rc">
			<?php zoo_wp_cache( 'zoo_rc_comments', 'simple_wp_cache', zoo_rc_comments( $number ), 0); ?>
		</ul>

		<?php echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = '最新评论';
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		$number = 5;
		if ( isset( $instance['number'] ) ) {
			$number = (int)$instance['number'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">标题:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">显示数量:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" value="<?php echo $number; ?>">
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
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['number'] = ( !empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';

		return $instance;
	}

} // class zoo_widget_recent_comments

// register widget
function register_zoo_widget_recent_comments() {
    register_widget( 'zoo_widget_recent_comments' );
}
add_action( 'widgets_init', 'register_zoo_widget_recent_comments' );


/**
 * Adds zoo_widget_recently_updated_posts widget.
 */
class zoo_widget_recently_updated_posts extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'zoo_widget_recently_updated_posts', // Base ID
			'zSimple: 老文章更新', // Name
			array( // Args
				'description' => '',
			)
		);
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
		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		$number = 5;
		if ( !empty( $instance['number'] ) && $instance['number'] > 0 ) {
			$number = $instance['number'];
		}
		$days = 30;
		if ( !empty( $instance['days'] ) && $instance['days'] > 0 ) {
			$days = $instance['days'];
		}
		?>

		<ul>
			<?php zoo_wp_cache( 'zoo_recently_updated_posts', 'simple_wp_cache', zoo_recently_updated_posts($number, $days), 0); ?>
		</ul>

		<?php echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = '老文章更新';
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		$number = 5;
		if ( isset( $instance['number'] ) ) {
			$number = (int)$instance['number'];
		}
		$days = 30;
		if ( isset( $instance['days'] ) ) {
			$days = (int)$instance['days'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">标题:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">显示数量:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" value="<?php echo $number; ?>">
			<label for="<?php echo $this->get_field_id( 'days' ); ?>">多少天以前的文章:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'days' ); ?>" name="<?php echo $this->get_field_name( 'days' ); ?>" type="number" value="<?php echo $days; ?>">
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
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['number'] = ( !empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
		$instance['days'] = ( !empty( $new_instance['days'] ) ) ? strip_tags( $new_instance['days'] ) : '';

		return $instance;
	}

} // class zoo_widget_recently_updated_posts

// register widget
function register_zoo_widget_recently_updated_posts() {
    register_widget( 'zoo_widget_recently_updated_posts' );
}
add_action( 'widgets_init', 'register_zoo_widget_recently_updated_posts' );


/**
 * Adds zoo_widget_mostactive widget.
 */
class zoo_widget_mostactive extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'zoo_widget_mostactive', // Base ID
			'zSimple: 读者墙', // Name
			array( // Args
				'description' => '',
			)
		);
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
		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		$number = 12;
		if ( !empty( $instance['number'] ) && $instance['number'] > 0 ) {
			$number = $instance['number'];
		}
		$months = 1;
		if ( !empty( $instance['months'] ) && $instance['months'] > 0 ) {
			$months = $instance['months'];
		}
		?>

		<ul>
			<?php zoo_wp_cache( 'zoo_mostactive', 'simple_wp_cache', zoo_mostactive($number, $months), 0); ?>
		</ul>

		<?php echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = '读者墙';
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		$number = 12;
		if ( isset( $instance['number'] ) ) {
			$number = (int)$instance['number'];
		}
		$months = 1;
		if ( isset( $instance['months'] ) ) {
			$months = (int)$instance['months'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">标题:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">显示数量:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" value="<?php echo $number; ?>">
			<label for="<?php echo $this->get_field_id( 'months' ); ?>">多少月内:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'months' ); ?>" name="<?php echo $this->get_field_name( 'months' ); ?>" type="number" value="<?php echo $months; ?>">
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
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['number'] = ( !empty( $new_instance['number'] ) ) ? $new_instance['number'] : '';
		$instance['months'] = ( !empty( $new_instance['months'] ) ) ? $new_instance['months'] : '';

		return $instance;
	}

} // class zoo_widget_mostactive

// register widget
function register_zoo_widget_mostactive() {
    register_widget( 'zoo_widget_mostactive' );
}
add_action( 'widgets_init', 'register_zoo_widget_mostactive' );


