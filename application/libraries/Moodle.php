<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Moodle {
  var $token = '';  // Token to access Moodle server. Must be configured in Moodle. See readme.
  var $server = ''; // Moodle URL, for example http://localhost:8080.
  var $dir = null;    // Directory on the server. For example, /moodle. If your moodle runs as root, this is empty.
  var $error = '';    // Last error of the class. We'll write the last error here when something wrong happens.
 	
  // The init function initializes the variable of class (so that it can be used).
  function init($fields) {
    $this->token = $fields['token'];
    $this->server = $fields['server'];
    $this->dir = $fields['dir'];
  }
  
    // The getUser function obtains information for a Moodle user identified by its id.
  function getServiceInfo() {
	  
	$outPut = array();
	$response = array();
	  
  	$this->error = null;
	
  	// Create XML for the request. XML must be set properly for this to work.
    $request = xmlrpc_encode_request('core_webservice_get_site_info', array(array()), array('encoding'=>'UTF-8'));
    // var_dump($request);  // In case you want to see XML.
    
    $context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
    if($this->server && $this->dir) {
		$path = $this->server . $this->dir . "/webservice/xmlrpc/server.php?wstoken=" . $this->token;
		// Send XML to server and get a reply from it.
		$file = file_get_contents($path, false, $context); // $file is the reply from server.
		// Decode the reply.
		$response = xmlrpc_decode($file);
	}
    
    // This is our normal exit (returning an array of user properties).

    elseif(!empty($response['faultCode'])){
		$outPut['error'] = "error";
	}else{
		$outPut['success'] = $response;
	}
	
	return $outPut;

  }
  
  // The getUser function obtains information for a Moodle user identified by its id.
  function getUser($id) {
	  
	$outPut = array();  
	  
  	$this->error = null;
	
  	// Create XML for the request. XML must be set properly for this to work.
    $request = xmlrpc_encode_request('core_user_get_users_by_id', array(array($id)), array('encoding'=>'UTF-8'));
    // var_dump($request);  // In case you want to see XML.
    
    $context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
    
    $path = $this->server.$this->dir."/webservice/xmlrpc/server.php?wstoken=".$this->token;
    // Send XML to server and get a reply from it.
    $file = file_get_contents($path, false, $context); // $file is the reply from server.
    // Decode the reply.
    $response = xmlrpc_decode($file);
    
    // This is our normal exit (returning an array of user properties).
	
    if (!empty($response['faultCode'])){
		$outPut['error'] = "error";
	}else{
		$outPut['success'] = $response;
	}
	
	return $outPut;

  }
  

  
  // The createUser function tries to create a new Moodle user.
  function createUser($role_id,$para) {
	$outPut = array();
  	// Clear last error.
  	$this->error = null;
	$context = "";

    $request = xmlrpc_encode_request('core_user_create_users', $para, array('encoding'=>'UTF-8'));
	 
    $context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
    
 	$path = $this->server.$this->dir."/webservice/xmlrpc/server.php?wstoken=".$this->token;
    // Send XML to server and get a reply from it.
    $file = file_get_contents($path, false, $context); // $file is the reply from server.
    // Decode the reply.
    $response = xmlrpc_decode($file);

	// This is our normal exit (returning an array of user properties).
    if (!empty($response['faultCode'])){
		$outPut['error'] = "User not create due to some technical problem.";
	}else{
		$this->assign_role($role_id,$response[0]['id']);
		$outPut['success'] = $response;
	}
	
	return $outPut;

  } 
  
    // The createUser function tries to create a new Moodle user.
  function assign_role($role_id,$user_id) {
	 $outPut = array();
  	// Clear last error.
  	$this->error = null;
	$context = "";

	$studentPara = array(array(array(
		'roleid' => $role_id,
		'userid' => $user_id,
		'contextid' => 1,
		)));
    $request = xmlrpc_encode_request('core_role_assign_roles', $studentPara, array('encoding'=>'UTF-8'));
	 
    $context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
    
 	$path = $this->server.$this->dir."/webservice/xmlrpc/server.php?wstoken=".$this->token;
    // Send XML to server and get a reply from it.
    $file = file_get_contents($path, false, $context); // $file is the reply from server.
    // Decode the reply.
    $response = xmlrpc_decode($file);
	
	// This is our normal exit (returning an array of user properties).
    if (!empty($response['faultCode'])){
		$outPut['error'] = "error";
	}else{
		$outPut['success'] = $response;
	}
	
	return $outPut;

  } 

  // The createUser function tries to update an existing Moodle user.
  function updateUser($id,$fields) {
	$outPut = array();  
  	// Clear last error.
  	$this->error = null;
	$outPut = array();
	
  	
  	// Check if user exists.
  	$user = $this->getUser($id);
	
	if (!empty($user['error'])){
		$outPut['error'] = "User is not available into moodle.";
		return $outPut;
	}

  	// Create XML for the request. XML must be set properly for this to work.
    $request = xmlrpc_encode_request('core_user_update_users', $fields, array('encoding'=>'UTF-8'));
    // var_dump($request);  // In case you want to see XML.
    
    $context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
    
    $path = $this->server.$this->dir."/webservice/xmlrpc/server.php?wstoken=".$this->token;
    // Send XML to server and get a reply from it.
    $file = file_get_contents($path, false, $context); // $file is the reply from server.
    // Decode the reply.
    $response = xmlrpc_decode($file);

    // Note: lack of permissions on Moodle will get us an error.
    // moodle/user:update capability is required for web service account to call core_user_update_users.

	// This is our normal exit (returning an array of user properties).
    if (!empty($response['faultCode'])){
		$outPut['error'] = "User not update due to some technical problem.";
	}else{
		$outPut['success'] = true;
	}
	
	return $outPut;
	
  }
  
  
  // The deleteUser function tries to delete an existing Moodle user.
  function deleteUser($user_id) {
	$outPut = array();  
  	// Clear last error.
  	$this->error = null;
  	
  	// Check if user exists.
  	$user = $this->getUser($user_id);
	
  	if (!empty($user['error']) && $user['error']=='error'){
		$outPut['error'] = "User is not available into moodle.";
		return $outPut;
	}
  	  
  	// Create XML for the request. XML must be set properly for this to work.
  	$request = xmlrpc_encode_request('core_user_delete_users', array(array($user_id)), array('encoding' => 'UTF-8'));
    // var_dump($request);  // In case you want to see XML.
        
    $context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
    
    $path = $this->server.$this->dir."/webservice/xmlrpc/server.php?wstoken=".$this->token;
    // Send XML to server and get a reply from it.
    $file = file_get_contents($path, false, $context); // $file is the reply from server.
    // Decode the reply.
    $response = xmlrpc_decode($file);
     
    // This is our normal exit (returning an array of user properties).
    if (!empty($response['faultCode'])){
		$outPut['error'] = "User not delete due to some technical problem.";
	}else{
		$outPut['success'] = true;
	}
	
	return $outPut;

  }
  
    // The getCourse function obtains information for a Moodle course identified by its id.
  function getCategory($id="") {
	  $response = array();
	 $outPut = array(); 
  	// Clear last error.
  	$this->error = null;
    
	if(!empty($id)){
		// Create XML for the request. XML must be set properly for this to work.
		$courseids = array( $id );
		// $params = array('options'=>array('ids'=>$courseids)); // This does not work, gets us an exception inside Moodle.
		$params = array(array('ids'=>$courseids)); // This works.
	}else{
		$params = array(array()); // This works.
	}
	
	
  	$request = xmlrpc_encode_request('core_course_get_categories', $params, array('encoding'=>'UTF-8'));
    // var_dump($request);  // In case you want to see XML.
    
    $context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
    if($this->dir) {
		$path = $this->server . $this->dir . "/webservice/xmlrpc/server.php?wstoken=" . $this->token;
		// Send XML to server and get a reply from it.
		$file = file_get_contents($path, false, $context); // $file is the reply from server.
		// Decode the reply.
		$response = xmlrpc_decode($file);
	}


    // Note: lack of permissions on Moodle will get us an error.
    // Required capabilities for core_course_get_courses call:
    // moodle/course:view,moodle/course:update,moodle/course:viewhiddencourses
    // Make sure that your web service account role has those.
	// This is our normal exit (returning an array of user properties).
    if (!empty($response['faultCode'])){
		$outPut['error'] = "error";
	}else{
		$outPut['success'] = $response;
	}
	
	return $outPut;
  }
  
  // The getCourse function obtains information for a Moodle course identified by its id.
  function getCourse($id="") {
	 $response = array();
	 $outPut = array(); 
  	// Clear last error.
  	$this->error = null;
    
	if(!empty($id)){
		// Create XML for the request. XML must be set properly for this to work.
		$courseids = array( $id );
		// $params = array('options'=>array('ids'=>$courseids)); // This does not work, gets us an exception inside Moodle.
		$params = array(array('ids'=>$courseids)); // This works.
	}else{
		$params = array(array('ids'=>array())); // This works.
	}
  	$request = xmlrpc_encode_request('core_course_get_courses', $params, array('encoding'=>'UTF-8'));
    // var_dump($request);  // In case you want to see XML.
    
    $context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
	  if($this->dir) {
		  $path = $this->server . $this->dir . "/webservice/xmlrpc/server.php?wstoken=" . $this->token;
		  // Send XML to server and get a reply from it.
		  $file = file_get_contents($path, false, $context); // $file is the reply from server.
		  // Decode the reply.
		  $response = xmlrpc_decode($file);
	  }


    // Note: lack of permissions on Moodle will get us an error.
    // Required capabilities for core_course_get_courses call:
    // moodle/course:view,moodle/course:update,moodle/course:viewhiddencourses
    // Make sure that your web service account role has those.
	// This is our normal exit (returning an array of user properties).
    if (!empty($response['faultCode'])){
		$outPut['error'] = "error";
	}else{
		$outPut['success'] = $response;
	}
	
	return $outPut;
  }
  

  function getUserEnroll($id="") {
	  
	 $outPut = array(); 
  	$this->error = null;
    
	if(!empty($id)){
		// Create XML for the request. XML must be set properly for this to work.
		$courseids = array( $id );
		// $params = array('options'=>array('ids'=>$courseids)); // This does not work, gets us an exception inside Moodle.
		$params = array(array('ids'=>$courseids)); // This works.
	}else{
		$params = array( 51);
	}
  	$request = xmlrpc_encode_request('core_enrol_get_enrolled_users', $params, array('encoding'=>'UTF-8'));
    // var_dump($request);  // In case you want to see XML.
    
    $context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
    
    $path = $this->server.$this->dir."/webservice/xmlrpc/server.php?wstoken=".$this->token;
    // Send XML to server and get a reply from it.
    $file = file_get_contents($path, false, $context); // $file is the reply from server.
    // Decode the reply.
    $response = xmlrpc_decode($file);


    // Note: lack of permissions on Moodle will get us an error.
    // Required capabilities for core_course_get_courses call:
    // moodle/course:view,moodle/course:update,moodle/course:viewhiddencourses
    // Make sure that your web service account role has those.
	// This is our normal exit (returning an array of user properties).
    if (!empty($response['faultCode'])){
		$outPut['error'] = "error";
	}else{
		$outPut['success'] = $response;
	}
	
	return $outPut;
  }
  
  // The enrollUser function tries to enroll user in a course.
  function enrollUser($user_id, $course_id,$start_date,$end_date,$role_id,$suspend="") {
	$outPut = array();  
	$outPut = array();
  	// Clear last error.
  	$this->error = null;
	
	$EnrollData = array('roleid'=>$role_id,'userid'=>$user_id, 'courseid'=>$course_id);
	
	if(($start_date!='00-00-0000' || $end_date!='0000-00-00') && !empty($start_date)){
		$EnrollData['timestart'] = strtotime($start_date);
	}
	if(($end_date!='00-00-0000' || $end_date!='0000-00-00') && !empty($end_date)){
		$EnrollData['timeend'] = strtotime($end_date);
	}
	
	if(!empty($suspend)){
		$EnrollData['suspend'] = $suspend;
	}
	
	$params = array(array($EnrollData)); // roleid 5 is "student".
	



  	// Check whether user exists.
  	$user = $this->getUser($user_id);
  	if (!empty($user['error']) && $user['error']=='error'){
		$outPut['error'] = "User is not available into moodle.";
		return $outPut;
	}
 	
  	// Here, you may wish to check $user['enrolledcourses'] to see if a user is already enrolled in a course.
    
  	// Check whether course exists.
  	$course = $this->getCourse($course_id);

  	if (!empty($course['error']) && $course['error']=='error'){
		$outPut['error'] = "Course is not available into moodle.";
		return $outPut;
	}
  	// Create XML for the request. XML must be set properly for this to work.  This format was hard to figure out.
  	// I needed to debug the server code so see why method signatures did not match.
    
  	$request = xmlrpc_encode_request('enrol_manual_enrol_users', $params, array('encoding'=>'UTF-8'));
    // var_dump($request);  // In case you want to see XML.
    
  	$context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
    
    $path = $this->server.$this->dir."/webservice/xmlrpc/server.php?wstoken=".$this->token;
    // Send XML to server and get a reply from it.
    $file = file_get_contents($path, false, $context); // $file is the reply from server.
    // Decode the reply.
    $response = xmlrpc_decode($file);

    // This is our normal exit (returning an array of user properties).
    if (!empty($response['faultCode'])){
		$outPut['error'] = "User not enroll in course due to some technical problem.";
	}else{
		$outPut['success'] = true;
	}
	
	return $outPut;
  }
  
    // The unenrollUser function tries to unenroll user in a course.
  function unenrollUser($user_id, $course_id, $role_id) {
  	// Clear last error.
  	$this->error = null;

  	$user = $this->getUser($user_id);
  	if (!empty($user['error']) && $user['error']=='error'){
		$outPut['error'] = "User is not available into moodle.";
		return $outPut;
	}
 	
  	// Here, you may wish to check $user['enrolledcourses'] to see if a user is already enrolled in a course.
    
  	// Check whether course exists.
  	$course = $this->getCourse($course_id);

  	if (!empty($course['error']) && $course['error']=='error'){
		$outPut['error'] = "Course is not available into moodle.";
		return $outPut;
	}
	
  	// Create XML for the request. XML must be set properly for this to work.  This format was hard to figure out.
  	// I needed to debug the server code so see why method signatures did not match.
    $params = array(array(array('roleid'=>$role_id, 'userid'=>$user_id, 'courseid'=>$course_id))); // roleid 5 is "student".
  	$request = xmlrpc_encode_request('enrol_manual_unenrol_users', $params, array('encoding'=>'UTF-8'));
    // var_dump($request);  // In case you want to see XML.
    
  	$context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
    
    $path = $this->server.$this->dir."/webservice/xmlrpc/server.php?wstoken=".$this->token;
    // Send XML to server and get a reply from it.
    $file = file_get_contents($path, false, $context); // $file is the reply from server.
    // Decode the reply.
    $response = xmlrpc_decode($file);

  	
    // This is our normal exit (returning an array of user properties).
    if (!empty($response['faultCode'])){
		$outPut['error'] = "User not unenroll in course due to some technical problem.";
	}else{
		$outPut['success'] = true;
	}
	
	return $outPut;
  }
  
      // The createCourse function tries to CREATE COURSE INTO MOODLE.
  function createCourse($params) {
  	// Clear last error.
  	$this->error = null;

  	// Create XML for the request. XML must be set properly for this to work.  This format was hard to figure out.
  	// I needed to debug the server code so see why method signatures did not match.
    
  	$request = xmlrpc_encode_request('core_course_create_courses', $params, array('encoding'=>'UTF-8'));
    // var_dump($request);  // In case you want to see XML.
    
  	$context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
    
    $path = $this->server.$this->dir."/webservice/xmlrpc/server.php?wstoken=".$this->token;
    // Send XML to server and get a reply from it.
    $file = file_get_contents($path, false, $context); // $file is the reply from server.
    // Decode the reply.
    $response = xmlrpc_decode($file);
  	

    // This is our normal exit (returning an array of user properties).
    if (!empty($response['faultCode'])){
		$outPut['error'] = "Course not create due to some technical problem";
	}else{
		$outPut['success'] = $response;
	}
	
	return $outPut;
  }
  
        // The createCourse function tries to CREATE COURSE INTO MOODLE.
  function updateCourse($course_id,$params) {
  	// Clear last error.
  	$this->error = null;
	
	$course = $this->getCourse($course_id);
	
  	if (!empty($course['error']) && $course['error']=='error'){
		$outPut['error'] = "Course is not available into moodle.";
		return $outPut;
	}

  	// Create XML for the request. XML must be set properly for this to work.  This format was hard to figure out.
  	// I needed to debug the server code so see why method signatures did not match.
    
  	$request = xmlrpc_encode_request('core_course_update_courses', $params, array('encoding'=>'UTF-8'));
    // var_dump($request);  // In case you want to see XML.
    
  	$context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
    
    $path = $this->server.$this->dir."/webservice/xmlrpc/server.php?wstoken=".$this->token;
    // Send XML to server and get a reply from it.
    $file = file_get_contents($path, false, $context); // $file is the reply from server.
    // Decode the reply.
    $response = xmlrpc_decode($file);
  	

    // This is our normal exit (returning an array of user properties).
    if (!empty($response['faultCode'])){
		$outPut['error'] = "Course not update due to some technical problem.";
	}else{
		$outPut['success'] = true;
	}
	
	return $outPut;
  }
  
  // The Dekete Course function tries to DELETE COURSE INTO MOODLE.
  function deleteCourse($course_id,$params) {
  	// Clear last error.
  	$this->error = null;
	
	$course = $this->getCourse($course_id);
	
	if (!empty($course['error']) && $course['error']=='error'){
		$outPut['error'] = "Course is not available into moodle.";
		return $outPut;
	}

  	// Create XML for the request. XML must be set properly for this to work.  This format was hard to figure out.
  	// I needed to debug the server code so see why method signatures did not match.
    
  	$request = xmlrpc_encode_request('core_course_delete_courses', $params, array('encoding'=>'UTF-8'));
    // var_dump($request);  // In case you want to see XML.
    
  	$context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
    )));
    
    $path = $this->server.$this->dir."/webservice/xmlrpc/server.php?wstoken=".$this->token;
    // Send XML to server and get a reply from it.
    $file = file_get_contents($path, false, $context); // $file is the reply from server.
    // Decode the reply.
    $response = xmlrpc_decode($file);
  	

    // This is our normal exit (returning an array of user properties).
    if (!empty($response['faultCode'])){
		$outPut['error'] = "Course not delete due to some technical problem.";
	}else{
		$outPut['success'] = true;
	}
	
	return $outPut;
	
    //return $response['warnings'];
  }
  
   
  
}
?>