<?php

namespace SFW\Route;

use SFW\Core;

abstract class Route {
	
	private $action;
	
	public function __construct( callable $action ) {
		$this->action = $action;
	}
	
	public abstract function identifier() : string;
	
	protected abstract function routable( string $path, string $bpath ) : ?array;
	
	public function try_route( string $path, string $bpath ) : bool {
		
		if ( ( $vars = $this->routable($path, $bpath) ) != null ) {
			return $this->action($vars);
		}
		
		return false;
		
	}
	
	// Predefined callbacks
	
	public static function cb_send_app_page( string $page ) : callable {
		
		return function( $vars ) use ( $page ) {
			Core::print_page($page, $vars);
		};
		
	}
	
	public static function cb_send_static_ouput() : callable {
		
		return function( $vars ) {
			
			Core::use_static_resource( $vars[0], function( $res ) {
				fpassthru($res);
			} );
			
		};
		
	}
	
}