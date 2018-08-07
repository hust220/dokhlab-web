<?php

class htmlElement {
	var $type;
	var $attributes;
	var $self_closers;

	/* Constructor */
	function htmlElement($type, $self_closers=array('img','br','hr','input','meta','link','option')) {
		$this->type = strtolower($type);
		$this->self_closers = $self_closers;
	}
	function setAttribute($attribute, $value='') {
		if(!is_array($attribute)) {
			$this->attributes[$attribute] = $value;
		} else {
			$this->attributes = array_merge($this->attributes,$attribute);
		}
	}
	function getAttribute($attribute) {
		return $this->attributes[$attribute];
	}
	function clearAttributes() {
		$this->attributes = array();
	}
	function removeAttribute($attribute) {
		if(isset($this->attributes[$attribute])) unset($this->attributes[$attribute]);
	}
	function addInnerHTML($object) {
		if(get_class($object) == __class__) {
			$this->attributes['text'] .= $object->buildElement();
		}
	}
	function buildElement() {
		//Start build
		$build = "<".$this->type;

		//Add Attributes
		if(count($this->attributes)) {
			foreach ($this->attributes as $att=>$val):
				if($att != 'text') $build .= ' '.$att.'="'.$val.'"';
			endforeach;
		}

		//End build
		if(!in_array($this->type, $this->self_closers)) {
			$build .= '>'.$this->attributes['text'].'</'.$this->type.'>';
		} else {
			$build .= '/>';
		}

		//Return build tag
		return $build;
	}
	function showElement() {
		echo $this->buildElement();
	}
};
?>
