<?php
function findByPregnancyId( $p_id ) {
	return new DeferredLaborSignCollection( $this, $this->selectByPregnancyStmt, array($s_id));
}