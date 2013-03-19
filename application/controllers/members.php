<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends Base_Controller {
	
	public function __construct()
	{
		parent::__construct();

		// Load the Member Model to be used by the whole controller.
		// CodeIgniter Function
		$this->load->model(array("Member", "Group"));

	}




	/**
	 * Index page
	 * @return [type] [description]
	 */
	public function index()
	{
		$data["members"]    = $this->Member->find_all();
		$data["main_content"] =	"members/index";

		$this->load->view("admin/template", $data);
	}





	/**
	 * Search items that varies with the search string
	 * @return [type] [description]
	 */
	public function search()
	{
		$request = array("name" => $this->input->get("search", TRUE));

		$data["members"]    = $this->Member->find_by($request);
		$data["main_content"] =	"members/index";

		$this->load->view("admin/template", $data);
	}





	/**
	 * Page for adding new content;
	 */
	public function add()
	{
		$data["groups"] = $this->Group->find_all();

		$data["main_content"] = "members/add";

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
		if(! isset($id) ) redirect("members", "location");
		
		// Get items via id field
		$member = $this->Member->find_by(array("id" => $id));

		// Fail Early if the query returns no item
		if ( is_null($member) ) {
			redirect("members", "location");
		}

		$data["edit"]          = TRUE;
		$data["member"]		   = $member;
		$data["groups"]        = $this->Group->find_all();
		$data["active_groups"] = $this->Group->get_group_ids($member);
		$data["main_content"]  = "members/edit";

		$this->load->view("admin/template", $data);

	}







	public function remove($id = NULL)
	{
		try {
			
			$this->Member->soft_delete((int) $id);
			
		} catch (Exception $e) {

			echo $e->getMessage();
			
			exit();

		}
			
		redirect("members", "location");	

	}






	// Page that handles the database transactions
	public function submit()
	{

		try {
			
			// Get the response from the model
			$this->Member->submit($this->input->post(NULL, TRUE));
			
		} catch (Exception $e) {
			
			echo $e->getMessage();

			exit();

		}

		redirect("members", "location");
	}






	// Bootstrap page
	public function bootstrap()
	{
		$this->load->model("Member");
		$response = $this->Member->bootstrap();

		echo $response ? "Bootstrap successful!" : "Failed";
	}

}

/* End of file positions.php */
/* Location: ./application/controllers/positions.php */