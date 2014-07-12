<?php
namespace OBList\domain;

class Pregnancy extends DomainObject
{
	//Patient patient
	protected $patient;
	//string first day of last menstrual period date, Y-M-D
	protected $lmp;
	//string estimated date of delivery date, Y-M-D
	protected $edd;
	//string 2 letter abbreviation rendering physician
	protected $physician;	
	//string 4 letter abbreviation planned hospital
	protected $plannedHospital;
	//string insurance
	protected $insurance;
	//string secondary insurance
	protected $secondaryInsurance;
	//float out of pocket
	protected $outOfPocket;
	//string group B strep status
	protected $groupBStrep;
	//string RH status
	protected $rh;
	//string problem list
	protected $problemList;
	//string problem list date updated Y-M-D
	protected $problemListDate;
	//string baby's sex (format F, M & FF, MF, MM etc. for multiples)
	protected $babySex;
	//LaborSignsCollection labor signs
	protected $laborSigns;
	//string status (none, upcoming, labor)
	protected $status;
	//Billable DomainObject resolution
	protected $resolution;
	//permissible statuses
	private static $statusArray = array('none', 'upcoming', 'labor', 'delivered', 'trans/mab');

	//constructor, returns Pregnancy
	function __construct(array $array) {
	if ( is_int($array['patient']) ) {
		//call mapper to instantiate
		}
		if ( get_class($array['patient']) == 'Patient' ) {
			$this->patient = $array['patient'];
		}
		$lmpString = (string) $array['lmp'];
		$this->lmp = date("Y-m-d", strtotime($array['lmpString']));
		$this->edd = date("Y-m-d",strtotime("+280 day",$this->lmp));
		$this->physician = $array['physician'];
		$this->insurance = $array['insurance'];
	}

	//destruct and delete via DBH void
	public function delete()
	{
		//
	}

	//get int id
	public function getId(){
		return $this->patientId;
	}
	//get lmp
	public function getLmp(){
		return $this->lmp;
	}
	//int get gestational age in weeks from lmp
	public function getGestationalAge(){
		//Return GETATIONPERIOD - (EDD - NOW)
	}
	//get edd
	public function getEdd(){
		return $this->edd;
	}
	//get physician
	public function getPhysician(){
		return $this->physician;
	}
	//get planned hospital
	public function getPlannedHospital(){
		if(isset($this->plannedHospital)){
			return $this->plannedHospital;
		}
		else{
			return 'None';
		}
	}
	//get insurance
	public function getInsurance(){
		return $this->insurance;
	}
	public function getSecondaryInsurance(){
		return $this->secondaryInsurance;
	}
	//get out of pocket
	public function getOutOfPocket(){
		return $this->outOfPocket;
	}
	//string get GroupBStrep status
	public function getGroupBStrep(){
		return $this->groupBStrep;
	}
	//string get RH status
	public function getRh(){
		return $this->rh;
	}
	//string get problem list
	public function getProblemList(){
		return $this->problemList;
	}
	//void set status
	public function setStatus($status){
		$lowerstatus = strtolower($status);
		if ( in_array($lowerstatus, $this->statusArray) ) {
			$this->status = $lowerstatus;
		}
}

