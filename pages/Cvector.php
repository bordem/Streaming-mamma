<?php			
			////////////////////////////////////
            //CLASS vector , tableau dynamique//
            ////////////////////////////////////
            class vector {
                private $_arrayList=array();
                private $_arrayList2=array();
               	private $_tailleTableau=0;
               
                public function add($data,$data2) {
                    $this->_arrayList[$this->_tailleTableau]=$data;
                    $this->_arrayList2[$this->_tailleTableau]=$data2;
                    $this->_tailleTableau++;
                }
                public function size(){
                	return $this->_tailleTableau;
                }
                public function getTab(){
                	return $this->_arrayList;
                }
                public function at1($i){
                	return $this->_arrayList[$i];
                }
                public function at2($i){
                	return $this->_arrayList2[$i];
                }
                public function set($i,$data,$data2){
                	$this->_arrayList[$i]=$data;
                	$this->_arrayList2[$i]=$data2;
                }
            } 
?>
