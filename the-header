### Instace of class PagePermissions for `SEO` 
    $Obj_PageType = new MetaData($conn);

    /*
     *   Check if current page is identified as non-dynamic (__StaticPage__) or not. 
     *   if not, then treat it as dynamic page
     */
    
	$StaticPages = $Obj_PageType->StaticPages();
	
	
    if($StaticPages === null){
        // checking dynamic pages
       $ID = (isset($_GET['id'])) && !empty($_GET['id']) ? htmlspecialchars((int)$_GET['id']) : 0;
        // check article from id and send object to $get
       $G = $Obj_PageType->GetTitle('clients', $ID);
        // check if class has any errors, if so then stop the page with 404
        $error = $Obj_PageType->checkErrors();
        //if not errors are found, then extract details from the $get var
		$error ;
		
		$M['title'] = $G['company'];
		$M['keywords'] = $G['tel'].' '.$G['email'].' '.$G['company'];
		$M['content'] = $G['company'].' '.$G['about'];
		$M['address'] = $G['email'].$G['tel'].' '.$G['email'];
    
    }else{
        // if page is static, just display the costumized meta data
        $G = $Obj_PageType->GetMetaData();
		$M = []; // Meta data
		
		$M['title'] = $G[0];
		$M['keywords'] = $G[1]['keywords'];
		$M['content'] = $G[2]['content'];
	
    }
?>
<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> -->
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
	<meta name="robots" content="index, follow" />
	<meta name="description" content="<?php echo $M['content']; ?> " />
	<meta name="keywords" content="<?php echo $M['keywords']; ?>" />
	<meta name="REVISIT-AFTER" content="15 DAYS" />
	<link rel='stylesheet' href='<?php echo URI ?>/styles/style.css' type='text/css' media='screen' />
	<meta name="viewport" content="width=device-width initial-scale=1.0, user-scalable=yes" />
	<title><?php echo $M['title'] ?>  </title>
</head> 
