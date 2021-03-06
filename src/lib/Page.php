<?php

namespace SFW;

use \ArrayAccess;

final class Page implements ArrayAccess {
    
    public $raw;
    public $identifier;
    public $directory;
    
    public $template_identifier;
    public $template_directory;
    
    public $data = [];
    
    public function __construct($raw, $identifier) {
        
        $this->raw = $raw;
        $this->identifier = $identifier;
        
        $this["title"] = $identifier;
        
    }
    
    public function has_template() {
        return $this->template_identifier !== null;
    }
    
    public function page_part_path( string $part_id ) {
        return Utils::path_join( $this->directory, $part_id . ".php" );
    }
    
    public function template_part_path( string $part_id ) {
        if ( !$this->has_template() ) return null;
        return Utils::path_join( $this->template_directory, $part_id . ".php" );
    }

	public function offsetExists($offset) {
    	return isset($this->data[$offset]);
	}

	public function &offsetGet($offset) {
		return $this->data[$offset];
	}

	public function offsetSet($offset, $value) {
		$this->data[$offset] = $value;
	}

	public function offsetUnset($offset) {
    	unset($this->data[$offset]);
	}
}

?>