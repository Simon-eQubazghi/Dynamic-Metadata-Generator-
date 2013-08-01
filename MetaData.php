<?php

 # Heps with URI's structed:
  # page.php (single pages)
	# page.php?action=foo (with action params)
	# page.php?id=foo (with action params)
 
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
			'page.php?q=register', 
			'page.php?q=contact', 
			'page.php?q=login',
			'page.php?q=LoggedIn',
			'page.php?q=logout',
			'page.php?q=update'
		 ];
		 // And their, costume title
         $Static_Page_Titles = [
			'Mysite.com - A Business Listing Directory',
			'Category | Search Companies By Their Categories ',
			'Search | Find The Business You Are Looking For ',
			'About | About Mysite.com & More.. ',
			'Register | Register Your Bussiness Fast & Free, Today! ',
			'Contact | Any Questions?, Contact Mysite.com Today ',
			'Login | Update Your Business Infromation, Read Your Messages & More',
			'Mysite.com - An Ethiopian Business Listing Directory',
			'Mysite.com - An Ethiopian Business Listing Directory',
			'Mysite.com - An Ethiopian Business Listing Directory',
        ];
		// One tag, for the all above static pages
		$Static_Page_Keywords = [
			'keywords'=>'Mysite.com, Mysite.com business, Mysite.com business, company in Mysite.com, trade, export, Mysite.com'];
		// One content description, for the above static pages
		$Static_Page_Content = [
			'content'=>'an country's business directory. | List your business Free!! and Find, 
			country's based companies/businesses, Mysite.com'];
			
         $Attach = [$Allowed_Static_Pages, $Static_Page_Titles, $Static_Page_Keywords, $Static_Page_Content];
         return $Attach;
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
               return $this->errors = 'There seems to be a problem with your query, please try again';
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
