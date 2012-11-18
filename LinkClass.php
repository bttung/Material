<?php 
class linkClass {
	private $url, $query, $label;	
    function __construct($url, $query, $label) {
    	$this->url = $url;
        $this->query = $query;
		$this->label = $label;		
        echo "<p><a href=\"$this->url?$this->query\"> $this->label</a></p>";
    }			
}
class deleteLinkClass {
	private $url, $query;   
    function __construct($url, $query) {
    	$this->url = $url;
        $this->query = $query;
        echo "<p><a href=$this->url?$this->query onClick=\"return confirm('are you sure ?')\" >Delete</a></p>";
    }
}
?>