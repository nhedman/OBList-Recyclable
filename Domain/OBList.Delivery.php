<?php
class Delivery extends DomainObject implements Billable
{
	private $deliveryDate;
	private $md;
	private $hospital;
	private $billed=false;
	private $dateBilled=null;
	private $pregnancy;

	function __construct( array $array ) {
		if (isset($array['id']) ){
			$this->id = $array['id'];
		}
		$this->hospital = $array['hospital'];
		$this->deliveryDate = $array['deliveryDate'];
		if (isset($array['billed']) {
			$this->billed = $array['billed'];
		}
		if (isset($array['dateBilled']) {
			$this->dateBilled = $array['dateBilled'];
		}
		if ( isset($array['pregnancy'] )  {
			if ( is_int($array['pregnancy']) ) {
				$idobj = new IdentityObject( 'Pregnancy' );
				$idobj->field('id')->eq($id);
				$this->pregnancy = PregnancyObjectFactory->createObject( DomainObjectAssembler::getOne( $idobj ) );
			} elseif ( get_class($array['pregnancy'] == 'Pregnancy' ) {
				$this->pregnancy = $array['pregnancy'];
			} else {
				throw new \Exception ("Array pregnancy is not id or Pregnancy object");
			}
			