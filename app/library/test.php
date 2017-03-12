<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Image Manipulation class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Image_lib
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/image_lib.html
 */
class CI_Image_lib {

	/**
	 * PHP extension/library to use for image manipulation
	 * Can be: imagemagick, netpbm, gd, gd2
	 *
	 * @var string
	 */
	public $image_library		= 'gd2';

	/**
	 * Path to the graphic library (if applicable)
	 *
	 * @var string
	 */
	public $library_path		= '';

	/**
	 * Whether to send to browser or write to disk
	 *
	 * @var bool
	 */
	public $dynamic_output		= FALSE;

	/**
	 * Path to original image
	 *
	 * @var string
	 */
	public $source_image		= '';

	/**
	 * Path to the modified image
	 *
	 * @var string
	 */
	public $new_image		= '';

	/**
	 * Image width
	 *
	 * @var int
	 */
	public $width			= '';

	/**
	 * Image height
	 *
	 * @var int
	 */
	public $height			= '';

	/**
	 * Quality percentage of new image
	 *
	 * @var int
	 */
	public $quality			= 90;

	/**
	 * Whether to create a thumbnail
	 *
	 * @var bool
	 */
	public $create_thumb		= FALSE;

	/**
	 * String to add to thumbnail version of image
	 *
	 * @var string
	 */
	public $thumb_marker		= '_thumb';

	/**
	 * Whether to maintain aspect ratio when resizing or use hard values
	 *
	 * @var bool
	 */
	public $maintain_ratio		= TRUE;

	/**
	 * auto, height, or width.  Determines what to use as the master dimension
	 *
	 * @var string
	 */
	public $master_dim		= 'auto';

	/**
	 * Angle at to rotate image
	 *
	 * @var string
	 */
	public $rotation_angle		= '';

	/**
	 * X Coordinate for manipulation of the current image
	 *
	 * @var int
	 */
	public $x_axis			= '';

	/**
	 * Y Coordinate for manipulation of the current image
	 *
	 * @var int
	 */
	public $y_axis			= '';

	// --------------------------------------------------------------------------
	// Watermark Vars
	// --------------------------------------------------------------------------

	/**
	 * Watermark text if graphic is not used
	 *
	 * @var string
	 */
	public $wm_text			= '';

	/**
	 * Type of watermarking.  Options:  text/overlay
	 *
	 * @var string
	 */
	public $wm_type			= 'text';

	/**
	 * Default transparency for watermark
	 *
	 * @var int
	 */
	public $wm_x_transp		= 4;

	/**
	 * Default transparency for watermark
	 *
	 * @var int
	 */
	public $wm_y_transp		= 4;

	/**
	 * Watermark image path
	 *
	 * @var string
	 */
	public $wm_overlay_path		= '';

	/**
	 * TT font
	 *
	 * @var string
	 */
	public $wm_font_path		= '';

	/**
	 * Font size (different versions of GD will either use points or pixels)
	 *
	 * @var int
	 */
	public $wm_font_size		= 17;

	/**
	 * Vertical alignment:   T M B
	 *
	 * @var string
	 */
	public $wm_vrt_alignment	= 'B';

	/**
	 * Horizontal alignment: L R C
	 *
	 * @var string
	 */
	public $wm_hor_alignment	= 'C';

	/**
	 * Padding around text
	 *
	 * @var int
	 */
	public $wm_padding			= 0;

	/**
	 * Lets you push text to the right
	 *
	 * @var int
	 */
	public $wm_hor_offset		= 0;

	/**
	 * Lets you push text down
	 *
	 * @var int
	 */
	public $wm_vrt_offset		= 0;

	/**
	 * Text color
	 *
	 * @var string
	 */
	protected $wm_font_color	= '#ffffff';

	/**
	 * Dropshadow color
	 *
	 * @var string
	 */
	protected $wm_shadow_color	= '';

	/**
	 * Dropshadow distance
	 *
	 * @var int
	 */
	public $wm_shadow_distance	= 2;

	/**
	 * Image opacity: 1 - 100  Only works with image
	 *
	 * @var int
	 */
	public $wm_opacity		= 50;

	// --------------------------------------------------------------------------
	// Private Vars
	// --------------------------------------------------------------------------

	/**
	 * Source image folder
	 *
	 * @var string
	 */
	public $source_folder		= '';

