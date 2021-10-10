	
<?php

/*
 * @version		$Id: player.php 1.2.7 06-08-2018 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2014-2018 Yendif Technologies (P) Ltd
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import libraries
require_once( JPATH_ROOT.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_yendifvideoshare'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'utils.php' );

class YendifVideoSharePlayer {	
	
	private $config = null;
	
	private $players = 0;
	private $license = array();
	
	private $types = array(
		'custom'  => array( 'mp4', 'mp4_hd', 'webm', 'ogg', 'youtube', 'rtmp', 'flash', 'captions' ),
		'video'   => array( 'mp4', 'mp4_hd', 'webm', 'ogg', 'captions' ),
		'youtube' => array( 'youtube', 'captions' ),		
		'rtmp'    => array( 'mp4', 'rtmp', 'flash', 'captions' )
	);
	
	private $properties = array(
		'autoplay',
		'analytics',
		'autoplaylist',
		'can_skip_adverts',
		'controlbar',
		'currenttime',
		'download',
		'duration',
		'embed',
		'engine',
		'fullscreen',
		'keyboard',
		'license',
		'logo',
		'loop',
		'playbtn',
		'playlist_height',
		'playlist_position',
		'playlist_width',
		'playpause',
		'progress',		
		'ratio',
		'share',
		'show_adverts_timeframe',
		'show_skip_adverts_on',
		'enable_adverts',
		'theme',
		'volume',
		'volumebtn',
		'hd',
		'show_consent',
		'default_image'	
	);   
	
	protected static $instance = null;
	
	public $width = -1;
	
	public $height = -1;

    public function __construct( $config = null ) {
	
		$this->config = $config == null ? YendifVideoShareUtils::getConfig() : $config;
		$this->width = $this->height = '100%';
		$this->addScript();
		
    }
	
	public static function getInstance( $config = null ) {
		if( null == self::$instance ) {
			self::$instance = new self( $config );
		}

		return self::$instance;
	}
	
	public function addScript() {	
		 
		$document = JFactory::getDocument();
		
		// Styles
		$document->addStyleSheet( YendifVideoShareUtils::prepareURL( 'media/yendifvideoshare/player/video-js.min.css', 'text/css', 'screen' )  );
		$document->addStyleSheet( YendifVideoShareUtils::prepareURL( 'media/yendifvideoshare/assets/site/css/yendifvideoshare.css', 'text/css', 'screen' ) );		

		if ( ! empty( $this->config->progress_bar_color ) ) {
			$document->addStyleDeclaration ( '
				.video-js .vjs-button:hover, 
				.vjs-resolution-button-label:hover,
				.vjs-audio-button .vjs-menu .vjs-menu-content li:hover,
				.vjs-chapters-button .vjs-menu .vjs-menu-content li:hover, 
				.vjs-descriptions-button .vjs-menu .vjs-menu-content li:hover, 
				.vjs-subs-caps-button .vjs-menu .vjs-menu-content li:hover, 
				.vjs-subtitles-button .vjs-menu .vjs-menu-content li:hover {
					background-color: ' .$this->config->progress_bar_color. ';
					color: #fff !important;
				}
				.video-js .vjs-play-progress{
					background-color: '. $this->config->progress_bar_color .';
				}
			');
		}
		
		
		if ( ! empty( $this->config->responsive_css ) ) {
			$document->addStyleDeclaration( $this->config->responsive_css );
		}
		
		// Scripts
		JHtml::_('jquery.framework');
		$document->addScript( YendifVideoShareUtils::prepareURL( 'media/yendifvideoshare/player/video.min.js' ) );
		$document->addScript( YendifVideoShareUtils::prepareURL( 'media/yendifvideoshare/player/videojs-plugins.min.js' ) );
		$document->addScript(  YendifVideoShareUtils::prepareURL( 'media/yendifvideoshare/assets/site/js/yendifvideoshare.js' ) ); 

		$document->addScriptDeclaration("
			if( typeof( yendif ) === 'undefined' ) {
				var yendif = {};
			};
			
			yendif.i18n = [];
			yendif.i18n['avertisment'] = '".JText::_('COM_YENDIFVIDEOSHARE_ADVERTISMENT')."';
			yendif.i18n['show_skip'] = '".JText::_('COM_YENDIFVIDEOSHARE_SHOW_SKIP')."';
			yendif.i18n['share_title'] = '".JText::_('COM_YENDIFVIDEOSHARE_SHARE_TITLE')."';
			yendif.i18n['embed_title'] = '".JText::_('COM_YENDIFVIDEOSHARE_EMBED_TITLE')."';	
		");	
			
		$config = array();
		
		foreach( $this->properties as $property ) {
			if( isset( $this->config->$property ) ) {
				$value = $this->config->$property;
				$config[ $property ] = is_numeric( $value ) && $property != 'ratio' ? (int) $value : $value;
			}
		}
		
		$config['responsive']  = 1;
		$config['baseurl']     = JURI::root();	
		$document->addScriptDeclaration('yendifplayer= ' . json_encode( $config ) . ';');
		
	}
	
	public function addStyleDeclaration( $playerid, $params = '' ) {
	
		$document = JFactory::getDocument();
		
		$playlistHeight = isset( $params['playlist_height'] ) ? $params['playlist_height'] : $this->config->playlist_height;
		
		$html = $document->addStyleDeclaration(' 
			@media only screen and (max-width: 480px) {
				#' . $playerid . ' .vjs-playlist { 
					height:'. $playlistHeight .'px;
				 }
			}
		');
		
		$playerShare  = isset( $params['share'] ) ? $params['share'] : $this->config->share;
		$playlerEmbed = isset( $params['embed'] ) ? $params['embed'] : $this->config->embed;
		$playlerControlbar = isset( $params['controlbar'] ) ? $params['controlbar'] : $this->config->controlbar;

		if ( empty( $playlerEmbed ) && empty ( $playerShare ) ) {
			$document->addStyleDeclaration('
				#' . $playerid . ' .vjs-download {
					top: 10px;
				}
			');
		}
		
		if ( $playlerControlbar == 0 ) {
			$document->addStyleDeclaration('
				#' . $playerid . ' .vjs-control-bar {
					display:none;
				}
			');
		}
		
	}
	
	public function embedPlayer( $params ) {
	
		$html  = '<!DOCTYPE html>';
		$html .= '<html>';
		$html .= '<head>';
		$html .= sprintf( '<link rel="stylesheet" href="%s" />', YendifVideoShareUtils::prepareURL( 'media/yendifvideoshare/player/video-js.min.css', false ));
		$html .= sprintf( '<link rel="stylesheet" href="%s" />', YendifVideoShareUtils::prepareURL( 'media/yendifvideoshare/assets/site/css/yendifvideoshare.css', false ));
				
		
		$html .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>';
		
		$html .= "<script>
				if( typeof( yendif ) === 'undefined' ) {
					var yendif = {};
				}; 
				yendif.i18n = [];
				yendif.i18n['avertisment'] = '".JText::_('COM_YENDIFVIDEOSHARE_ADVERTISMENT')."';
				yendif.i18n['show_skip'] = '".JText::_('COM_YENDIFVIDEOSHARE_SHOW_SKIP')."';
				yendif.i18n['share_title'] = '".JText::_('COM_YENDIFVIDEOSHARE_SHARE_TITLE')."';
				yendif.i18n['embed_title'] = '".JText::_('COM_YENDIFVIDEOSHARE_EMBED_TITLE')."';
				
			</script>";
		
		$html .= sprintf( '<script src="%s" type="text/javascript"></script>', YendifVideoShareUtils::prepareURL( 'media/yendifvideoshare/player/video.min.js', false ) );
		$html .= sprintf( '<script src="%s" type="text/javascript"></script>', YendifVideoShareUtils::prepareURL( 'media/yendifvideoshare/player/videojs-plugins.min.js', false ) );
		$html .= sprintf( '<script src="%s" type="text/javascript"></script>', YendifVideoShareUtils::prepareURL( 'media/yendifvideoshare/assets/site/js/yendifvideoshare.js', false ) );
		$html .= '<style type="text/css">body, iframe{ margin:0 !important; padding:0 !important; background:transparent !important; }</style>';
		
		$config = array();
		
		foreach( $this->properties as $property ) {
			if( isset( $this->config->$property ) ) {
				$value = $this->config->$property;
				$config[ $property ] = is_numeric( $value ) && $property != 'ratio' ? (int) $value : $value;
			}
		}
		
		$config['responsive']       = 1;
		$config['playlist_width']    = $config['playlist_width'];
		$config['playlist_height']   = $config['playlist_height'];
		$config['playlist_position'] = $config['playlist_position'];
		$config['volume']           = $config['volume'];
		$config['baseurl']           = JURI::root();
		
		$playerObj = $this->singlePlayer( $params, '', true );
		
		$html .= '<script type="text/javascript">';
		$html .= 'yendifplayer = ' . json_encode( $config ) . ';';
		$html .= '$(document).ready(function(){
    				$(".yendifplayer").css({height:$(window).height(), width:$(window).width()});
					' . ( is_array( $playerObj ) ? $playerObj[0] : '' ) . '
				  });';
		$html .= '</script>';
		$html .= '</head>';
		$html .= '<body>';
		$html .= is_array( $playerObj ) ? $playerObj[1] : $playerObj;
		$html .= '</body>';
		$html .= '</html>';
		
		return $html;
		
	}

	//muthu
	public function singlePlayer( $params, $item = null, $model = null ) {
		
		++$this->players;
		$playerid = uniqid( 'yendif' . $this->players );		
		
		if( ! isset( $params['videoid' ] ) && $item == null ) return;
		
		$db = JFactory::getDBO();
		
		$data_attrs = '';
		$vid_attrs  = ' controls';
		
		foreach( $params as $key => $value ) {
			if( $value == '' || $value == 'global' ) unset( $params[ $key ] );
		}
		
		if( isset( $params['videoid'] ) && $params['videoid'] > 0 ) {
			$db = JFactory::getDBO();
        	$query = "SELECT * FROM #__yendifvideoshare_videos WHERE id=".(int) $params['videoid'];
        	$db->setQuery( $query );
        	$item = $db->loadObject();
		}

		$poster = '';
		if( isset( $item->image ) && ! empty( $item->image ) ) {
			$poster = YendifVideoShareUtils::getImage( $item->image, '_poster', false );
			$vid_attrs .= ' poster='.$poster;
		}
		
		$ratio = isset( $params['ratio'] ) ? (int) $params['ratio'] : (int) $this->config->ratio;
		if( empty ( $ratio ) ){
			$ratio = 0.5625;
		}
		$ratio = ( $ratio * 100 );
		$ratio = min( 100, $ratio );

		$attrs = array();
		
		$playerTheme = ( ! empty( $params['theme'] )  ? $params['theme'] : $this->config->theme );
		$playerShare =  isset( $params['share'] ) ? 0 : 0;
		$playlerEmbed = isset( $params['embed'] ) ? $params['embed'] : $this->config->embed;
		$yendifShare = '';
		$yendifEmbed = '';
		$yendifHideShares= '';		
		
		if( ! empty ( $playerShare ) ) {
			$yendifShare = 'yendif-share-enable';
		}
		
		if( ! empty ( $playlerEmbed ) ) {
			$yendifEmbed = 'yendif-embed-enable';
		}
		if( empty ( $item->id ) ) {
			
			$yendifHideShares = 'yendif-notid-disable';
		}
		
		$attrs[] = sprintf( 'class="yendifplayer  %s %s %s %s" style="padding-bottom: %s;" ', $playerTheme, $yendifShare, $yendifEmbed, $yendifHideShares, $ratio . '%');
		
		$properties = $this->properties;
		$config = (array) $this->config;
		$count = count( $properties );
			for( $i = 0; $i < $count; $i++ ) {
				$key = $properties[$i];
				if( isset($params[$key]) ) {
					$attrs[] = " data-" . $key . '="' . $params[$key] . '"';
				};	
		};

		if( isset( $item->access ) && ! YendifVideoShareUtils::hasPermission( $item->access ) ) {
			$noPObj = '<div class="yendif-responsive-media" style="padding-bottom:'.$ratio.'%;">';
			if( $poster ) $noPObj .= '<img src="'.$poster.'" />';
			$noPObj .= '<div class="yendif-overlay"></div>';
			$noPObj .= '<div class="yendif-no-permission-content">'.JText::_('YENDIF_VIDEO_SHARE_NO_PERMISSION_VIDEO').'</div>';
			$noPObj .= '</div>';
			return $noPObj;
		}
		
		if( isset( $item->id ) ) {
			$this->addOGMetaTags( $item );	
			$attrs[] = ' data-vid="'.$item->id.'"';
			$u = JURI::getInstance( JURI::base() );
			if($u->getScheme()){
				$link = $u->getScheme().'://';
			}else{
				$link = 'http://';
			}
			$link .= $u->getHost();

			$attrs[] = ' data-shareurl="'.$link.YendifVideoShareUtils::buildRoute( $item, 'video'  ).'"';
			$attrs[] = 'data-download=0';	
	
			$data_attrs .= ' data-vid="'.$item->id.'"';
		} else {			
			$params['embed']    = 0;
			$params['download'] = 0;
			$data_attrs .= ' data-embed=0 data-download=0';
		}

		if( $item->type == 'thirdparty' ) {
			$this->updateViews( $item->id );
			 $show_consent = $this->config->show_consent;
			 $thirdpartyPlayer = '<div class="yendif-responsive-media" id="yendif-responsive-media" style="padding-bottom:'.( $ratio).'%;">';
			 
			 if( $show_consent !=0 ){
			 	if( ! isset( $_COOKIE['yendif_gdpr_consent'])) {
					$PosterObj= '';
					if( $poster ) $PosterObj = '<div class="gdpr-consent-poster" style="opacity: 0.4;"><img src="'.$poster.'" /></div>';
					$html = '<div class="gdpr-consent-wrapper">' . 
								str_replace( 'src', 'data-src', $item->thirdparty ) . 
								'<div class="gdpr-consent-overlay" style="background-color: #000;">
									"'.$PosterObj.'"
									<div class="gdpr-overlay-content">
										<div class="gdprcookie-intro">
											 <h1>'.JText::_('YENDIF_VIDEO_SHARE_PRIVSCY_POLICY').'</h1>
											<p>'.JText::_('YENDIF_VIDEO_SHARE_GDPR_DESCRIPTION').'</p>
										</div>
										<div class="gdprcookie-buttons">
											<button type="button" class="yendifgdprConsent">'.JText::_('YENDIF_VIDEO_SHARE_ACCEPT_COOKIED').' </button>
										</div>
									</div>
								 </div>
							 </div>';
				  $thirdpartyPlayer .= $html;
				} else {
					$thirdpartyPlayer .= $item->thirdparty;	
				}
				
			 } else {
			 	$thirdpartyPlayer .= $item->thirdparty;	
			}	
				
			$thirdpartyPlayer .= '</div>';
			return $thirdpartyPlayer;
		}

		// check if adverts available
		$index = $is_advert = 0;
		$obj = array();

		if( $this->is_mobile() == false && $this->config->enable_adverts != 'none'  && ! empty( $item->id ) ) {
			// add preroll video
			if( ( $this->config->enable_adverts == 'preroll_only' || $this->config->enable_adverts == 'both' ) && $item->preroll = 0 ) {
       			$query = "SELECT * FROM #__yendifvideoshare_adverts WHERE published=1 AND (type=" . $db->quote('preroll') . " OR type=" . $db->quote('both') . ")";
				if( $item->preroll == -1 ) {
					$query .= " ORDER BY RAND() LIMIT 1";
				} else {
					$query .= " AND id=" . $item->preroll;
				}
       			$db->setQuery( $query );
       			$preroll = $db->loadObject();
				
				if( $preroll ) {
					$is_advert = 1;
					$attrs[] = sprintf( 'data-prerollid="%s"', $preroll->id );
					$attrs[] = sprintf( 'data-prerollad="%s"', $preroll->mp4 );	
					$attrs[] = sprintf( 'data-prerolltarget="%s"', $preroll->link );
					++$index;
				}
			}
			//add postroll
			$postroll = 0;
			if( ( $this->config->enable_adverts == 'postroll_only' || $this->config->enable_adverts == 'both' ) && $item->postroll != 0 ) {
       			$query = "SELECT * FROM #__yendifvideoshare_adverts WHERE published=1 AND (type=" . $db->quote('postroll') . " OR type=" . $db->quote('both') . ")";
				if( $item->postroll == -1 ) {
					$query .= " ORDER BY RAND() LIMIT 1";
				} else {
					$query .= " AND id=" . $item->postroll;
				}
       			$db->setQuery( $query );
       			$postroll = $db->loadObject();

				if( $postroll ) {
					$is_advert = 1;
					$attrs[] = sprintf( 'data-postrollid="%s"', $postroll->id );
					$attrs[] = sprintf( 'data-postrollad="%s"', $postroll->mp4 );
					$attrs[] = sprintf( 'data-postrolltarget="%s"', $postroll->link );	
				}
			}
		}

		// add main video
		if ( 'rtmp' == $item->type && ! empty( $item->mp4 ) ) {
		
			if ( $this->is_mobile() ) {				
				$item->type = 'video';
			} else {
				$item->mp4 = '';
			}
		}
			
		$types = $this->types[ $item->type ];
		$count = count( $types );
		$sources = '';
		$typeYoutube = '';
		for( $i = 0; $i < $count; $i++ ) {
			$type = $types[$i];
			if( isset( $item->$type ) && ! empty( $item->$type ) ) {
				$src = $item->$type;
				$attrs[] = sprintf( 'data-filetype="%s"', $type);
				switch( $type ) {
					case 'mp4' :
						$filetype = strtolower( JFile::getExt($src) );
						$mimetype = ( $filetype == 'm3u8' ) ? 'application/x-mpegurl' : ( $filetype == 'flv' ? 'video/flash' : 'video/mp4' );
						if( ! empty( $item->mp4_hd ) ) $params['hd'] = $item->mp4_hd;
						$sources .= sprintf( '<source type="%s" src="%s?sd" label="SD" res="480">', $mimetype, $src );
						break;	
					case 'youtube' :
						$sources .= '<source type="video/' . $type . '" src="' . $src . '"  >';	
						$typeYoutube = $type;
						break;	
					case 'rtmp' :
						$sources .= '<source  src="'.$src.'/'.$item->flash.'" type="rtmp/mp4">';
						unset( $item->flash );
						break;
					case 'flash' :
						if( $item->type != 'rtmp' ) $sources .= '<source type="video/' . $type . '" src="' . $src . '">';
						break;
					case 'captions' :
						$sources .= '<track kind="captions" src="' . $src . '" srclang="en" label="English" default>';
						break;
					default :
						if($type == 'mp4_hd'){$type = 'mp4';}
						$sources .= '<source type="video/' . $type . '" src="' . $src . '?hd" label="HD" res="1080">';
						
				}
				
				
			}
		}
		
		$attrs[] = sprintf( 'data-id="%s"', $playerid );

		$showConsent = ( 'youtube' == $item->type && ! empty( $this->config->show_consent ) && ! isset( $_COOKIE['yendif_gdpr_consent'] ) );
		$attrs = implode( ' ', $attrs );		
		
		
		

		// Build Output
		$this->addStyleDeclaration( $playerid, $params );
		
		$html  = sprintf( '<div %s>',  $attrs );
		$html .= sprintf( '<video id="%s" preload="auto"  class="video-js vjs-default-skin" %s>', $playerid, $vid_attrs );		
		if ( ! $showConsent ) $html .= $sources;
		$html .= sprintf( '</video>' );	
		if ( $showConsent ) $html .= $this->gdprConsentYoutube();
		$html .= sprintf( '</div>' );
		
		return $html;
		
	}
	
	public function playlistPlayer( $params, $check_publishing_options ) {
		
		++$this->players;
		$playerid = uniqid( 'yendif' . $this->players );		
		
		foreach( $params as $key => $value ) {
			if( $value == '' || $value == 'global' ) unset( $params[ $key ] );
		}
		
		$db = JFactory::getDBO();
        $query = "SELECT * FROM #__yendifvideoshare_videos";
		
		$where = array();
		$where[] = "published=1";
		
		if( $check_publishing_options ) {
			$date = JFactory::getDate();
			
			$nullDate = $db->quote( $db->getNullDate() );
	    	$nowDate  = $db->quote( $date->toSql() );
		
			$where[] = " ( published_up = " . $nullDate . " OR published_up <= " . $nowDate .' )' ;
			$where[] = " ( published_down = " . $nullDate . " OR published_down >= " . $nowDate.' )';	
		}	
			
		$where[] = "type!=".$db->Quote('thirdparty');
		
		if( isset( $params['catid'] ) && $params['catid'] > 0 ) {
			$where[] = "catid=".$params['catid'];
		}
		
		if( isset( $params['featured']) && $params['featured'] == 'featured' ) {
		 	$where[] = "featured=1";
		}
	
		$user = JFactory::getUser();
		$viewLevels = $user->getAuthorisedViewLevels();
		$where[] = "access IN (''," . implode(',', $viewLevels) . ")";
		
		$where = ( count($where) ? ' WHERE '. implode(' AND ', $where) : '' );		 
		$query .= $where;	
		
		$orderby = isset( $params['orderby'] ) ? $params['orderby'] : '';
		switch( $orderby ) {	
			case 'latest' :
				$query .= ' ORDER BY created_date DESC';
				break;		
			case 'most_viewed' :
				$query .= ' ORDER BY views DESC';
				break;
			case 'most_rated' :
				$query .= ' ORDER BY rating DESC';
				break;
			case 'date_added' :
				$query .= ' ORDER BY created_date ASC';
				break;
			case 'a_z' :
				$query .= ' ORDER BY title ASC';
				break;
			case 'z_a' :
				$query .= ' ORDER BY title DESC';
				break;
			case 'random' :
				$query .= ' ORDER BY RAND()';
				break;
			case 'ordering' :
				$query .= ' ORDER BY ordering';
				break;
			default :
				$query .= ' ORDER BY id DESC';				
		}

		if( isset($params['limit']) && !empty($params['limit']) ) {
			$query .= " LIMIT ". (int) $params['limit'];
		}
		
        $db->setQuery( $query );
        $items = $db->loadObjectList();
		if( count( $items ) == 0 ) return null;
		
		$playlist_title_limit = isset( $params['playlist_title_limit'] ) ? $params['playlist_title_limit'] : $this->config->playlist_title_limit;
		$playlist_desc_limit = isset( $params['playlist_desc_limit'] )   ? $params['playlist_desc_limit'] : $this->config->playlist_desc_limit;
		$obj = array();
		
		$index = 0;
		$ratio = isset( $params['ratio'] ) ? $params['ratio'] : $this->config->ratio;
		if( empty ( $ratio ) ){
			$ratio = 0.5625;
		}
		$ratio = ( $ratio * 100 );
		$ratio = min( 100, $ratio );
		$vid_attrs  = ' controls';
		
		$attrs = array();		
		$attrs[] = sprintf( 'data-id="%s"', $playerid );
		$attrs[] = sprintf('data-baseurl="%s"',  JURI::root() );
		
		$count = count( $this->properties );
		for( $i = 0; $i < $count; $i++ ) {
			$key = $this->properties[$i];
			if( isset( $params[ $key ] ) ) {
				switch( $key ) {
					case 'playlist_width' :
						$obj['playlistWidth'] = $params[$key];
						$attrs[] = sprintf( 'data-playlist_width="%d"', $params[$key] );
						break;
					case 'playlist_height' :
						$obj['playlistHeight'] = $params[$key];
						$attrs[] = sprintf( 'data-playlist_height="%d"', $params[$key] );
						break;
					case 'playlist_position' :
						$obj['playlistPosition'] = $params[$key];
						$attrs[] = sprintf( 'data-playlist_position="%s"', $params[$key] );
						break;
					case 'autoplay' :
					case 'autoplaylist' :
						$obj[$key] = (int) $params[$key];
						$attrs[] = sprintf( 'data-autoplaylist="%d"', $params[$key] );
						break;
					default :
						$obj[$key] = $params[$key];
						$attrs[] = " data-" . $key . '="' . $params[$key] . '"';
				};				
			};				
		};
		
		$playlistWidth =  isset( $params['playlist_width'] ) ? $params['playlist_width'] : $this->config->playlist_width;
		$playlistHeight = isset( $params['playlist_height'] ) ? $params['playlist_height'] : $this->config->playlist_height;
		$playlistPosition = isset( $params['playlist_position'] ) ? $params['playlist_position'] : $this->config->playlist_position;
		$playerTheme = isset( $params['theme'] ) ? $params['theme'] : $this->config->theme;
		$playerShare =  isset( $params['share'] ) ? 0 : 0;
		$playlerEmbed = isset( $params['embed'] ) ? $params['embed'] : $this->config->embed;
		$yendifShare = '';
		$yendifEmbed = '';

		if( ! empty ( $playerShare ) ) {
			$yendifShare = 'yendif-share-enable';
		}
		if( ! empty ( $playlerEmbed ) ) {
			$yendifEmbed = 'yendif-embed-enable';
		}

		
		if( $playlistPosition == 'bottom' ) {
			$this->playlistBottomHeight( $playlistHeight );
		}		
		
		$attrs[] = sprintf( 'data-vid="%d"', $items[0]->id );
		$attrs = implode( ' ', $attrs );
		$videosrc = '';
		$poster = sprintf( 'class="video-js vjs-default-skin" poster="%s"', $items[0]->image );
		
		if( $items[0]->type == 'youtube' ){
			$videosrc = sprintf( '<source src="%s" type="video/youtube">', $items[0]->youtube );
		} else {
			$videosrc = sprintf( '<source src="%s" type="video/mp4">', $items[0]->mp4 );
		}		
		
		$this->addStyleDeclaration( $playerid, $params );
		
		$html  = sprintf( '<div class="yendif-playlist-container">' );
		
		if( $playlistPosition == 'bottom' ) {
			$html .= '<div class="yendif-playlist-player '. $playerid .'"  style="width:100%; box-sizing: border-box;">';
		} else {
			$html .= '<div class="yendif-playlist-player '. $playerid .'"  style="width: calc(100% - ' . $playlistWidth . 'px); box-sizing: border-box;">';
		}
		
		$html .= sprintf( '<div class="yendifplayer %s %s %s" style="padding-bottom: '.$ratio.'%%;" %s>', $yendifShare, $yendifEmbed, $playerTheme, $attrs );
		$html .= sprintf( '<video id="%s"  preload="none" %s >', $playerid, $poster );
		$html .= $videosrc;
		$html .= '</video></div></div>';
		
		$html .= sprintf( '<div class="vjs-playlist vjs-playlist-%s %s %s" style="width: ' . $playlistWidth .'px">', $playerid , $playlistPosition, $playerTheme );
		$html .='</div>';
		
		$html .= sprintf( '<ul id="vjs-playlist-data-%s" class="vjs-playlist-data" style="display: none;">', $playerid );
		$attr = array();
		
		$u = JURI::getInstance( JURI::base() );
		if($u->getScheme()){
			$link = $u->getScheme().'://';
		}else{
			$link = 'http://';
		}
		$link .= $u->getHost();
					
		foreach( $items as $item ) {
			if ( 'rtmp' == $item->type && ! empty( $item->mp4 ) ) {
			
				if ( $this->is_mobile() ) {				
					$item->type = 'video';
				} else {
					$item->mp4 = '';
				}
			}
			$types = $this->types[$item->type];
			array_push( $types, 'id', 'image', 'title', 'description','type','duration');
			$count = count( $types );
			$attr = array();	
			$attr[] = sprintf( 'data-shareurl="%s"', $link.YendifVideoShareUtils::buildRoute( $item, 'video' ) );
			
			for( $i = 0; $i < $count; $i++ ) {		
				$type = $types[$i];
				if( isset( $item->$type ) && ! empty( $item->$type ) ) {
					$src = $item->$type;
					switch($type) {	
						case 'id' :
							$type = 'vid';
							$src = $item->id;
							break;				
						case 'image' :
							$type = 'poster';
							$src = YendifVideoShareUtils::getImage($item->image, '_poster', false);							
							break;
						case 'title' :
							$src = YendifVideoShareUtils::Truncate($src, $playlist_title_limit);
							break;
						case 'description' :
							$src = YendifVideoShareUtils::Truncate($src, $playlist_desc_limit);
							break;
						case 'type' :
						    $type = 'filetype';
							$src = $item->type;
							break;
						case 'mp4' :
							$filetype = strtolower( JFile::getExt( $src ) );
							$type = ( $filetype == 'm3u8' ) ? 'mpegurl' : ( $filetype == 'flv' ? 'flash' : 'mp4' );
							break;
						case 'mp4_hd' :
							$type = 'hd';
							break;
				}
					
					$attr[] = sprintf( 'data-'.$type.'="%s"', $src );	
					$imploded = implode(' ', $attr);
				};		
			};
			++$index;
			$html .= sprintf( '<li class="vjs-playlist-item" %s>', $imploded  );
			$html .='</li>';	
		};
		$html .='</ul></div>';
		return $html;	
	}
	
	public function addOGMetaTags( $item ) {
	
		$app = JFactory::getApplication();
		
		if( $app->input->get('option') == 'com_yendifvideoshare' && $app->input->get('view') == 'video' && $app->input->getInt('id') == $item->id ) {
			$document = JFactory::getDocument();
			$document->addCustomTag('<meta property="og:title" content="'.$item->title.'" />');
        	$document->addCustomTag('<meta property="og:image" content="'.$item->image.'" />');	
		}
		
	}
	
 public function updateViews( $videoid ) {
		
		$session = JFactory::getSession();	
		$ses_videos = $session->get('yendif_videos', array());

		if( ! in_array( $videoid, $ses_videos ) ) {
		    $ses_videos[] = $videoid;
				
		 	$db = JFactory::getDBO();     	    
		 	$query = "SELECT views FROM #__yendifvideoshare_videos WHERE id=" . (int) $videoid;
    	 	$db->setQuery ( $query );
    	 	$result = $db->loadObject();
		 
		 	$count = $result ? $result->views + 1 : 1;	 
		 	$query = "UPDATE #__yendifvideoshare_videos SET views=".$count." WHERE id=" . (int) $videoid;
    	 	$db->setQuery ( $query );
		 	$db->query();
		 
		 	$session->set('yendif_videos', $ses_videos);
		}
		
	}
 public function gdprConsentYoutube( ) {
 
 	$html = '<div class="gdpr-consent-overlay">
					<div class="gdpr-overlay-content">
						<div class="gdprcookie-intro">
							<h1>'.JText::_('YENDIF_VIDEO_SHARE_PRIVSCY_POLICY').'</h1>
							 <p>'.JText::_('YENDIF_VIDEO_SHARE_GDPR_DESCRIPTION').'</p>
						</div>
						<div class="gdprcookie-buttons">
							<button type="button" class="yendifgdprConsent">'.JText::_('YENDIF_VIDEO_SHARE_ACCEPT_COOKIED').' </button>
						</div>
					</div>
				</div>';
	return $html;
	
 }

public function playlistBottomHeight( $playlistHeight ) {
	$document = JFactory::getDocument();
	$html = $document->addStyleDeclaration (' 
				.yendif-playlist-container .vjs-playlist.bottom {
					height:'. $playlistHeight .'px!important;
				}
			');
	return $html;

}

public function is_mobile(  ) {
	
	// detect mobile device
	$is_mobile = false;
	if( preg_match( '/iPhone|iPod|iPad|BlackBerry|Android/', $_SERVER['HTTP_USER_AGENT'] ) ) {
		$is_mobile = true;
	};
	
	return $is_mobile;

}


		
}
