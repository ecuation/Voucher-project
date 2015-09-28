<?php  
class ControllerCore extends BaseController
{
	public $resultsPerPage;

	public $defaultresultsNumber;

	public function __construct()
	{
		$this->defaultresultsNumber = 20;
		$this->setResultsPerPage();
		$this->resultsPerPage = (Session::has('results_per_page') ? Session::get('results_per_page') : $this->defaultresultsNumber);
	}

	public function setResultsPerPage()
	{
		if(isset($_GET['results']))
		{
			$results = intval($_GET['results']);
			$results_per_page = ($results == 0) ? $this->defaultresultsNumber : $results;
			Session::put('results_per_page', $results_per_page);	
		}			
	}


	public function getResultsPerPage()
	{
		return $this->resultsPerPage;
	}
}
?>