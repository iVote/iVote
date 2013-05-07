<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends Base_Controller {
	
	public function __construct()
	{
		parent::__construct();

		// Load the Group Model to be used by the whole controller.
		// CodeIgniter Function
		$this->load->model("Group");

	}




	/**
	 * Index page
	 * @return [type] [description]
	 */
	public function index()
	{
		$data["groups"]    = $this->Group->find_all(array('name' => 'ASC'));
		$data["main_content"] =	"groups/index";

		$this->load->view("admin/template", $data);
	}





	/**
	 * Search items that varies with the search string
	 * @return [type] [description]
	 */
	public function search()
	{
		$request = array("name" => $this->input->get("search", TRUE));

		$data["groups"]    = $this->Group->find_by($request, TRUE);
		$data["main_content"] =	"groups/index";

		$this->load->view("admin/template", $data);
	}





	/**
	 * Page for adding new content;
	 */
	public function add()
	{
		$this->submit();

		$data["main_content"] = "groups/add";

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
		if(! isset($id) ) redirect("groups", "location");
		
		// Get items via id field
		$group = $this->Group->find_by(array("id" => $id));

		// Fail Early if the query returns no item
		if ( empty($group) ) {
			redirect("groups", "location");
		}

		$this->submit();

		// For displaying inputs purposes
		if(!validation_errors())
			$data["edit"]		= TRUE;
		
		$data["id"]				= $id;
		$data["group"]			= $group;
		$data["main_content"]	= "groups/edit";

		$this->load->view("admin/template", $data);

	}







	public function remove($id = NULL)
	{
		try {
			
			$this->Group->soft_delete((int) $id);
			
		} catch (Exception $e) {

			echo $e->getMessage();
			
			exit();

		}
			
		redirect("groups", "location");	

	}






	// Page that handles the database transactions
	public function submit()
	{

		try {

			$data = $this->input->post(NULL, TRUE);

			// Run Validation
			if( !$this->Group->validate($data) )
				return false;

			// Get the response from the model
			$this->Group->submit($data);
			
		} catch (Exception $e) {
			
			echo $e->getMessage();

			exit();

		}

		redirect("groups", "location");
	}






	// Bootstrap page
	public function bootstrap()
	{
		$this->load->model("Group");
		$response = $this->Group->bootstrap();

		echo $response ? "Bootstrap successful!" : "Failed";
	}
	
}

/* End of file groups.php */
/* Location: ./application/controllers/groups.php */