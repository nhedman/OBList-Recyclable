<?php
interface Billable
{
public function getBilledDate();

public function setBilledDate();

public function markBilled();

public function markUnbilled();

public function isBilled();
}