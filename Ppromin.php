<?php

/**
 * Action Ppromin 
 * 
 * Post Prom checkin
 * 
 * @link http://getfrapi.com
 * @author Frapi <frapi@getfrapi.com>
 * @link /ppromin/:id
 */
class Action_Ppromin extends Frapi_Action implements Frapi_Action_Interface
{

    /**
     * Required parameters
     * 
     * @var An array of required parameters.
     */
    protected $requiredParams = array();

    /**
     * The data container to use in toArray()
     * 
     * @var A container of data to fill and return in toArray()
     */
    private $data = array();

    /**
     * To Array
     * 
     * This method returns the value found in the database 
     * into an associative array.
     * 
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Default Call Method
     * 
     * This method is called when no specific request handler has been found
     * 
     * @return array
     */
    public function executeAction()
    {
        return $this->toArray();
    }

    /**
     * Get Request Handler
     * 
     * This method is called when a request is a GET
     * 
     * @return array
     */
    public function executeGet()
    {
        return $this->toArray();
    }

    /**
     * Post Request Handler
     * 
     * This method is called when a request is a POST
     * 
     * @return array
     */
    public function executePost()
    {
	$db = Frapi_Database::getInstance();
        $id = $this->getParam('id');
        $chckin = date('Y-m-d H:i:s');
	$result = $db->query("SELECT TIMESTAMPDIFF(MINUTE, prom_checkout,'".$chckin."') as ttdiff FROM tbl_tickets WHERE id='".$id."'");
	$n = $result->fetch(PDO::FETCH_ASSOC);
	if($n['ttdiff'] > 40){
	    $results = $db->query("SELECT * FROM tbl_tickets WHERE id='".$id."'");
            $row = $results->fetch(PDO::FETCH_ASSOC);
            $this->data['name'] = $row['name'];
	    $this->data['excuse'] = "Cannot checkin past the 40 minute time limit";
	} else { 
            if($db->exec("UPDATE tbl_tickets SET pprom_checkin = '".$chckin."' WHERE id='".$id."'")){
            	$results = $db->query("SELECT * FROM tbl_tickets WHERE id='".$id."'");
            	$row = $results->fetch(PDO::FETCH_ASSOC);
            	$this->data['name'] = $row['name'];
            	$this->data['success']=1;
            } else {
            	$this->data['success']=0;
            }
	}
        return $this->toArray();
    }

    /**
     * Put Request Handler
     * 
     * This method is called when a request is a PUT
     * 
     * @return array
     */
    public function executePut()
    {
        return $this->toArray();
    }

    /**
     * Delete Request Handler
     * 
     * This method is called when a request is a DELETE
     * 
     * @return array
     */
    public function executeDelete()
    {
        return $this->toArray();
    }

    /**
     * Head Request Handler
     * 
     * This method is called when a request is a HEAD
     * 
     * @return array
     */
    public function executeHead()
    {
        return $this->toArray();
    }


}
