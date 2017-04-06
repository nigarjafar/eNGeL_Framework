<?php

class Pagination implements Iterator{
    public $itemsCount;
	public $itemsPerPage;
	public $items=array();

	public function __construct($itemsPerPage,$itemsCount){
		$this->itemsPerPage=$itemsPerPage;
        $this->itemsCount=$itemsCount;
	}


	public function setItems($items){
		if (is_array($items)) {
            $this->items = $items;
        }
	}

	public function offset(){
		

		$offset =($this->getPage()-1)*$this->itemsPerPage;
		return $offset;
	}

	public function fullLinks(){

    $page=$this->getPage();
    echo '<div class="pagination p12">';
      echo "<ul>";
            if ($page==1)
                echo '<a class="direction non-clickable" href="#"><li><</li></a>';
            else
                echo '<a class="direction" href="?page='.($page-1).'"><li><</li></a>';

            for($i=1;$i<=$this->getPageCount();$i++){
                if($i==$page)
                    echo '<a class="is-active" href="?page='.$i.'"><li>'.$i.'</li></a>';
                else
                    echo '<a href="?page='.$i.'"><li>'.$i.'</li></a>';
        } 
            if ($page==$this->getPageCount())
                echo '<a class="direction non-clickable" href="#"><li>></li></a>';
            else
                echo '<a class="direction" href="?page='.($page+1).'"><li>></li></a>';

      echo "</ul>";
    echo "</div>";
        
	}

    public function SimpleLinks(){

    $page=$this->getPage();
    echo '<div class="pagination p12">';
      echo "<ul>";
            if ($page==1)
                echo '<a class="direction non-clickable" href="#"><li><</li></a>';
            else
                echo '<a class="direction" href="?page='.($page-1).'"><li><</li></a>';
        
            if ($page==$this->getPageCount())
                echo '<a class="direction non-clickable" href="#"><li>></li></a>';
            else
                echo '<a class="direction" href="?page='.($page+1).'"><li>></li></a>';

      echo "</ul>";
    echo "</div>";
        
    } 

    public function numberLinks(){

       $page=$this->getPage();
    echo '<div class="pagination p12">';
      echo "<ul>";
            for($i=1;$i<=$this->getPageCount();$i++){
                if($i==$page)
                    echo '<a class="is-active" href="?page='.$i.'"><li>'.$i.'</li></a>';
                else
                    echo '<a href="?page='.$i.'"><li>'.$i.'</li></a>';
            } 

      echo "</ul>";
    echo "</div>";
        
    }

    public function getPageCount(){
        
        return   ceil($this->itemsCount/$this->itemsPerPage);
     
    }

    public function getPage(){
        if(isset($_GET['page']))
            return $page= $_GET['page'];
        else
            return $page=1;
    }
  

    public function rewind()
    {
        reset($this->items);
    }
  
    public function current()
    {
        return  current($this->items);
        
    }
  
    public function key() 
    {
        return key($this->items);
      
    }
  
    public function next() 
    {
        return next($this->items);
    }
  
    public function valid()
    {
        $key = key($this->items);
       	return ($key !== NULL && $key !== FALSE);
    }


	


}