	/**
	 * Destination image folder
	 *
	 * @var string
	 */
	public $dest_folder		= '';

	/**
	 * Image mime-type
	 *
	 * @var string
	 */
	public $mime_type		= '';

	/**
	 * Original image width
	 *
	 * @var int
	 */
	public $orig_width		= '';

	/**
	 * Original image height
	 *
	 * @var int
	 */
	public $orig_height		= '';

	/**
	 * Image format
	 *
	 * @var string
	 */
	public $image_type		= '';

	/**
	 * Size of current image
	 *
	 * @var string
	 */
	public $size_str		= '';

	/**
	 * Full path to source image
	 *
	 * @var string
	 */
	public $full_src_path		= '';

	/**
	 * Full path to destination image
	 *
	 * @var string
	 */
	public $full_dst_path		= '';

	/**
	 * File permissions
	 *
	 * @var	int
	 */
	public $file_permissions = 0644;

	/**
	 * Name of function to create image
	 *
	 * @var string
	 */
	public $create_fnc		= 'imagecreatetruecolor';

	/**
	 * Name of function to copy image
	 *
	 * @var string
	 */
	public $copy_fnc		= 'imagecopyresampled';

	/**
	 * Error messages
	 *
	 * @var array
	 */
	public $error_msg		= array();

	/**
	 * Whether to have a drop shadow on watermark
	 *
	 * @var bool
	 */
	protected $wm_use_drop_shadow	= FALSE;

	/**
	 * Whether to use truetype fonts
	 *
	 * @var bool
	 */
	public $wm_use_truetype	= FALSE;

