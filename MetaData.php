<?php

 /*
 	This script is supposed to save a lot of headaches that comes with managing a meta data for 
 	slightly dynamic sites. By installing this file, and custme-editing few lines of configurations, you 
 	will be able to run a simple static / blog website without having to worry about what to put inside 
 	<head></head> elements. 
 
 */
 
 class MetaData{
	protected $conn;
	private $errors = [];
	public  $PageMetaData;
	public $SiteName = ' | Mysite.com';

     function __construct($conn){
         $this->conn = $conn;
     }


	 
     /*
      * PageMetaData holds list of static pages, and title, keyword tags, and content for each of them
      * Whenever using this class for new project, only these details need to be changed.
      */

	  // All static pages/URIs 
	function PageMetaData(){
		$Allowed_Static_Pages = [
			'index.php', 
			'category.php', 
			'search.php', 
			'page.php?q=about', 
		 ];	
		 // And their, costume title
        	 $Static_Page_Titles = [
			'Mysite.com - A Business Listing Directory',
			'Category | Search Companies By Their Categories ',
			'Search | Find The Business You Are Looking For ',
			'About | About Mysite.com & More.. ',
      		  ];
		// One tag, for the all above static pages
		$Static_Page_Keywords = [
			'keywords'=>'this, is, where, your, keywords, go, seperated, by, comma'];
		// One content description, for the above static pages
		$Static_Page_Content = [
			'content'=>'This is where your "content" of your site goes'];
			
         return = [$Allowed_Static_Pages, $Static_Page_Titles, $Static_Page_Keywords, $Static_Page_Content];
          
     }
	 
	 
	 #### Below file should be left as-is unless, for extending the functionality of this script ###

	// Will check if current PHP_SELF/REQUEST_URI page contains any of the 'Allowed_Static_Pages' in PageMetaData(), and send the key
    function StaticPages(){
            $StaticPages = $this->PageMetaData()[0];
        for($i=0; $i < count($StaticPages); $i++){
            if(strpos($_SERVER['REQUEST_URI'], $StaticPages[$i]) || strpos($_SERVER['PHP_SELF'], $StaticPages[$i])){
                return $i; break;
            }
        }
    }

	// After getting page's array key value, this will fetch page's title, keyword, content
    function GetMetaData(){
        $PageKey = $this->StaticPages();
        $Page_Title = $this->PageMetaData()[1][$PageKey].$this->SiteName;
        $Page_Keywords = $this->PageMetaData()[2];
        $Page_Content = $this->PageMetaData()[3];
		return [$Page_Title, $Page_Keywords, $Page_Content];
    }



    /*
     * This is seperate method for dynamic pages
     * It gets data from db, based on the current ID
     * if data is not found, it will pass on an error
     */
     function GetTitle($table, $id){
         
	try{  $stmt = $this->conn->prepare("SELECT * FROM $table WHERE id = ? ");
              $stmt->execute(array($id));
           }catch (PDOException $e){
               return $this->errors = 'Unknown error!';
           }
		
		
        if($stmt->rowCount() === 0){
             return $this->errors = 'This page can not be found, please try another link later' ;
         }

         foreach($stmt as $each){
             return $each; # substring needs to be implemented
         }
     }

    /*
     * If errors are found during db, querying then this method will give ~404 error
     */
     function checkErrors(){
         if(!empty($this->errors)){
             die('<h1>  Not Found!! </h1> The requested address: <b>'.$_SERVER["REQUEST_URI"].'</b> was not found. <i>'.$this->errors.'</i>');
         }else{
             return false;
         }
     }
 }
?>
