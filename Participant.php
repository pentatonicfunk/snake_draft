<?php

class Participant {

	private $id   = 0;
	private $name = '';

	public function __construct( int $id, string $name ) {
		$this->id   = $id;
		$this->name = $name;
	}

	public function getName(): string {
		return $this->name;
	}

	public function toArray() {
		return [
			'id'   => $this->id,
			'name' => $this->name,
		];
	}
}