	/**
	 * Initialize Image Library
	 *
	 * @param	array	$props
	 * @return	void
	 */
	public function __construct($props = array())
	{
		if (count($props) > 0)
		{
			$this->initialize($props);
		}

		log_message('info', 'Image Lib Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize image properties
	 *
	 * Resets values in case this class is used in a loop
	 *
	 * @return	void
	 */
	public function clear()
	{
		$props = array('thumb_marker', 'library_path', 'source_image', 'new_image', 'width', 'height', 'rotation_angle', 'x_axis', 'y_axis', 'wm_text', 'wm_overlay_path', 'wm_font_path', 'wm_shadow_color', 'source_folder', 'dest_folder', 'mime_type', 'orig_width', 'orig_height', 'image_type', 'size_str', 'full_src_path', 'full_dst_path');

		foreach ($props as $val)
		{
			$this->$val = '';
		}

		$this->image_library 		= 'gd2';
		$this->dynamic_output 		= FALSE;
		$this->quality 				= 90;
		$this->create_thumb 		= FALSE;
		$this->thumb_marker 		= '_thumb';
		$this->maintain_ratio 		= TRUE;
		$this->master_dim 			= 'auto';
		$this->wm_type 				= 'text';
		$this->wm_x_transp 			= 4;
		$this->wm_y_transp 			= 4;
		$this->wm_font_size 		= 17;
		$this->wm_vrt_alignment 	= 'B';
		$this->wm_hor_alignment 	= 'C';
		$this->wm_padding 			= 0;
		$this->wm_hor_offset 		= 0;
		$this->wm_vrt_offset 		= 0;
		$this->wm_font_color		= '#ffffff';
		$this->wm_shadow_distance 	= 2;
		$this->wm_opacity 			= 50;
		$this->create_fnc 			= 'imagecreatetruecolor';
		$this->copy_fnc 			= 'imagecopyresampled';
		$this->error_msg 			= array();
		$this->wm_use_drop_shadow 	= FALSE;
		$this->wm_use_truetype 		= FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * initialize image preferences
	 *
	 * @param	array
	 * @return	bool
	 */
	public function initialize($props = array())
	{
		// Convert array elements into class variables
		if (count($props) > 0)
		{
			foreach ($props as $key => $val)
			{
				if (property_exists($this, $key))
				{
					if (in_array($key, array('wm_font_color', 'wm_shadow_color'), TRUE))
					{
						if (preg_match('/^#?([0-9a-f]{3}|[0-9a-f]{6})$/i', $val, $matches))
						{
							/* $matches[1] contains our hex color value, but it might be
							 * both in the full 6-length format or the shortened 3-length
							 * value.
							 * We'll later need the full version, so we keep it if it's
							 * already there and if not - we'll convert to it. We can
							 * access string characters by their index as in an array,
							 * so we'll do that and use concatenation to form the final
							 * value:
							 */
							$val = (strlen($matches[1]) === 6)
								? '#'.$matches[1]
								: '#'.$matches[1][0].$matches[1][0].$matches[1][1].$matches[1][1].$matches[1][2].$matches[1][2];
						}
						else
						{
							continue;
						}
					}
					elseif (in_array($key, array('width', 'height'), TRUE) && ! ctype_digit((string) $val))
					{
						continue;
					}

					$this->$key = $val;
				}
			}
		}

		// Is there a source image? If not, there's no reason to continue
		if ($this->source_image === '')
		{
			$this->set_error('imglib_source_image_required');
			return FALSE;
		}

		/* Is getimagesize() available?
		 *
		 * We use it to determine the image properties (width/height).
		 * Note: We need to figure out how to determine image
		 * properties using ImageMagick and NetPBM
		 */
		if ( ! function_exists('getimagesize'))
		{
			$this->set_error('imglib_gd_required_for_props');
			return FALSE;
		}

		$this->image_library = strtolower($this->image_library);

		/* Set the full server path
		 *
		 * The source image may or may not contain a path.
		 * Either way, we'll try use realpath to generate the
		 * full server path in order to more reliably read it.
		 */
		if (($full_source_path = realpath($this->source_image)) !== FALSE)
		{
			$full_source_path = str_replace('\\', '/', $full_source_path);
		}
		else
		{
			$full_source_path = $this->source_image;
		}

		$x = explode('/', $full_source_path);
		$this->source_image = end($x);
		$this->source_folder = str_replace($this->source_image, '', $full_source_path);

		// Set the Image Properties
		if ( ! $this->get_image_properties($this->source_folder.$this->source_image))
		{
			return FALSE;
		}

		/*
		 * Assign the "new" image name/path
		 *
		 * If the user has set a "new_image" name it means
		 * we are making a copy of the source image. If not
		 * it means we are altering the original. We'll
		 * set the destination filename and path accordingly.
		 */
		if ($this->new_image === '')
		{
			$this->dest_image  = $this->source_image;
			$this->dest_folder = $this->source_folder;
		}
		elseif (strpos($this->new_image, '/') === FALSE && strpos($this->new_image, '\\') === FALSE)
		{
			$this->dest_image  = $this->new_image;
			$this->dest_folder = $this->source_folder;
		}
		else
		{
			// Is there a file name?
			if ( ! preg_match('#\.(jpg|jpeg|gif|png)$#i', $this->new_image))
			{
				$this->dest_image  = $this->source_image;
				$this->dest_folder = $this->new_image;
			}
			else
			{
				$x = explode('/', str_replace('\\', '/', $this->new_image));
				$this->dest_image  = end($x);
				$this->dest_folder = str_replace($this->dest_image, '', $this->new_image);
			}

			$this->dest_folder = realpath($this->dest_folder).'/';
		}

		/* Compile the finalized filenames/paths
		 *
		 * We'll create two master strings containing the
		 * full server path to the source image and the
		 * full server path to the destination image.
		 * We'll also split the destination image name
		 * so we can insert the thumbnail marker if needed.
		 */
		if ($this->create_thumb === FALSE OR $this->thumb_marker === '')
		{
			$this->thumb_marker = '';
		}

		$xp = $this->explode_name($this->dest_image);

		$filename = $xp['name'];
		$file_ext = $xp['ext'];

		$this->full_src_path = $this->source_folder.$this->source_image;
		$this->full_dst_path = $this->dest_folder.$filename.$this->thumb_marker.$file_ext;

		/* Should we maintain image proportions?
		 *
		 * When creating thumbs or copies, the target width/height
		 * might not be in correct proportion with the source
		 * image's width/height. We'll recalculate it here.
		 */
		if ($this->maintain_ratio === TRUE && ($this->width !== 0 OR $this->height !== 0))
		{
			$this->image_reproportion();
		}

		/* Was a width and height specified?
		 *
		 * If the destination width/height was not submitted we
		 * will use the values from the actual file
		 */
		if ($this->width === '')
		{
			$this->width = $this->orig_width;
		}

		if ($this->height === '')
		{
			$this->height = $this->orig_height;
		}

		// Set the quality
		$this->quality = trim(str_replace('%', '', $this->quality));

		if ($this->quality === '' OR $this->quality === 0 OR ! ctype_digit($this->quality))
		{
			$this->quality = 90;
		}

		// Set the x/y coordinates
		is_numeric($this->x_axis) OR $this->x_axis = 0;
		is_numeric($this->y_axis) OR $this->y_axis = 0;

		// Watermark-related Stuff...
		if ($this->wm_overlay_path !== '')
		{
			$this->wm_overlay_path = str_replace('\\', '/', realpath($this->wm_overlay_path));
		}

		if ($this->wm_shadow_color !== '')
		{
			$this->wm_use_drop_shadow = TRUE;
		}
		elseif ($this->wm_use_drop_shadow === TRUE && $this->wm_shadow_color === '')
		{
			$this->wm_use_drop_shadow = FALSE;
		}

		if ($this->wm_font_path !== '')
		{
			$this->wm_use_truetype = TRUE;
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Image Resize
	 *
	 * This is a wrapper function that chooses the proper
	 * resize function based on the protocol specified
	 *
	 * @return	bool
	 */
	public function resize()
	{
		$protocol = ($this->image_library === 'gd2') ? 'image_process_gd' : 'image_process_'.$this->image_library;
		return $this->$protocol('resize');
	}

	// --------------------------------------------------------------------

	/**
	 * Image Crop
	 *
	 * This is a wrapper function that chooses the proper
	 * cropping function based on the protocol specified
	 *
	 * @return	bool
	 */
	public function crop()
	{
		$protocol = ($this->image_library === 'gd2') ? 'image_process_gd' : 'image_process_'.$this->image_library;
		return $this->$protocol('crop');
	}

	// --------------------------------------------------------------------

	/**
	 * Image Rotate
	 *
	 * This is a wrapper function that chooses the proper
	 * rotation function based on the protocol specified
	 *
	 * @return	bool
	 */
	public function rotate()
	{
		// Allowed rotation values
		$degs = array(90, 180, 270, 'vrt', 'hor');

		if ($this->rotation_angle === '' OR ! in_array($this->rotation_angle, $degs))
		{
			$this->set_error('imglib_rotation_angle_required');
			return FALSE;
		}

		// Reassign the width and height
		if ($this->rotation_angle === 90 OR $this->rotation_angle === 270)
		{
			$this->width	= $this->orig_height;
			$this->height	= $this->orig_width;
		}
		else
		{
			$this->width	= $this->orig_width;
			$this->height	= $this->orig_height;
		}

		// Choose resizing function
		if ($this->image_library === 'imagemagick' OR $this->image_library === 'netpbm')
		{
			$protocol = 'image_process_'.$this->image_library;
			return $this->$protocol('rotate');
		}

		return ($this->rotation_angle === 'hor' OR $this->rotation_angle === 'vrt')
			? $this->image_mirror_gd()
			: $this->image_rotate_gd();
	}

	// --------------------------------------------------------------------

	/**
	 * Image Process Using GD/GD2
	 *
	 * This function will resize or crop
	 *
	 * @param	string
	 * @return	bool
	 */



	public function image_rotate_gd()
	{
		// Create the image handle
		if ( ! ($src_img = $this->image_create_gd()))
		{
			return FALSE;
		}

		// Set the background color
		// This won't work with transparent PNG files so we are
		// going to have to figure out how to determine the color
		// of the alpha channel in a future release.

		$white = imagecolorallocate($src_img, 255, 255, 255);

		// Rotate it!
		$dst_img = imagerotate($src_img, $this->rotation_angle, $white);

		// Show the image
		if ($this->dynamic_output === TRUE)
		{
			$this->image_display_gd($dst_img);
		}
		elseif ( ! $this->image_save_gd($dst_img)) // ... or save it
		{
			return FALSE;
		}

		// Kill the file handles
		imagedestroy($dst_img);
		imagedestroy($src_img);

		chmod($this->full_dst_path, $this->file_permissions);

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Re-proportion Image Width/Height
	 *
	 * When creating thumbs, the desired width/height
	 * can end up warping the image due to an incorrect
	 * ratio between the full-sized image and the thumb.
	 *
	 * This function lets us re-proportion the width/height
	 * if users choose to maintain the aspect ratio when resizing.
	 *
	 * @return	void
	 */
	public function image_reproportion()
	{
		if (($this->width === 0 && $this->height === 0) OR $this->orig_width === 0 OR $this->orig_height === 0
			OR ( ! ctype_digit((string) $this->width) && ! ctype_digit((string) $this->height))
			OR ! ctype_digit((string) $this->orig_width) OR ! ctype_digit((string) $this->orig_height))
		{
			return;
		}

		// Sanitize
		$this->width = (int) $this->width;
		$this->height = (int) $this->height;

		if ($this->master_dim !== 'width' && $this->master_dim !== 'height')
		{
			if ($this->width > 0 && $this->height > 0)
			{
				$this->master_dim = ((($this->orig_height/$this->orig_width) - ($this->height/$this->width)) < 0)
							? 'width' : 'height';
			}
			else
			{
				$this->master_dim = ($this->height === 0) ? 'width' : 'height';
			}
		}
		elseif (($this->master_dim === 'width' && $this->width === 0)
			OR ($this->master_dim === 'height' && $this->height === 0))
		{
			return;
		}

		if ($this->master_dim === 'width')
		{
			$this->height = (int) ceil($this->width*$this->orig_height/$this->orig_width);
		}
		else
		{
			$this->width = (int) ceil($this->orig_width*$this->height/$this->orig_height);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get image properties
	 *
	 * A helper function that gets info about the file
	 *
	 * @param	string
	 * @param	bool
	 * @return	mixed
	 */
	public function get_image_properties($path = '', $return = FALSE)
	{
		// For now we require GD but we should
		// find a way to determine this using IM or NetPBM

		if ($path === '')
		{
			$path = $this->full_src_path;
		}

		if ( ! file_exists($path))
		{
			$this->set_error('imglib_invalid_path');
			return FALSE;
		}

		$vals = getimagesize($path);
		if ($vals === FALSE)
		{
			$this->set_error('imglib_invalid_image');
			return FALSE;
		}

		$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');
		$mime = isset($types[$vals[2]]) ? 'image/'.$types[$vals[2]] : 'image/jpg';

		if ($return === TRUE)
		{
			return array(
				'width'      => $vals[0],
				'height'     => $vals[1],
				'image_type' => $vals[2],
				'size_str'   => $vals[3],
				'mime_type'  => $mime
			);
		}

		$this->orig_width  = $vals[0];
		$this->orig_height = $vals[1];
		$this->image_type  = $vals[2];
		$this->size_str    = $vals[3];
		$this->mime_type   = $mime;

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Size calculator
	 *
	 * This function takes a known width x height and
	 * recalculates it to a new size. Only one
	 * new variable needs to be known
	 *
	 *	$props = array(
	 *			'width'		=> $width,
	 *			'height'	=> $height,
	 *			'new_width'	=> 40,
	 *			'new_height'	=> ''
	 *		);
	 *
	 * @param	array
	 * @return	array
	 */
	public function size_calculator($vals)
	{
		if ( ! is_array($vals))
		{
			return;
		}

		$allowed = array('new_width', 'new_height', 'width', 'height');

		foreach ($allowed as $item)
		{
			if (empty($vals[$item]))
			{
				$vals[$item] = 0;
			}
		}

		if ($vals['width'] === 0 OR $vals['height'] === 0)
		{
			return $vals;
		}

		if ($vals['new_width'] === 0)
		{
			$vals['new_width'] = ceil($vals['width']*$vals['new_height']/$vals['height']);
		}
		elseif ($vals['new_height'] === 0)
		{
			$vals['new_height'] = ceil($vals['new_width']*$vals['height']/$vals['width']);
		}

		return $vals;
	}


	// --------------------------------------------------------------------
	public function set_error($msg)
	{
		$CI =& get_instance();
		$CI->lang->load('imglib');

		if (is_array($msg))
		{
			foreach ($msg as $val)
			{
				$msg = ($CI->lang->line($val) === FALSE) ? $val : $CI->lang->line($val);
				$this->error_msg[] = $msg;
				log_message('error', $msg);
			}
		}
		else
		{
			$msg = ($CI->lang->line($msg) === FALSE) ? $msg : $CI->lang->line($msg);
			$this->error_msg[] = $msg;
			log_message('error', $msg);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Show error messages
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function display_errors($open = '<p>', $close = '</p>')
	{
		return (count($this->error_msg) > 0) ? $open.implode($close.$open, $this->error_msg).$close : '';
	}

}
