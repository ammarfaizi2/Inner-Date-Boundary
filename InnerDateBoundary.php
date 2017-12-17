<?php

/** 
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class InnerDateBoundary
{
	/**
	 * @var array
	 */
	private $bound = [];

	/**
	 * @var string
	 */
	private $delimeter;

	/**
	 * @var array
	 */
	private $result = [];

	/**
	 * Constructor
	 *
	 * @param string ...$argv
	 */
	public function __construct(...$argv)
	{
		$this->bound = $argv;
	}

	private function explodeDate()
	{
		foreach ($this->bound as &$val) {
			$val = explode($this->delimeter, $val);
			if (sizeof($val) !== 2) {
				throw new \Exception("Invalid boundary!", 1);
			}
			self::getDiffList($val);
		}
	}

	private static function getDiffList(&$val)
	{
		$sv = $val;
		$tmp = [];
		if ($sv[0] > $sv[1]) {
			$tmp[] = $sv[1];
			while ($sv[1] !== $sv[0]) {
				$sv[1] = $tmp[] = date("Y-m-d", strtotime($sv[1]."+ 1 day"));
			}
		} elseif ($sv[0] < $sv[1]) {
			$tmp[] = $sv[0];
			while ($sv[1] !== $sv[0]) {
				$sv[0] = $tmp[] = date("Y-m-d", strtotime($sv[0]."+ 1 day"));
			}
		}
		$val = $tmp;
	}

	private function getUnique()
	{
		$saver = []; $completer = [];
		foreach ($this->bound as $key => $val) {
			foreach ($val as $subval) {
				$completer[] = $saver[$key][] = $subval;
			}
		}
		foreach ($completer as $val) {
			$flag = true;
			foreach ($saver as $subval) {
				if (! in_array($val, $subval)) {
					$flag = false;
					break;
				}
			}
			$flag and !in_array($val, $this->result) and $this->result[] = $val;
		}
		
	}

	public function getResult()
	{
		return $this->result;
	}

	/**
	 * @return bool
	 */
	public function execute()
	{
		$this->explodeDate();
		$this->getUnique();
	}

	/**
	 * @param string $delimeter
	 */
	public function setDelimeter($delimeter)
	{
		$this->delimeter = $delimeter;
	}
}
