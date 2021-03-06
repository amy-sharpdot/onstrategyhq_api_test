<?php
	/*
		The purpose of this (very generic) class is to test the existing APIs for "correctness" for both valid/invalid parameters. "correctness" for valid params is a 200 and a success message. "correctness" for invalid params is a 401 and a error code.

		************************************************************************************************
			NOTES:	 

			1) The "apiKey" must be valid for tests to work correctly.
			2) The "apiKey_invalid" can be any value (other than a valid key obviously).
			3) Ensure curl is installed on your server or tests will fail.
			4) Tests take a while to run, uncomment those you want to run.
		************************************************************************************************			
	*/

	//Max execution time
	set_time_limit(300);

	//Instantiate the api tester object.
	$apiTester = new ApiTester();

	class ApiTester{


		var $testResultsArray = array(),
			$apiKey = "",
			$apiKey_invalid = "This is an invalid api key!";


		/*
			Constructor will serve as the "main" function
		*/
		function __construct(){

			//uncomment to test...

			//Account calls

			//$this->accounts(true);
			//$this->accounts(false);

			//Department calls

			//$this->departmentLists(true);
			//$this->departmentLists(false);

			//$this->departmentInfo(true);
			//$this->departmentInfo(false);

			//$this->stepsByDepartmentList(true);
			//$this->stepsByDepartmentList(false);			

			//$this->stepInfoByDepartment(true);
			//$this->stepInfoByDepartment(false);

			//User calls

			//$this->usersList(true);
			//$this->usersList(false);

			//$this->usersInfo(true);
			//$this->usersInfo(false);

			//Goals calls

			//$this->goalLists(true);
			//$this->goalLists(false);

			//$this->goalListsDetail(true);
			//$this->goalListsDetail(false);

			$this->goalInfo(true);
			//$this->goalInfo(false);

			$this->goalInfoDetail(true);
			//$this->goalInfoDetail(false);

			$this->kpiList(true);
			//$this->kpiList(false);
			
			$this->kpiListDetail(true);
			//$this->kpiListDetail(false);

			//Steps Calls
			
			$this->stepsList(true);
			//$this->stepsList(false);

			$this->stepsInfo(true);
			//$this->stepsInfo(false);

			//Print raw output from tests.
			//TO DO: If time permits create a pretty HTML table.
			print_r(json_encode($this->testResultsArray));
		}

		/*
			- Evaluate the api response json.
			- Add results to global test results array.
		*/
		function processResponse($apiEndpoint, $apiResponseJson, $useValidKey){
			
			$apiResponseArray = json_decode($apiResponseJson, true);

			/*
				NOTE: 

				When $useValidKey == true we are testing the success path. The api
				should send a 200 HTTP response code and a message of "Success".

				When $useValidKey == false we are testing the failure path. The api should send
				an error code and a 401 error code.
			*/

			if($useValidKey){
				if($apiResponseArray["status"] == 200 && $apiResponseArray["message"] == "Success"){
					$this->testResultsArray[] = array(	"Api Endpoint" => $apiEndpoint, 
												"Valid Api Key" => $useValidKey, 
												"Expected Ouput" => "Yes");
				}
				else{
					$this->testResultsArray[] = array(	"Api Endpoint" => $apiEndpoint, 
												"Valid Api Key" => $useValidKey, 
												"Expected Ouput" => "No");				
				}
			}
			else{
				if($apiResponseArray["status"] == 401 && $apiResponseArray["code"] != ""){
					$this->testResultsArray[] = array(	"Api Endpoint" => $apiEndpoint, 
												"Valid Api Key" => $useValidKey, 
												"Expected Ouput" => "Yes");
				}
				else{
					$this->testResultsArray[] = array(	"ApiEndpoint" => $apiEndpoint, 
												"Valid Api Key" => $useValidKey, 
												"Expected Ouput" => "No");				
				}
			}
		}	

		/*
			Testing accounts api call.
		*/
		function accounts($useValidKey){

			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}
			
			$url = "http://apidev.onstrategyhq.com/api/accounts.json";
			$data = json_encode(array('key'=>$apiKey));
			$curl = curl_init($url);
   			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
   			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
   			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
   			$curl_response = curl_exec($curl);
   			curl_close($curl);

   			$this->processResponse("Accounts Call", $curl_response, $useValidKey);
		}

		/*
			Testing department list api call.

			Error in documentation: $json_data should be $data
		*/
		function departmentLists($useValidKey){
		
			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}

			$url = "http://apidev.onstrategyhq.com/api/departments.json";
			$data = json_encode(array('key'=>$this->apiKey));
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$curl_response = curl_exec($curl);
			curl_close($curl);

			$this->processResponse("Department Lists", $curl_response, $useValidKey);
		}

		/*
			Testing department info api call.
		*/
		function departmentInfo($useValidKey){
		
			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}

			$url = "http://apidev.onstrategyhq.com/api/departments/98.json";
			$data = json_encode(array('key'=>$this->apiKey));
			$curl = curl_init($url);
   			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
   			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
   			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
   			$curl_response = curl_exec($curl);
   			curl_close($curl);

   			$this->processResponse("Department Info", $curl_response, $useValidKey);
		}

		/*
			Testing steps by department list api call.

			This call is listed twice on the documentation page.
		*/
		function stepsByDepartmentList($useValidKey){

			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}

			$url = "http://apidev.onstrategyhq.com/api/departments/98/steps.json";
			$data = json_encode(array('key'=>$apiKey));
			$curl = curl_init($url);
   			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
   			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
   			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
   			$curl_response = curl_exec($curl);
   			curl_close($curl);

			$this->processResponse("Steps By Department List", $curl_response, $useValidKey);
		}

		/*
			Testing step info by department api call.
		*/
		function stepInfoByDepartment($useValidKey){
			
			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}

			$url = "http://apidev.onstrategyhq.com/api/departments/98/steps/calendar.json";
			$data = json_encode(array('key'=>$apiKey));
			$curl = curl_init($url);
   			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
   			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
   			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
   			$curl_response = curl_exec($curl);
   			curl_close($curl);

			$this->processResponse("Step Info By Department", $curl_response, $useValidKey);			
		}

		/*
			Testing users list api call.
		*/
		function usersList($useValidKey){

			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}

			$url = "http://apidev.onstrategyhq.com/api/users.json";
			$data = json_encode(array('key'=>$apiKey));
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$curl_response = curl_exec($curl);
			curl_close($curl);

			$this->processResponse("Users List", $curl_response, $useValidKey);			
		}

		/*
			Testing users info api call.
		*/
		function usersInfo($useValidKey){

			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}
	
			$url = "http://apidev.onstrategyhq.com/api/users/9.json";
			$data = json_encode(array('key'=>$apiKey));
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$curl_response = curl_exec($curl);
			curl_close($curl);

			$this->processResponse("Users Info", $curl_response, $useValidKey);			
		}

		/*
			Testing goal lists api call.
		*/
		function goalLists($useValidKey){

			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}

			$url = "http://apidev.onstrategyhq.com/api/goals.json";
			$data = json_encode(array('key'=>$apiKey));
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$curl_response = curl_exec($curl);
			curl_close($curl);

			$this->processResponse("Goal Lists", $curl_response, $useValidKey);			
		}

		/*
			Testing goal lists detail api call.
		*/
		function goalListsDetail($useValidKey){

			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}

			$url = "http://apidev.onstrategyhq.com/api/goals_detail.json";
			$data = json_encode(array('key'=>$apiKey));
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$curl_response = curl_exec($curl);
			curl_close($curl);

			$this->processResponse("Goal Lists Detail", $curl_response, $useValidKey);			
		}

		/*
			Testing goal info api call.
		*/
		function goalInfo($useValidKey){
			
			//Returned from Goal List Detail
			$id = "26";

			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}

			$url = "http://apidev.onstrategyhq.com/api/goals/" .$id. ".json";
			$data = json_encode(array('key'=>$apiKey));
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$curl_response = curl_exec($curl);
			curl_close($curl);
			
			$this->processResponse("Goal Info", $curl_response, $useValidKey);			
		}

		/*
			Goal is listed but no documentation on this call.
			This call may have been deprecated or could be a call to be implemented.
		*/
		function goalInfoDetail($useValidKey){}

		/*
			Testing kpi list api call.
		*/
		function kpiList($useValidKey){

			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}

			$url = "http://apidev.onstrategyhq.com/api/goals/kpis.json";
			$data = json_encode(array('key'=>$apiKey));
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$curl_response = curl_exec($curl);
			curl_close($curl);

			$this->processResponse("KPI List", $curl_response, $useValidKey);			
		}

		/*
			Testing kpi list detail api call.

			Failed. 

			HTTP response code: 404,
			Status code: 1004,
			Message: "Not Found"
		*/
		function kpiListDetail($useValidKey){

			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}

			$url = "http://apidev.onstrategyhq.com/api/goals_details/kpis.json";
			$data = json_encode(array('key'=>$apiKey));
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$curl_response = curl_exec($curl);
			curl_close($curl);

			$this->processResponse("KPI List Detail", $curl_response, $useValidKey);			
		}

		/*
			Testing steps list api call.
		*/
		function stepsList($useValidKey){

			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}

			$url = "http://apidev.onstrategyhq.com/api/steps.json";
			$data = json_encode(array('key'=>$apiKey));
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$curl_response = curl_exec($curl);
			curl_close($curl);

			$this->processResponse("Steps List", $curl_response, $useValidKey);			
		}

		/*
			Testing steps info api call.
		*/
		function stepsInfo($useValidKey){

			$apiKey = $this->apiKey;

			if($useValidKey == false){
				$apiKey = $this->apiKey_invalid;
			}

			$url = "http://apidev.onstrategyhq.com/api/steps/opportunities.json";
			$data = json_encode(array('key'=>$apiKey));
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$curl_response = curl_exec($curl);
			curl_close($curl);

			$this->processResponse("Steps Info", $curl_response, $useValidKey);			
		}

		/*
			The misc calls has no endpoints. There is a note on this page
			that says "Update Me!".
		*/
		function misc($useValidKey){}
	}
?>
