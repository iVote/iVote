<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Positions extends Base_Controller {
	
	public function __construct()
	{
		parent::__construct();

		// Load the Position Model to be used by the whole controller.
		// CodeIgniter Function
		$this->load->model(array("Position", "Group"));

	}




	/**
	 * Index page
	 * @return [type] [description]
	 */
	public function index()
	{
		$data["positions"]    = $this->Position->find_all();
		$data["main_content"] =	"positions/index";

		$this->load->view("admin/template", $data);
	}





	/**
	 * Search items that varies with the search string
	 * @return [type] [description]
	 */
	public function search()
	{
		$request = array("title" => $this->input->get("search", TRUE));

		$data["positions"]    = $this->Position->find_by($request);
		$data["main_content"] =	"positions/index";

		$this->load->view("admin/template", $data);
	}





	/**
	 * Page for adding new content;
	 */
	public function add()
	{
		$data["groups"] = $this->Group->find_all();

		$data["main_content"] = "positions/add";

		$this->load->view("admin/template", $data);
	}






	/**
	 * Edit content based on the id given in the url
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function edit($id)
	{
		// Fail Early Validation
		if(! isset($id) ) redirect("positions", "location");
		
		// Get items via id field
		$position = $this->Position->find_by(array("id" => $id));

		// Fail Early if the query returns no item
		if ( is_null($position) ) {
			redirect("positions", "location");
		}

		$data["edit"]          = TRUE;
		$data["position"]      = $position;
		$data["groups"]        = $this->Group->find_all();
		$data["active_groups"] = $this->Group->get_group_ids($position);
		$data["main_content"]  = "positions/edit";

		$this->load->view("admin/template", $data);

	}







	public function remove($id = NULL)
	{
		try {
			
			$this->Position->soft_delete((int) $id);
			
		} catch (Exception $e) {

			echo $e->getMessage();
			
			exit();

		}
			
		redirect("positions", "location");	

	}






	// Page that handles the database transactions
	public function submit()
	{

		try {
			
			// Get the response from the model
			$this->Position->submit($this->input->post(NULL, TRUE));
			
		} catch (Exception $e) {
			
			echo $e->getMessage();

			exit();

		}

		redirect("positions", "location");
	}






	// Bootstrap page
	public function bootstrap()
	{
		$this->load->model("Position");
		$response = $this->Position->bootstrap();

		echo $response ? "Bootstrap successful!" : "Failed";
	}

}

/* End of file positions.php */
/* Location: ./application/controllers/positions.php */