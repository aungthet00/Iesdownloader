<?php

function calculate_output($candela_val, $lamp_fact, $cri, $cct, $fix_fact = NULL)
{
	$value = $candela_val * $lamp_fact * $cri * $cct;
	$value *= ($fix_fact) ? $fix_fact : 1;

	return number_format($value, 1, ".", "");
}